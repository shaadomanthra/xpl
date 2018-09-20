<?php

namespace PacketPrep\Http\Controllers\Course;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Category;

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
        $courses = $course->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
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
        $categories = Category::where('slug',$id)->first();

        if(request()->get('exam'))
            session(['exam' => request()->get('exam')]);

        $project = Project::where('slug',$id)->first();
        $parent =  Category::where('slug',$id)->first(); 
        $ques_count  =0; 
        $nodes = null;
        $exams = array();
        if($parent){
            $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();

            $ques_count = Category::getCategorizedQuestionCount($project);
            $exams =  Tag::where('project_id',$project->id)->where('name','exam')
                        ->orderBy('created_at','desc')->get();
                     
            if(count($node))
            $nodes = Category::displayUnorderedListCourse($node,['project'=>$project,'parent'=>$parent]);
            else
            $nodes =null;
        } 
       

        //dd($nodes);

        if($course)
            return view('appl.course.course.show')
                    ->with('course',$course)
                    ->with('ques_count',$ques_count)
                    ->with('exams',$exams)
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

        if(!\auth::user()->courses()->where('course_id',$course->id)->count())
        {
            return view('appl.course.course.access');
        }

            
        //$this->authorize('view', $course);

        $category = Category::where('slug',$category)->first();
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
