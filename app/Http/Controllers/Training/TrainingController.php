<?php

namespace PacketPrep\Http\Controllers\Training;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\Training\Training as Obj;
use PacketPrep\Models\User\Role;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    
    public function __construct(){
        $this->app      =   'training';
        $this->module   =   'training';
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);

        $search = $request->search;
        $item = $request->item;
        $user =\auth::user();
        if($user->isAdmin())
            $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records')); 
        else if($user->checkRole(['hr-manager']))
            $objs = $obj->where('trainer_id',$user->id)->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records')); 
        else
            $objs = $obj->where('user_id',$user->id)->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records')); 
        $view = $search ? 'list': 'index';

        

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function public_index(Obj $obj,Request $request)
    {


        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'public_list': 'public_index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    public function applicant_index($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $obj = Obj::where('slug',$slug)->first();

        $users = $obj->users->pluck('id')->toArray();

        
        $this->authorize('view', $obj);
        $objs = User::whereIn('id',$users)->where('name','LIKE',"%{$item}%")
                    ->paginate(config('global.no_of_records')); 

        if($request->get('export')){
            request()->session()->put('users',$objs);
            $name = "Applicants_job_".$obj->slug.".xlsx";
            ob_end_clean(); // this
            ob_start(); 
            return Excel::download(new UsersExport, $name);
        }  

        if($request->get('remove')){
            $uid = $request->get('remove');
            $obj->users()->detach($uid);
            flash('User removed from the training')->error();
            return redirect()->route($this->module.'.students',$obj->slug);
        }

        $view = $search ? 'applicant_list': 'applicant_index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $this->authorize('create', $obj);
        $slug = rand(10000,100000);
        $e = Obj::where('slug',$slug)->first();

        if($e){
            $slug = rand(10000,100000);
        }


        $user = \auth::user();
        $tpos = Role::where('slug','tpo')->first();
        $all_tpos = $tpos->pluck('id')->toArray();

        $client_slug = subdomain();

        $tpo = User::where('client_slug',$client_slug)->whereIn('id',$all_tpos)->get();

        $hr_managers = Role::where('slug','hr-manager')->first()->users;
        $all_hrs = $hr_managers->pluck('id')->toArray();

        $hr_manager = User::where('client_slug',$client_slug)->whereIn('id',$all_hrs)->get();

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('editor',1)
                ->with('jqueryui',1)
                ->with('obj',$obj)
                ->with('tpo',$tpo)
                ->with('hr_manager',$hr_manager)
                ->with('slug',$slug)
                ->with('app',$this);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
        try{

        	if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];
                $filename = 'training_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file2_'),$filename);

                $request->merge(['image' => $path]);
            }

            if(!request()->get('tpo_id')){
                $request->merge(['tpo_id' => 1]);
            }

            if(!request()->get('trainer_id')){
                $request->merge(['trainer_id' => 1]);
            }

            if($request->start_date)
                $request->merge(['start_date' => \carbon\carbon::parse($request->start_date)->format('Y-m-d H:i:s')]);
            if($request->due_date)
                $request->merge(['due_date' => \carbon\carbon::parse($request->due_date)->format('Y-m-d H:i:s')]);

            $obj = $obj->create($request->all());

            flash('A new ('.$this->app.'/'.$obj->slug.') item is created!')->success();
            return redirect()->route($this->module.'.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }

    public function participantImport(Request $request){

        $file      = $request->all()['users'];
        $slug = $request->get('slug');
        $filename = 'users_'.$request->get('slug').'.'.$file->getClientOriginalExtension();

       

        $path = Storage::disk('s3')->putFileAs('excel', $request->file('users'),$filename);
        $collection = Excel::toCollection(new UsersImport, 'excel/'.$filename,'s3');

        $obj = Obj::where('slug',$request->get('slug'))->first();
        
        $rows = $collection[0];
        foreach($rows as $key =>$row){
            
                if(!trim($row[0]))
                    break;
                
                $client_slug = subdomain();
                $u = User::where('email',$row[1])->where('client_slug',$client_slug)->first();

                $branch = array("CS"=>22,"EC"=>23,"CE"=>24,"ME"=>25,"CH"=>26,"MM"=>27);
                $college = array("RKV"=>372,"N"=>364);
                $b = (isset($branch[$row[4]]))?$branch[$row[4]]:null;
                $c = (isset($college[$row[5]]))?$college[$row[5]]:null;

                if(!$u){
                    if(strtolower($row[1])!='email'){
                        $u = new User([
                   'name'     => $row[0],
                   'email'    => $row[1], 
                   'username'    => $this->username($row[1]), 
                   'client_slug' =>$client_slug,
                   'phone'    => $row[2], 
                   'roll_number'    => $row[3], 
                   'branch_id' => $b,
                   'college_id' => $c,
                   'personality' =>$row[4],
                   'confidence' =>$row[5],
                   'year_of_passing' =>$row[6],
                   'gender' =>$row[7],
                   'password' => bcrypt($row[2]),
                   'status'   => 1,
                    ]);

                    $u->save();
                    }
                    
                }else{
                    
                    $u->info = $row[4];
                    $u->save(); 
                   
                    
                }

                // if(strtolower($row[1])!='email')
                // if(!$obj->users->contains($u->id)){
                //     $obj->users()->attach($u->id);
                // }
                
            
            // else{

            //     $row[1] = str_replace('@', 'n@', $row[1]);
            //     $u = new User([
            //    'name'     => $row[0],
            //    'email'    => $row[1], 
            //    'username'    => $obj->username($row[1]), 
            //    'client_slug' =>$client_slug,
            //    'phone'    => $row[2], 
            //    'password' => bcrypt($row[2]),
            //    'year_of_passing' => $row[3],
            //    'branch_id' => $b,
            //    'status'   => 1,
            //     ]);

            //     // $u->roll_number = $row[5];
            //     // $u->gender = $row[6];
            //     // $u->hometown = $row[7];
            //     // $u->current_city = $row[8];
            //     // $u->dob = $row[9];
            //     // $u->video = $row[10];
            //     // $u->personality = $row[11];
            //     // $u->confidence = $row[12];



            //     $u->save();

            // }

            

        }
        flash('Successfully added participants. The default password for the login is phone number')->success();
        return redirect()->route($this->module.'.show',$slug);
    }

    public function username($email){
        $parts = explode("@", $email);
        $username = $parts[0];
        $u = User::where('username',$username)->first();
        if($u){
            $username = $username.'_'.rand(100,9999);
        }
        return $username;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Obj::where('slug',$id)->first();
        $this->authorize('view', $obj);


    
        if(request()->get('delete')){
            if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.jpg'))
                    Storage::disk('public')->delete('articles/training_b_'.$obj->slug.'.jpg');
            if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.png'))
                    Storage::disk('public')->delete('articles/training_b_'.$obj->slug.'.png');
        }
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    public function public_show($id,Request $request)
    {
        $obj = Obj::where('slug',$id)->first();

        if(!$obj->status)
            abort('403','Training Page is in the draft mode');

        if($request->get('apply')==1){
            $user = \auth::user();
            if($user){
                if(!$obj->users->contains($user->id)){
                    $obj->users()->attach($user->id);
                    flash('Successfully applied the job')->success(); 
                }
                
            }
            $obj = Obj::where('slug',$id)->first();
        }

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.public_show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj= Obj::where('slug',$id)->first();
        $this->authorize('update', $obj);

        $user = \auth::user();
        $tpos = Role::where('slug','tpo')->first()->users;
        $all_tpos = $tpos->pluck('id')->toArray();

        $client_slug = subdomain();

        $tpo = User::where('client_slug',$client_slug)->whereIn('id',$all_tpos)->get();

        
        $hr_managers = Role::where('slug','hr-manager')->first()->users;
        $all_hrs = $hr_managers->pluck('id')->toArray();

        $hr_manager = User::where('client_slug',$client_slug)->whereIn('id',$all_hrs)->get();


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('tpo',$tpo)
                ->with('hr_manager',$hr_manager)
                ->with('editor',1)
                 ->with('jqueryui',1)
                ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $obj = Obj::where('slug',$id)->first();

             /* If image is given upload and store path */
            

            if(isset($request->all()['file2_'])){

                /* delete previous image */
                if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.jpg'))
                    Storage::disk('public')->delete('articles/training_b_'.$obj->slug.'.jpg');
                if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.png'))
                    Storage::disk('public')->delete('articles/training_b_'.$obj->slug.'.png');

                $file      = $request->all()['file2_'];
                $filename = 'training_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file2_'),$filename);



                $request->merge(['image' => $path]);
            }

            if($request->start_date)
                $request->merge(['start_date' => \carbon\carbon::parse($request->start_date)->format('Y-m-d H:i:s')]);
            if($request->due_date)
                $request->merge(['due_date' => \carbon\carbon::parse($request->due_date)->format('Y-m-d H:i:s')]);
            

            $this->authorize('update', $obj);
            $obj->update($request->all()); 
            flash('Job post item is updated!')->success();
            return redirect()->route($this->module.'.show',$id);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $obj = Obj::where('slug',$id)->first();
        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
