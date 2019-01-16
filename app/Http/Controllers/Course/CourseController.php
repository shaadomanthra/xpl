<?php

namespace PacketPrep\Http\Controllers\Course;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Order;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Examtype;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course,Request $request)
    {
        //$this->authorize('view', $course);

        $search = $request->search;
        $item = $request->item;
        $courses = $course->where('name','LIKE',"%{$item}%")->orderBy('created_at','asc')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';



        return view('appl.course.course.'.$view)
        ->with('courses',$courses)->with('course',new Course());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = new Course();
        $this->authorize('create', $course);

        return view('appl.course.course.createedit')
                ->with('stub','Create')
                ->with('editor','true')
                ->with('course',$course);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course,Request $request)
    {

        try{

            //dd($request->all());

            $request->merge(['slug' => str_replace(' ', '-', $request->slug)]);
            $course = Course::create($request->all());

            // save category
            /*
            $category = new Category;
            $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
            $child = new Category($child_attributes);
            $child->save();*/

            flash('A new Course('.$request->name.') is created!')->success();
            return redirect()->route('course.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $course = Course::where('slug',$id)->first();
        $product = $course->products->first();
        

        $user = \Auth::user();
        $entry=null;
        if($user)
        foreach($course->products as $product)
        {
            if($product->users()->find($user->id)){
                $entry = DB::table('product_user')
                    ->where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->first();
            }
            
        }
        

       // dd($user->courses()->find($course->id));
        $categories = Category::where('slug',$id)->first();

        if(request()->get('exam'))
            session(['exam' => request()->get('exam')]);

        $project = Project::where('slug',$id)->first();
        $parent =  Category::where('slug',$id)->first(); 

        //$x = $parent->questionCount_level2($project);

        $ques_count  = 0; 
        $nodes = null;
        $exams = array();

        $examtype = Examtype::where('slug',$id)->first();
        if($examtype)
        $exams = Exam::where('examtype_id',$examtype->id)->get();
        else{

            $exams = Exam::where('slug','LIKE',"%{$course->slug}%")->get();
            
        }

        $course->keywords = $course->name;
        $course->description = strip_tags($course->description);
        if($parent){
            $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();

            foreach($node as $n){
                $course->keywords = $course->keywords.', '.$n->name;
            }

            

            $url = url()->full();
            $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $domain = $exploded[0];

            $file_count = '../static/'.$domain.'_'.$course->slug.'_count.txt';
            $file_nodes = '../static/'.$domain.'_'.$course->slug.'_nodes.txt';
            

            if(request()->get('refresh'))
            {

                $ques_count = $parent->questionCount_level2($project);
                file_put_contents($file_count,$ques_count);
                $nodes = Category::displayUnorderedListCourse($node,['project'=>$project,'parent'=>$parent]);

                file_put_contents($file_nodes,$nodes);
            }

            if(!file_exists($file_count)){
                $ques_count = $parent->questionCount_level2($project);
                file_put_contents($file_count,$ques_count);
            }
            else{
                $ques_count = file_get_contents($file_count);
            }

            
            //$exams =  Tag::where('project_id',$project->id)->where('name','exam')
              //          ->orderBy('created_at','desc')->get();
                     
            if(count($node)){
                if(!file_exists($file_nodes)){
                     $nodes = Category::displayUnorderedListCourse($node,['project'=>$project,'parent'=>$parent]);
                    file_put_contents($file_nodes,$nodes);
                }
                else{
                    $nodes = file_get_contents($file_nodes);
                }

            }
            else
                $nodes =null;
        } 
       

        //dd($nodes);

        if($course)
            return view('appl.course.course.show')
                    ->with('course',$course)
                    ->with('product',$product)
                    ->with('ques_count',$ques_count)
                    ->with('exams',$exams)
                    ->with('project',$project)
                    ->with('entry',$entry)
                    ->with('nodes',$nodes);
        else
            abort(404);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function video($course,$category)
    {

        $course = Course::where('slug',$course)->first();

        $user = \Auth::user();
        $entry=null;
        if($user)
        foreach($course->products as $product)
        {
            if($product->users()->find($user->id)){
                $entry = DB::table('product_user')
                    ->where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->first();
                 $p = $product;   
            }
            
        }
        $category = Category::where('slug',$category)->first();
        //dd($category);

        if(!youtube_video_exists($category->video_link))
        if(!$entry || $p->validityExpired())
        {
            return view('appl.course.course.access');
        }

        
        

            
        //$this->authorize('view', $course);

        
        $parent = Category::getParent($category);
        
        foreach($parent->descendants as $k => $item){
            if($item->slug ==$category->slug)
            {
                if($k==0)
                {
                    $prev = null;
                    if(isset($parent->descendants[$k+1]))
                    $next = $parent->descendants[$k+1];
                    else
                        $next =null;
                }elseif($k == (count($parent->descendants)-1)){
                    $prev = $parent->descendants[$k-1];
                    $next = null;
                }
                else{
                    $prev = $parent->descendants[$k-1];
                    $next = $parent->descendants[$k+1];
                }


            }
        }

        if($course)
            return view('appl.course.course.video')
                ->with('course',$course)
                ->with('category',$category)
                ->with('parent',$parent)
                ->with('next',$next)
                ->with('prev',$prev);
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
        $course = Course::where('slug',$id)->first();
        

        $this->authorize('update', $course);


        if($course)
            return view('appl.course.course.createedit')
                ->with('stub','Update')
                ->with('editor','true')
                ->with('course',$course);
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
            $request->slug = str_replace(' ', '-', $request->slug);
            $course = Course::where('id',$id)->first();

            $this->authorize('update', $course);

            /*
            $category = Category::where('slug',$course->slug)->first();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save(); */

            $course->name = $request->name;
            $course->slug = $request->slug;
            $course->intro_youtube = $request->intro_youtube;
            $course->intro_vimeo = $request->intro_vimeo;
            $course->description = $request->description;
            $course->weightage_min = $request->weightage_min;
            $course->weightage_avg = $request->weightage_avg;
            $course->weightage_max = $request->weightage_max;
            $course->price = $request->price;
            $course->important_topics = $request->important_topics;
            $course->reference_books = $request->reference_books;
            $course->status = $request->status;
            $course->image = $request->image;
            $course->save(); 

            flash('Course (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('course.show',$request->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $course = Course::where('id',$id)->first();
        $this->authorize('update', $course);
        /*
        $node = Category::where('slug',$course->slug)->first();
        $node->delete();*/
        $course->delete();
        flash('Course Successfully deleted!')->success();
        return redirect()->route('course.index');
       
    }
}
