<?php

namespace PacketPrep\Http\Controllers\Content;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Content\Chapter;
use PacketPrep\Models\Content\Doc;

class ChapterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public $doc;
    

    public function __construct(){
        $this->doc='';
        if(request()->route('doc')){
            $doc_slug = request()->route('doc');   
            $this->doc = Doc::where('slug',$doc_slug)->get()->first();
        } 

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return redirect()->route('docs.show',$this->doc->slug);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Chapter $chapter)
    {
        $root = $chapter->Where('slug',$this->doc->slug)->get()->first();

        $this->authorize('create', $chapter);

        //$this->authorize('create', $chapter);
        $select_options = $chapter->displaySelectOption($chapter->defaultOrder()->whereDescendantOf($root)->get()->toTree(),['root_id'=>$root->id,'root_title'=>$root->title]);
        return view('appl.content.chapter.createedit')
                ->with('doc',$this->doc)
                ->with('stub','Create')
                ->with('select_options',$select_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($doc_slug, Chapter $chapter, Request $request)
    {
        $this->authorize('edit', $chapter);
        $request->slug = str_replace(' ', '-', $request->slug);
        $child_attributes =['title'=>$request->title,'slug'=>$request->slug,'content'=>$request->content];
        $parent = Chapter::where('id','=',$request->parent_id)->first();
        $child = new Chapter($child_attributes);

        $slug_exists_test = Chapter::where('slug','=',$request->slug)->first();

        if($slug_exists_test)
        {
            flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();;
        }

        if($request->parent_id!='0')
            $parent->appendNode($child);
        else
            $child->save();

        flash('A new Chapter('.$request->title.') is created!')->success();
        return redirect()->route('docs.show',$doc_slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doc_slug,$chapter_slug,Request $request)
    {

        $chapter = Chapter::where('slug',$chapter_slug)->first();
        $doc = Doc::where('slug',$doc_slug)->first();


         $order = $request->get('order');
        
        if($order=='up')
            $chapter->up();
        elseif($order=='down')
            $chapter->down();
        
        $chapter->privacy = $doc->privacy;
        $chapter->status = $doc->status;

        if(\auth::guest() && $doc->privacy==1)
            abort(403,'Unauthorized Action');
        elseif(\auth::guest() && $doc->privacy==0)
            {}
        else
         $this->authorize('view', $chapter);

        
        $parent = Chapter::getParent($chapter);

       

        $chapter->prev =$chapter->next =null;
        $all_chapters = Chapter::defaultOrder()->whereDescendantOf(Chapter::where('slug',$doc_slug)->first())->pluck('slug');

         $chapters = Chapter::defaultOrder()->whereDescendantOf($parent)->get();



        foreach($all_chapters as $key => $slug){
            if($slug == $chapter->slug)
            {
                $chapter->prev = isset($all_chapters[$key-1])?$all_chapters[$key-1]:null;
                $chapter->next = isset($all_chapters[$key+1])?$all_chapters[$key+1]:null;
            }
        }

        if($parent){
            $firstchild = Chapter::defaultOrder()->descendantsOf($parent->id)->first();
            $first = $firstchild;

            $list ='<ul class="sortable">';
            do{
                ($chapter_slug==$firstchild->slug) ? $class = ' class="current" ' : $class = ' ' ;
                    
                $list= $list.'<li '.$class.' data-slug="'.$firstchild->slug.'"><a href="'.route('chapter.show',['doc'=>$doc_slug,'chapter'=>$firstchild->slug]).'">'.$firstchild->title.'</a></li>';

            }while($firstchild =$firstchild->getNextSibling());
            
            $list=$list."</ul>";

            if(count($first->getSiblings())==0)
                $list = null;
             
        }else{
            $siblings = Chapter::defaultOrder()->withDepth()->having('depth', '=', 0)->get();

            $list ="<ul class='sortable'>";
             foreach($siblings as $child){
                ($chapter_slug==$child->slug) ? $class = ' class="current" ' : $class = ' ' ;
                $list= $list.'<li '.$class.' data-slug="'.$child->slug.'"><a href="'.route('chapter.show',['doc'=>$doc_slug,'chapter'=>$child->slug]).'">'.$child->title.'</a></li>';
             }
                
            $list=$list."</ul>";

            if(count($siblings)<2 )
                $list =null;

        }
        if($chapter)
            return view('appl.content.chapter.show')
                    ->with('doc',$this->doc)
                    ->with('chapter',$chapter)
                    ->with('chapters',$chapters)
                    ->with('parent',$parent)
                    ->with('list',$list);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($doc_slug,$chapter_slug)
    {
       
       
        $root = Chapter::Where('slug',$this->doc->slug)->get()->first();
        $this->authorize('edit', $root);
        $node = Chapter::where('slug',$chapter_slug)->first();
        $parent = Chapter::getParent($node);

        if(!$parent){
            $parent = new chapter;
            $parent->id=null;
        }

        $select_options = Chapter::displaySelectOption($node->defaultOrder()->whereDescendantOf($root)->get()->toTree(),
            ['root_id'=>$root->id,'root_title'=>$root->title,'select_id'     =>  $parent->id,'disable_id'    =>  $node->id,]
        );

        if($node)
            return view('appl.content.chapter.createedit')
                    ->with('doc',$this->doc)
                    ->with('chapter',$node)
                    ->with('parent',$parent)
                    ->with('stub','Update')
                    ->with('select_options',$select_options);
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
    public function update(Request $request, $doc_slug, $chapter_slug)
    {

        // get the base category and parent       
        $chapter = Chapter::where('slug',$chapter_slug)->first();
        $new_parent = Chapter::where('id',$request->parent_id)->first();

        $this->authorize('update', $chapter);

        // change the parent
        $new_parent->appendNode($chapter);

        //get the new reference to the category item
        $chapter = Chapter::where('slug',$chapter_slug)->first();
        //update category details 
        $chapter->title = $request->title;
        $chapter->slug = str_replace(' ', '-', $request->slug);
        $chapter->content = $request->content;
        $chapter->save();

        flash('chapter(<b>'.$request->title.'</b>) successfully updated!')->success();
        return redirect()->route('chapter.show',[$doc_slug,$chapter->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($doc_slug,$chapter_slug)
    {
        $node = Chapter::where('slug',$chapter_slug)->first();
        $node->delete();
        flash('Chapter('.$chapter_slug.')Tree Successfully deleted!')->success();
        return redirect()->route('docs.show',$doc_slug);
    }
}
