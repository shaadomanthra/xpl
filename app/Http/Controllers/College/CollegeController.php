<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\College as Obj;
use PacketPrep\Models\College\Zone;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\Metric;
use PacketPrep\Models\Course\Course;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class CollegeController extends Controller
{
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'college';
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
        
        $student_count = array();
        $all_colleges = $obj->all();
        $colleges_zone = $all_colleges->groupBy('college_website');
        Cache::forever('colleges',$all_colleges->keyBy('id'));
        Cache::forever('colleges_zone',$all_colleges->groupBy('college_website'));

        if($request->get('zone')){
            $colleges = $obj->where('college_website',$request->get('zone'))->get();
            $objs = $obj->where('name','LIKE',"%{$item}%")->where('college_website',$request->get('zone'))->paginate(200); 
            $lusers= User::select('college_id')->whereIn('college_id',$objs->pluck('id')->toArray())->where('year_of_passing',2023)->get()->groupby('college_id');
        }
        else{
            $colleges = $obj->all();
            $objs = $obj->where('name','LIKE',"%{$item}%")->paginate(200); 
            $lusers= User::select('college_id')->whereIn('college_id',$objs->pluck('id')->toArray())->where('year_of_passing',2023)->get()->groupby('college_id');
        }

        $carray = $colleges->pluck('id')->toArray();
        $data['engineering'] = $colleges->where('type','btech')->count();
        $data['degree'] = $colleges->where('type','degree')->count();
        $data['users'] = User::select('college_id')->whereIn('college_id',$carray)->where('year_of_passing',2023)->count();
        $zones = Obj::select('college_website')->distinct()->get();    
        $view = $search ? 'list': 'index';


        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('data',$data)
                ->with('zones',$zones)
                ->with('lusers',$lusers)
                ->with('colleges_zone',$colleges_zone)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function top30(Obj $obj,Request $request)
    {

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }


        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->where('name','LIKE',"%{$item}%")->where('type','btech')->where('name','!=','- Not in List -')->withCount('users')->orderBy('users_count', 'desc')->limit(30)->get(); 

        

        //dd($objs);
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.top30')
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }
    

    public function uploadColleges(Obj $obj,Request $request)
    {
        if(isset($request->all()['file'])){
                
                $file      = $request->all()['file'];
                $fname = str_replace(' ','_',strtolower($file->getClientOriginalName()));
                $extension = strtolower($file->getClientOriginalExtension());

                if(!in_array($extension, ['csv'])){
                    $alert = 'Only CSV files are allowed';
                    return redirect()->route($this->module.'.upload')->with('alert',$alert);
                }

                 $file_path = Storage::disk('public')->putFileAs('excels', $request->file('file'),$fname,'public');
                 $fpath = Storage::disk('public')->path($file_path);

                 $row = 1;
                 
                if (($handle = fopen($fpath, "r")) !== FALSE) {
                  while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
               
                    $num = count($data);
                    $row++;
                    $cname = $data[0];
                    $col = Obj::where('name',$cname)->first();

                    if(!$col){
                        $col = new Obj();
                        $col->name = ucwords(strtolower($cname));
                        $col->type = $data[1];
                        $col->location = $data[2];
                        $col->college_website = $data[3];
                        $col->save();
                    }else{
                        $col->name = ucwords(strtolower($cname));
                        $col->type = $data[1];
                        $col->location = ucfirst($data[2]);
                        $col->college_website = ucfirst($data[3]);
                        $col->save();
                    }
                    
                  }
                  fclose($handle);
                }


                $alert = 'Data Records Added!';
                return redirect()->route($this->module.'.upload')->with('alert',$alert);
            }
            else{
                return view('appl.'.$this->app.'.'.$this->module.'.upload')
                    ->with('stub','Create')
                    ->with('obj',$obj)
                    ->with('editor',true)
                    ->with('app',$this);

            }
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
        $zones = Zone::all();
        $branches = Branch::all();
        $courses = Course::all();


        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('zones',$zones)
                ->with('branches',$branches)
                ->with('courses',$courses)
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

            $zone_id = $request->get('zone_id');
            $branches = $request->get('branches');


            $obj = $obj->create($request->except(['zone_id','branches']));

            //branches
            $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
            if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    if(!$obj->branches->contains($branch))
                        $obj->branches()->attach($branch);
                }else{
                    if($obj->branches->contains($branch))
                        $obj->branches()->detach($branch);
                }
                
            }else{
                $obj->branches()->detach();
            } 

            //zone

            if(!$obj->zones->contains($zone_id))
                $obj->zones()->attach($zone_id);

            $courses = $request->get('courses');
            if($courses){
                $obj->courses()->detach();
                foreach($courses as $course){
                    if(!$obj->courses->contains($course))
                        $obj->courses()->attach($course);
                }
            }else{
                $obj->courses()->detach();
            }

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
        $obj = Obj::where('id',$id)->first();

        $users = $obj->users->groupBy('year_of_passing');
        unset($users[""]);

        //dd($obj->users);
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('users',$users)
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }


    public function analysis(Request $request)
    {


        //$slug = subdomain();
        //$client = client::where('slug',$slug)->first();
        //$this->authorize('view', $client);

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }


        $users = new CollegeController;
        $users->total = User::count();

        $amb = User::whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador');
                            })->get();

        $i=0;
        foreach($amb as $k => $u){
            if($u->referrals()->count()>49)
                $i++;
        }

        $users->ambassadors = $i;

        $metrics = Metric::all();
        $branches = Branch::all();
        $zones = Zone::all();
        

        return view('appl.'.$this->app.'.'.$this->module.'.analysis')
                    ->with('users',$users)
                    ->with('metrics',$metrics)
                    ->with('branches',$branches)
                    ->with('zones',$zones);
        
    }




    public function show2($id,Request $request)
    {
        $obj = Obj::where('id',$id)->first();
        $this->authorize('view', $obj);

        $branches = $obj->branches()->orderBy('id')->get();
        $users = $obj->users()->with('branch')->get();

        $data = array();
        $data['branches'] = $users->groupBy('branch_id');


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show3')
                    ->with('college',$obj)->with('app',$this)
                    ->with('obj',$obj)->with('app',$this)
                    ->with('data',$data)
                    ->with('branches',$branches);
        else
            abort(404);
    }



    public function students($id,Request $request)
    {
        $obj = Obj::where('id',$id)->first();
        $branch = $request->get('branch');
        $metric= $request->get('metric');
        $m = Metric::where('name',$metric)->first();
        $b = Branch::where('name',$branch)->first();
        $users = $obj->users()->get();



        $obj_users = $obj->users()->pluck('id')->toArray();
        
        if($branch){
            $branch_users = $b->users()->pluck('id')->toArray();
            $u= array_intersect($obj_users,$branch_users);
            $users = User::whereIn('id',$u)->paginate(config('global.no_of_records'));
             $total = count($u);
        }

        if($metric){
            $metric_users = $m->users()->pluck('id')->toArray();
            $u= array_intersect($obj_users,$metric_users);
            $users = User::whereIn('id',$u)->paginate(config('global.no_of_records'));
             $total = count($u);
        }

        if(!$metric && !$branch)
        {
            $total = count($obj_users);
            $users = $obj->users()->paginate(config('global.no_of_records'));
        }



        
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.student')
                    ->with('obj',$obj)->with('app',$this)->with('users',$users)->with('total',$total)->with('metric',$m)->with('branch',$b);
        else
            abort(404);
    }


    public function userlist($id)
    {
        $obj = Obj::where('id',$id)->first();
        $branches = Branch::all()->keyBy('id');
        if(request()->get('yop')){
            $users = User::where('college_id',$obj->id)
                        ->where('year_of_passing',request()->get('yop'))
                        ->get();
        }else
            $users = $obj->users;
        
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.userlist')
                    ->with('college',$obj)->with('branches',$branches)
                    ->with('users',$users)
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
        $obj= Obj::where('id',$id)->first();
        $this->authorize('update', $obj);
        $zones = Zone::all();
        $branches = Branch::all();
        $courses = Course::all();


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('branches',$branches)
                ->with('zones',$zones)
                ->with('courses',$courses)
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
            $obj = Obj::where('id',$id)->first();

            $this->authorize('update', $obj);

            $zone_id = $request->get('zone_id');
            $branches = $request->get('branches');

            //branches
            $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
            if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    if(!$obj->branches->contains($branch))
                        $obj->branches()->attach($branch);
                }else{
                    if($obj->branches->contains($branch))
                        $obj->branches()->detach($branch);
                }
                
            }else{
                $obj->branches()->detach();
            } 

            $courses = $request->get('courses');
            if($courses){
                $obj->courses()->detach();
                foreach($courses as $course){
                    if(!$obj->courses->contains($course))
                        $obj->courses()->attach($course);
                }
            }else{
                $obj->courses()->detach();
            }


            //zone
            $obj->zones()->detach();
            if(!$obj->zones->contains($zone_id))
                $obj->zones()->attach($zone_id);

            $obj = $obj->update($request->except(['zone_id','branches'])); 
            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
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
        $obj = Obj::where('id',$id)->first();
        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
