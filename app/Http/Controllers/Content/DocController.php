<?php

namespace PacketPrep\Http\Controllers\Content;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Content\Doc;
use PacketPrep\Models\Content\Chapter;

class DocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Doc $doc, Request $request)
    {

        $search = $request->search;
        $item = $request->item;

        if(\auth::guest()){
            $docs = $doc->where('name','LIKE',"%{$item}%")
                        ->where('privacy',0)
                        ->where('status',1)
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
        }else{

            if(\auth::user()->checkRole(['administrator','editor','documenter']))
                $docs = $doc->where('name','LIKE',"%{$item}%")
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
            else
                $docs = $doc->where('name','LIKE',"%{$item}%")
                        ->where('status',1)
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
                            
        }
        

        $view = $search ? 'list': 'index';
        return view('appl.content.doc.'.$view)
            ->with('doc',$doc)
            ->with('docs',$docs);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Doc $doc)
    {
        $this->authorize('create', $doc);
        return view('appl.content.doc.createedit')
                ->with('doc',$doc)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $doc = new Doc;
            $doc->name = $request->name;
            $doc->slug = $request->slug;
            $doc->author_id = $request->author_id;
            $doc->status = $request->status;
            $doc->image = $request->image;
            $doc->privacy = $request->privacy;
            $doc->save();

            $chapter_attributes = ['title'=>$request->name,'slug'=>$request->slug];
            $chapter = new Chapter($chapter_attributes);
            $chapter->save();

            flash('A new doc('.$request->name.') is created!')->success();
            return redirect()->route('docs.index');
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
    public function show($doc_slug,Request $request)
    {
        
        $doc = Doc::where('slug',$doc_slug)->first();

        if(\auth::guest() && $doc->privacy==1)
            abort(403,'Unauthorized Action');
        elseif(\auth::guest() && $doc->privacy==0){
        }else{
            $this->authorize('view', $doc);  
        }
        

        $parent = Chapter::where('slug',$doc_slug)->first();
        $chap = Chapter::defaultOrder()->whereDescendantOf($parent)->get()->toTree();
    
        if(count($chap))
            $chapters = Chapter::displayUnorderedList($chap,['doc_slug'=>$doc_slug]);
        else
            $chapters =null;

        if($doc)
            return view('appl.content.doc.show')
                    ->with('doc',$doc)
                    ->with('chapters',$chapters);
        else
            abort(404);
    }

    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($doc_slug)
    {

        $doc = Doc::where('slug',$doc_slug)->first();
        $this->authorize('create', $doc);
        if($doc)
            return view('appl.content.doc.createedit')
                    ->with('doc',$doc)
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
    public function update(Request $request, $doc_slug)
    {

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $doc = Doc::where('slug',$doc_slug)->first();
            $doc->name = $request->name;
            $doc->slug = $request->slug;
            $doc->status = $request->status;
            $doc->image = $request->image;
            $doc->privacy = $request->privacy;
            $doc->save();

            $chapter = Chapter::where('slug',$doc_slug)->first();
            //update category details 
            $chapter->title = $request->name;
            $chapter->slug = str_replace(' ', '-', $request->slug);
            $chapter->save();

            flash('Project (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('docs.show',$request->slug);
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
    public function destroy($doc_slug)
    {

        $this->authorize('create', new Doc());
        Doc::where('slug',$doc_slug)->first()->delete();
        flash('Doc Successfully deleted!')->success();
        return redirect()->route('docs.index');
       
    }
}
