<?php

namespace PacketPrep\Http\Controllers\Training;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\Training\Training;
use PacketPrep\Models\Training\Schedule as Obj;

class ScheduleController extends Controller
{
    
    public function __construct(){
        $this->app      =   'training';
        $this->module   =   'schedule';
        if(request()->route('training')){
            $this->training = Training::where('slug',request()->route('training'))->first();
        } 
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
                    ->orderBy('sno','asc')
                    ->paginate(config('global.no_of_records')); 
        else
            $objs = $obj->where('user_id',$user->id)->where('title','LIKE',"%{$item}%")
                    ->orderBy('sno','asc')
                    ->paginate(config('global.no_of_records')); 
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function attendance(Obj $obj,Request $request,$training,$id)
    {
        $user_ids = $request->get('attendance');
        $obj = Obj::where('id',$id)->first();

        $obj->users()->detach();
        foreach($user_ids as $id){
            $obj->users()->attach($id);
        }
        

        flash('Attendance updated!')->success();
        return redirect()->route('schedule.index',$training);
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
        

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('editor',1)
                ->with('jqueryui',true)
                ->with('obj',$obj)
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

            $obj = $obj->create($request->all());

            flash('A new ('.$this->app.'/'.$obj->name.') item is created!')->success();
            return redirect()->route($this->module.'.index',$this->training->slug);
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
        $path = Storage::disk('public')->putFileAs('summernote', $request->file('users'),$filename);
        $collection = Excel::toCollection(new UsersImport, storage_path('app/public/'.$path));

        $obj = Obj::where('slug',$request->get('slug'))->first();
        
        $rows = $collection[0];
        foreach($rows as $key =>$row){

            $u = User::where('email',$row[1])->first();

            if(!$u){
                $u = new User([
               'name'     => $row[0],
               'email'    => $row[1], 
               'username'    => $this->username($row[1]), 
               'phone'    => $row[2], 
               'password' => Hash::make($row[2]),
               'status'   => 1,
                ]);
            }

            if(!$obj->users->contains($u->id)){
                $obj->users()->attach($u->id);
            }

        }
        flash('Successfully added participants. The default password for the login is phone number')->success();
        return redirect()->route($this->module.'.show',$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($training,$schedule)
    {
        $obj = Obj::where('id',$schedule)->first();
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
    public function edit($training,$id)
    {
        $obj= Obj::where('id',$id)->first();
        $this->authorize('update', $obj);

        


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
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
    public function update($training,$id,Request $request)
    {
        try{
            $obj = Obj::where('id',$id)->first();

            

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

            

            $this->authorize('update', $obj);
            $obj->update($request->all()); 
            flash('Schedule item is updated!')->success();
            return redirect()->route($this->module.'.index',$training);
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
     public function destroy($training,$id)
    {
        $obj = Obj::where('id',$id)->first();

        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index',$training);
    }
}
