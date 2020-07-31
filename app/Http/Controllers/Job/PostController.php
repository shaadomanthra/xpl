<?php

namespace PacketPrep\Http\Controllers\Job;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\Job\Post as Obj;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\FaceDetect;
use PacketPrep\Mail\EmailForQueuing;
use Mail;

class PostController extends Controller
{
    public function __construct(){
        $this->app      =   'job';
        $this->module   =   'post';
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
            $objs = $obj->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')
                    ->paginate(config('global.no_of_records')); 
        else
            $objs = $obj->where('user_id',$user->id)->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')
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

    public function analytics($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $obj = Obj::where('slug',$slug)->first();
        
        
        $this->authorize('view', $obj);
        
        $users = $obj->users;

        $data['colleges'] = Cache::remember('college',240,function(){
                    return College::orderBy('name')->get()->keyBy('id');
                });

        $data['branches'] = Cache::remember('branche',240,function(){
                    return Branch::orderBy('name')->get()->keyBy('id');
                });
        $data['total'] = count($users); 
        $data['college_group'] = $users->groupBy('college_id');
        $data['branch_group'] = $users->groupBy('branch_id');
        $data['yop_group'] = $users->groupBy('year_of_passing');
        $data['no_video'] = count($users->where('video',''));
        $data['video'] = $data['total'] - $data['no_video'];

        if(request()->get('sendmail_video')){
            $this->mailer($users->where('video',''));
        }


        $view ='analytics';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('users',$users)
                ->with('data',$data)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    public function applicant_index($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $obj = Obj::where('slug',$slug)->first();
        
        
        $this->authorize('view', $obj);
        
        if($request->get('export')){
            $users = $obj->users->pluck('id')->toArray();
            $objs = User::whereIn('id',$users)->paginate(10000);
            $colleges = College::all()->keyBy('id');
            $branches = Branch::all()->keyBy('id');

            request()->session()->put('users',$objs);
                request()->session()->put('colleges',$colleges);
                request()->session()->put('branches',$branches);
                $name = "Applicants_job_".$obj->slug.".xlsx";
                ob_end_clean(); // this
                ob_start(); 
                return Excel::download(new UsersExport, $name);

            // if($objs->total() <= 500){
                
            // }else{
            //     flash('Data more than 500 records has to be queued. Kindly contact administrator')->success();
            // }
            
        } else{
            $objs = $obj->users()->where('name','LIKE',"%{$item}%")->orderBy('pivot_created_at','desc')->paginate(config('global.no_of_records')); 
        } 

        $view = $search ? 'applicant_list': 'applicant_index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function mailer($users){
        

        foreach($users as $i=>$u){
            $details['email'] = $u->email;
            $details['name'] = $u->name;

            //Mail::to($details['email'])->send(new EmailForQueuing($details));
            SendEmail::dispatch($details)->delay(now()->addSeconds($i*1));
        }
        
        dd('Email Queued - '.count($users));
        return view('home');
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

        $this->education = ['BTECH','MTECH','DEGREE','CSE','IT','EEE','MECH','ECE','CIVIL','BCOM','BSC','BBA','MBA','BPHARM','MPHARM'];
        $this->salary =['NOT DISCLOSED','0 to 3LPA', '3 to 6LPA','6 to 9LPA', '1.8LPA to 13LPA'];
        $this->location = ['ALL INDIA','HYDERABAD','BENGALURE','CHENNAI','MUMBAI','PUNE','DELHI'];
        $this->yop = ['2016','2017','2018','2019','2020','2021'];
        $this->academic = ['55','60','65','70','75'];

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',1)
                ->with('obj',$obj)
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

            /* locations */
            if(isset($request->all()['locations'])){
                $location = implode(',', $request->all()['locations']);
                $request->request->add(['location' => $location]);
            }

            /* educations */
            if(isset($request->all()['educations'])){
                $education = implode(',', $request->all()['educations']);
                $request->request->add(['education' => $education]);
            }

            /* year of passing */
            if($request->get('yops')){
                $yop = implode(',', $request->get('yops'));

                $request->request->add(['yop' => $yop]);
            }

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = 'job_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file_'),$filename);

                $request->merge(['image' => $path]);
            }
            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];
                $filename = 'job_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file2_'),$filename);

                $request->merge(['image' => $path]);
            }

            if(!$request->all()['last_date']){
                $last_date = \carbon\carbon::now()->addDays(3);
                $request->merge(['last_date' => $last_date]);
            }

            $details = summernote_imageupload(\auth::user(),$request->details);
            $request->merge(['details' => $details]);

            $obj = $obj->create($request->all());

            Cache::forever('post_'.$obj->id,$obj);

            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Obj::where('slug',$id)->withCount('users')->first();
        $latest = $obj->users()->orderBy('pivot_created_at','desc')->limit(5)->get();
        $branches = Branch::all()->keyBy('id');

        $this->authorize('view', $obj);

        if(request()->get('delete')){
            if(Storage::disk('public')->exists('post/job_b_'.$obj->slug.'.jpg'))
                    Storage::disk('public')->delete('post/job_b_'.$obj->slug.'.jpg');
            if(Storage::disk('public')->exists('post/job_b_'.$obj->slug.'.png'))
                    Storage::disk('public')->delete('post/job_b_'.$obj->slug.'.png');
        }
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('latest',$latest)->with('app',$this)->with('branches',$branches);
        else
            abort(404);
    }

    public function public_show($id,Request $request)
    {
        $obj = Cache::remember('post_'.$id,240,function() use($id){
            return Obj::where('slug',$id)->first();
        });

        if(!$obj->status)
            abort('403','Unauthorized Access');

        if($request->get('apply')==1){
            $user = \auth::user();
            if($user){
                if(!$obj->users->contains($user->id)){
                    $obj->users()->attach($user->id,['created_at'=>date("Y-m-d H:i:s")]);
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

        $this->education = ['BTECH','MTECH','DEGREE','CSE','IT','EEE','MECH','ECE','CIVIL','BCOM','BSC','BBA','MBA','BPHARM','MPHARM'];
        $this->salary =['NOT DISCLOSED','0 to 3LPA', '3 to 6LPA','6 to 9LPA','1.8LPA to 13LPA'];
        $this->location = ['ALL INDIA','HYDERABAD','BENGALURE','CHENNAI','MUMBAI','PUNE','DELHI'];
        $this->yop = ['2016','2017','2018','2019','2020','2021'];
        $this->academic = ['55','60','65','70','75'];


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',1)
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

            /* locations */
            if(isset($request->all()['locations'])){
                $location = implode(',', $request->all()['locations']);
                $request->request->add(['location' => $location]);
            }

            /* educations */
            if(isset($request->all()['educations'])){
                $education = implode(',', $request->all()['educations']);
                $request->request->add(['education' => $education]);
            }

            /* year of passing */
            if($request->get('yops')){
                $yop = implode(',', $request->get('yops'));

                $request->request->add(['yop' => $yop]);
            }

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){

                /* delete previous image */
                if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.jpg'))
                    Storage::disk('s3')->delete('post/job_'.$obj->slug.'.jpg');
                if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.png'))
                    Storage::disk('s3')->delete('post/job_'.$obj->slug.'.png');
            
                $file      = $request->all()['file_'];
                $filename = 'job_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file_'),$filename,'public');

                $request->merge(['image' => $path]);
            }

            if(isset($request->all()['file2_'])){

                /* delete previous image */
                if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.jpg'))
                    Storage::disk('s3')->delete('post/job_b_'.$obj->slug.'.jpg');
                if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.png'))
                    Storage::disk('s3')->delete('post/job_b_'.$obj->slug.'.png');

                $file      = $request->all()['file2_'];
                $filename = 'job_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file2_'),$filename,'public');

                $request->merge(['image' => $path]);
            }

            if(!$request->all()['last_date']){
                $last_date = \carbon\carbon::now()->addDays(3);
                $request->merge(['last_date' => $last_date]);
            }
            $details = summernote_imageupload(\auth::user(),$request->details);
            $request->merge(['details' => $details]);

            $this->authorize('update', $obj);
            $obj->update($request->all()); 

            Cache::forget('post_'.$obj->slug);
            Cache::forever('post_'.$obj->slug,$obj);
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
