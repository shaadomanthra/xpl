<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Structure;


class structureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $repo;
    

    public function __construct(){
        $this->repo='';
        if(request()->route('repository')){
            $this->repo = Repository::get(request()->route('repository'));
        } 

    }

    public function index(Structure $struct)
    {
        $parent =  Structure::where('slug',$this->repo->slug)->first();   
        $node = Structure::defaultOrder()->descendantsOf($parent->id)->toTree();

        $this->authorize('view', $struct);

        /*
        $question = Question::where('repo_id',$this->repo->id)->orderBy('created_at','desc')->first();
        if($question)
            $question->count  = Question::getTotalQuestionCount($this->repo); */
        
        if(count($node))
            $nodes = $struct->displayUnorderedList($node,['repo'=>$this->repo]);
        else
            $nodes =null;

        return view('appl.library.structure.index')
                ->with('repo',$this->repo)
                ->with('question',null)
                ->with('struct',$struct)
                ->with('nodes',$nodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Structure $struct,Request $request)
    {
        $this->authorize('create', $struct);

        if($request->type)
            $type = $request->type;
        else
            $type = 'chapter';

        $parent =  Structure::where('slug',$this->repo->slug)->first();  
        $select_options = $struct->displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree(),['type'=>$type]);
        return view('appl.library.structure.createedit')
                ->with('repo',$this->repo)
                ->with('select_options',$select_options)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Structure $struct)
    {

        $request->slug = str_replace(' ', '-', $request->slug);
        $child_attributes =['name'=>$request->name,'slug'=>$request->slug,'type'=>$request->type];
        $parent = Structure::where('id','=',$request->parent_id)->first();
        $child = new Structure($child_attributes);

        $this->authorize('update', $parent);

        $slug_exists_test = Structure::where('slug','=',$request->slug)->first();

        if($slug_exists_test)
        {
            flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();;
        }

        if($request->parent_id!='0')
            $parent->appendNode($child);
        else
            $child->save();
        flash('A new Structure('.$request->name.') is created!')->success();
        return redirect()->route('structure.index',$request->repo_slug);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($repo_slug,$struct_slug, Request $request)
    {

        if($struct_slug=='uncategorized')
            return redirect()->route('Structure.index',$repo_slug);

        $struct = Structure::where('slug',$struct_slug)->first();
        $parent = Structure::getParent($struct);

        $this->authorize('view', $parent);

        $order = $request->get('order');
        
        if($order=='up')
            $struct->up();
        elseif($order=='down')
            $struct->down();

        if($parent){
            $firstchild = Structure::defaultOrder()->descendantsOf($parent->id)->first();
            $first = $firstchild;


            $list ='<ul class="sortable">';
            do{
                ($struct_slug==$firstchild->slug) ? $class = ' class="current" ' : $class = ' ' ;
                    
                $list= $list.'<li '.$class.' data-slug="'.$firstchild->slug.'"><a href="'.route('structure.show',
                [   
                    'structure'=> $firstchild->slug,
                    'repo'=> $repo_slug,
                ]).'">'.$firstchild->name.'</a></li>';

            }while($firstchild =$firstchild->getNextSibling());
            
            $list=$list."</ul>";

            if(count($first->getSiblings())==0)
                $list = null;
             
        }else{
            $siblings = $struct::defaultOrder()->withDepth()->having('depth', '=', 0)->get();

            $list ="<ul class='sortable'>";
             foreach($siblings as $child){
                ($struct_slug==$child->slug) ? $class = ' class="current" ' : $class = ' ' ;
                $list= $list.'<li '.$class.' data-slug="'.$child->slug.'"><a href="'.route('structure.show',
                [   
                    'structure'=> $child->slug,
                    'repo'=> $repo_slug,
                ]).'">'.$child->name.'</a></li>';
             }
                
            $list=$list."</ul>";

            if(count($siblings)<2 )
                $list =null;

        }


        if($struct)
            return view('appl.library.structure.show')
                    ->with('repo',$this->repo)
                    ->with('struct',$struct)
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
    public function edit($repo_slug,$struct_slug)
    {
       
        $node = Structure::where('slug',$struct_slug)->first();
        $root = Structure::where('slug',$repo_slug)->first();

        $this->authorize('update', $node);

        $parent = Structure::getParent($node);
        if(!$parent){
            $parent = new Structure;
            $parent->id=null;
        }
        //dd('done');

        $select_options = Structure::displaySelectOption(Structure::defaultOrder()->descendantsOf($root->id)->toTree(),
            [   'select_id'     =>  $parent->id,
                'disable_id'    =>  $node->id,
                'type' => $node->type,
            ]
        );


        if($node)
            return view('appl.library.structure.createedit')
                    ->with('repo',$this->repo)
                    ->with('struct',$node)
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
    public function update(Request $request, $repo_slug, $struct_slug)
    {

        // get the base Structure and parent       
        $struct = Structure::where('slug',$struct_slug)->first();
        $new_parent = Structure::where('id',$request->parent_id)->first();
        // change the parent
        if($new_parent)
        $new_parent->appendNode($struct);

        //get the new reference to the Structure item
        $struct = Structure::where('slug',$struct_slug)->first();
        //update Structure details 
        $struct->name = $request->name;
        $struct->slug = str_replace(' ', '-', $request->slug);
        $struct->save();

        flash('Structure(<b>'.$request->name.'</b>) successfully updated!')->success();
        return redirect()->route('structure.show',[   
                    'structure'=> $request->slug,
                    'repo'=> $repo_slug,
                ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($repo_slug, $struct_slug)
    {
        $node = Structure::where('slug',$struct_slug)->first();
        $node->delete();
        flash('Structure ('.$struct_slug.')Tree Successfully deleted!')->success();
        return redirect()->route('structure.index',$repo_slug);
    }
}
