<?php

namespace PacketPrep\Http\Controllers\dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;

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
        if(request()->route('project')){
            $this->project = Project::get(request()->route('project'));
        } 

    }

    public function index(Category $category)
    {
        $parent =  Category::where('slug',$this->project->slug)->first();   
        $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();
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
                ->with('nodes',$nodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $parent =  Category::where('slug',$this->project->slug)->first();  
        $select_options = $category->displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree());
        return view('appl.dataentry.category.createedit')
                ->with('project',$this->project)
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

        $request->slug = str_replace(' ', '-', $request->slug);
        $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
        $parent = Category::where('id','=',$request->parent_id)->first();
        $child = new Category($child_attributes);

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

        $parent = Category::getParent($node);
        if(!$parent){
            $parent = new category;
            $parent->id=null;
        }
        //dd('done');

        $select_options = Category::displaySelectOption(Category::defaultOrder()->descendantsOf($root->id)->toTree(),
            [   'select_id'     =>  $parent->id,
                'disable_id'    =>  $node->id,
            ]
        );


        if($node)
            return view('appl.dataentry.category.createedit')
                    ->with('project',$this->project)
                    ->with('category',$node)
                    ->with('parent',$parent)
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
    public function destroy($project_slug, $category_slug)
    {
        $node = Category::where('slug',$category_slug)->first();
        $node->delete();
        flash('Category ('.$category_slug.')Tree Successfully deleted!')->success();
        return redirect()->route('category.index',$project_slug);
    }
}
