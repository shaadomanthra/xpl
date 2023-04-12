<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Exam\Exam;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $project;
    

    public function __construct(){
        $this->project='';
        $this->cache_path =  '../storage/app/cache/questions/';
        if(request()->route('project')){
            $this->project = Project::get(request()->route('project'));
        } 

    }

    public function index(Category $category)
    {
        $parent =  Category::where('slug',$this->project->slug)->first();   
        $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();

        $this->authorize('view', $category);

        $question = Question::where('project_id',$this->project->id)->orderBy('created_at','desc')->first();
        if($question)
            $question->count  = Question::getTotalQuestionCount($this->project);
        //$node = Category::defaultOrder()->get()->toTree();
        if(count($node))
            $nodes = $category->displayUnorderedList($node,['project'=>$this->project]);
        else
            $nodes =null;

        return view('appl.dataentry.category.index')
                ->with('project',$this->project)
                ->with('question',$question)
                ->with('category',$category)
                ->with('nodes',$nodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $this->authorize('create', $category);

        $parent =  Category::where('slug',$this->project->slug)->first();
 
 

        $course = Course::where('slug',$this->project->slug)->first(); 
        if($course) 
            $exams = Exam::where('course_id',$course->id)->get();
        else
            $exams = null;
        $select_options = $category->displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree());
        return view('appl.dataentry.category.createedit')
                ->with('project',$this->project)
                ->with('exams',$exams)
                ->with('editor','true')
                ->with('select_options',$select_options)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Category $category)
    {

        if(!$request->slug )
            $request->slug  = $request->name;
        
        if(!$request->exam_id)
        $category->exam_id = null;

        $request->slug = strtolower(str_replace(' ', '-', $request->slug));
        $child_attributes =['name'=>$request->name,'slug'=>$request->slug,'project_id'=>$this->project->id,'video_link'=>$request->video_link,'video_desc'=>$request->video_desc,'video_keywords'=>strip_tags($request->video_keywords),'pdf_link'=>$request->pdf_link,'test_link'=>$request->test_link,'exam_id'=>$request->exam_id];
        $parent = Category::where('id','=',$request->parent_id)->first();
        $child = new Category($child_attributes);

        $this->authorize('update', $parent);

        $slug_exists_test = Category::where('slug','=',$request->slug)->first();

        if($slug_exists_test)
        {
            flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();;
        }

        if($request->parent_id!='0')
            $parent->appendNode($child);
        else
            $child->save();
        flash('A new category('.$request->name.') is created!')->success();
        return redirect()->route('category.index',$request->project_slug);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_slug,$category_slug, Request $request)
    {

        
        if($category_slug=='uncategorized')
            return redirect()->route('category.index',$project_slug);

        $category = Category::where('slug',$category_slug)->first();
        $parent = Category::getParent($category);

        
        if($request->get('store_session')){
            $request->session()->put('topic_id', $category->id);
            $request->session()->put('module_id', $parent->id); 
            if($parent->getParent($parent)){
                $request->session()->put('course_id', $parent->getParent($parent)->id); 
                $request->session()->put('course_name', $parent->getParent($parent)->name); 
                $request->session()->put('course_slug', $parent->getParent($parent)->slug);
            }
            

            $request->session()->put('topic_name', $category->name);
            $request->session()->put('module_name', $parent->name); 
            $request->session()->put('module_slug', $project_slug); 
            
              
        }

        

        $this->authorize('view', $parent);

        $order = $request->get('order');
        
        if($order=='up')
            $category->up();
        elseif($order=='down')
            $category->down();

        if($parent){
            $firstchild = Category::defaultOrder()->descendantsOf($parent->id)->first();
            $first = $firstchild;


            $list ='<ul class="sortable">';
            do{
                ($category_slug==$firstchild->slug) ? $class = ' class="current" ' : $class = ' ' ;
                    
                $list= $list.'<li '.$class.' data-slug="'.$firstchild->slug.'"><a href="'.route('category.show',
                [   
                    'category'=> $firstchild->slug,
                    'project'=> $project_slug,
                ]).'">'.$firstchild->name.'</a></li>';

            }while($firstchild =$firstchild->getNextSibling());
            
            $list=$list."</ul>";

            if(count($first->getSiblings())==0)
                $list = null;
             
        }else{
            $siblings = $category::defaultOrder()->withDepth()->having('depth', '=', 0)->get();

            $list ="<ul class='sortable'>";
             foreach($siblings as $child){
                ($category_slug==$child->slug) ? $class = ' class="current" ' : $class = ' ' ;
                $list= $list.'<li '.$class.' data-slug="'.$child->slug.'"><a href="'.route('category.show',
                [   
                    'category'=> $child->slug,
                    'project'=> $project_slug,
                ]).'">'.$child->name.'</a></li>';
             }
                
            $list=$list."</ul>";

            if(count($siblings)<2 )
                $list =null;

        }


        if($category)
            return view('appl.dataentry.category.show')
                    ->with('project',$this->project)
                    ->with('category',$category)
                    ->with('parent',$parent)
                    ->with('list',$list)
                    ->with('jqueryui',true);
        else
            abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_slug,$category_slug)
    {
       
        $node = Category::where('slug',$category_slug)->first();
        $root = Category::where('slug',$project_slug)->first();

        $this->authorize('update', $node);

        $course = Course::where('slug',$this->project->slug)->first(); 
        if($course) 
        $exams = Exam::where('course_id',$course->id)->get();
        else
            $exams = null;

        $parent = Category::getParent($node);
        if(!$parent){
            $parent = new category;
            $parent->id=null;
        }
        //dd('done');

        $select_options = Category::displaySelectOption(Category::defaultOrder()->descendantsAndSelf($root->id)->toTree(),
            [   'select_id'     =>  $parent->id,
                'disable_id'    =>  $node->id,
            ]
        );


        if($node)
            return view('appl.dataentry.category.createedit')
                    ->with('project',$this->project)
                    ->with('exams',$exams)
                    ->with('category',$node)
                    ->with('parent',$parent)
                    ->with('editor','true')
                    ->with('select_options',$select_options)
                    ->with('stub','Update');
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
    public function update(Request $request, $project_slug, $category_slug)
    {

        // get the base category and parent       
        $category = Category::where('slug',$category_slug)->first();
        $new_parent = Category::where('id',$request->parent_id)->first();
        // change the parent
        $new_parent->appendNode($category);

        //get the new reference to the category item
        $category = Category::where('slug',$category_slug)->first();
        //update category details 
        $category->name = $request->name;
        $category->slug = str_replace(' ', '-', $request->slug);
        $category->project_id = $this->project->id;
        $category->video_link = $request->video_link;
        $category->video_keywords = strip_tags($request->video_keywords);
        $category->pdf_link = $request->pdf_link;
        $category->test_link = $request->test_link;
        if($request->exam_id)
        $category->exam_id = $request->exam_id;
        else
        $category->exam_id = null;
        $category->video_desc = $request->video_desc;
        $category->save();

        flash('Category(<b>'.$request->name.'</b>) successfully updated!')->success();
        return redirect()->route('category.show',[   
                    'category'=> $category_slug,
                    'project'=> $project_slug,
                ]);
        
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cache($project_slug, $category_slug)
    {
        $category = Category::where('slug',$category_slug)->first();
        $questions = $category->questions;
        foreach($questions as $k=>$q){
            if($q->passage){
                $questions[$k]['passage'] = $q->passage->passage;
            }
            
        }

        $filename = $category->slug.'.json';
        $filepath = $this->cache_path.$filename;
        Storage::disk('s3')->put('questions/'.$filename, json_encode($questions,JSON_PRETTY_PRINT));
        //file_put_contents($filepath, json_encode($questions,JSON_PRETTY_PRINT));

        flash('Category ('.$category_slug.')Tree Successfully Cached')->success();
        return redirect()->route('category.index',$project_slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_slug, $category_slug)
    {
        $node = Category::where('slug',$category_slug)->first();
        $node->delete();
        flash('Category ('.$category_slug.')Tree Successfully deleted!')->success();
        return redirect()->route('category.index',$project_slug);
    }
}
