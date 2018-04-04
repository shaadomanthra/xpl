<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Project;

class TagController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $tag)
    {
        
        $tags =  Tag::where('project_id',$this->project->id)
                        ->orderBy('created_at','desc ')
                        ->get()->groupBy(function($item)
                        {
                          return $item->name;
                        });
        
        $this->authorize('view', $tag);

        return view('appl.dataentry.tag.index')
            ->with('project',$this->project)
            ->with('tags',$tags)
            ->with('tag',$tag)
            ->with('i',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tag)
    {   //dd(request()->route('project'));
        $this->authorize('create', $tag);

        return view('appl.dataentry.tag.createedit')
                ->with('project',$this->project)->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $tag_exists = Tag::where('name',$request->name)->where('value',$request->value)->where('project_id',$request->project_id)->first();
            if($tag_exists){
                flash('Tag already exists. Create unique tag.')->error();
                return redirect()->back()->withInput();
            }

            $tag = Tag::create($request->all());
            flash('A new tag ('.$request->name.') is created!')->success();
            return redirect()->route('tag.index',$this->project->slug);
        }
        catch (QueryException $e){
           flash('There is some error in storing the data...kindly retry.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_slug,$id)
    {
        $tag = Tag::where('id',$id)->first();
        $this->authorize('view', $tag);
        if($tag)
            return view('appl.dataentry.tag.show')->with('project',$this->project)->with('tag',$tag);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_slug,$id)
    {
        $tag = Tag::where('id',$id)->first();
        $this->authorize('update', $tag);
        if($tag)
            return view('appl.dataentry.tag.createedit')
                    ->with('project',$this->project)
                    ->with('tag',$tag)
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
    public function update(Request $request, $project_slug, $id)
    {
        
        try{
            $tag = Tag::where('id',$id)->first();
            $tag->name = $request->name;
            $tag->value = $request->value;
            $tag->save(); 

            flash('Tag (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('tag.show',[$project_slug,$id]);
        }
        catch (QueryException $e){
            flash('There is some error in storing the data...kindly retry.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_slug, $id)
    {
        $tag = Tag::where('id',$id)->first();
        $tag->delete();
        $this->authorize('update', $tag);
        flash('Tag Successfully deleted!')->success();
        return redirect()->route('tag.index',$project_slug);
    }
}
