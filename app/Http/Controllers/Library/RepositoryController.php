<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Library\Structure;
use PacketPrep\User;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Repository $repo,Request $request)
    {
        $this->authorize('view', $repo);

        $search = $request->search;
        $item = $request->item;
        $repos = $repo->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.library.repository.'.$view)
        ->with('repos',$repos)->with('repo',new Repository());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $repo = new Repository();
        $this->authorize('create', $repo);

        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['content_engineer'] = Role::getUsers('content-engineer');

        return view('appl.library.repository.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('repo',$repo)
                ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Repository $repo,Request $request)
    {

        try{
            $request->slug = str_replace(' ', '-', $request->slug);

            $repo_exists = Repository::where('slug',$request->slug)->first();

            if($repo_exists){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }
            $repo->name = $request->name;
            $repo->slug = $request->slug;
            $repo->user_id_data_manager = $request->user_id_data_manager;
            $repo->user_id_data_lead = $request->user_id_data_lead;
            $repo->status = $request->status;
            $repo->target = $request->target;
            $repo->save(); 

            // save Structure
            $struct = new Structure;
            $child_attributes =['name'=>$request->name,'slug'=>$request->slug,'type'=>'subject'];
            $child = new Structure($child_attributes);
            $child->save();

            $engineer_list = Role::getUsers('content-engineer')->pluck('id');
            $engineers = $request->engineers;
            // update engineers
            if($engineers)
            foreach($engineer_list as $engineer){
                if(in_array($engineer, $engineers)){
                    if(!$repo->users->contains($engineer))
                        $repo->users()->attach($engineer);
                }else{
                    if($repo->users->contains($engineer))
                        $repo->users()->detach($engineer);
                }
                
            }  

            flash('A new Repository('.$request->name.') is created!')->success();
            return redirect()->route('library.index');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repo = Repository::where('slug',$id)->first();
        
        $this->authorize('view', $repo);

        /*
        $details['drafts'] = Question::where('Repository_id',$repo->id)->where('status',0)->count();
        $details['published'] = Question::where('Repository_id',$repo->id)->where('status',1)->count();
        $details['live'] = Question::where('Repository_id',$repo->id)->where('status',2)->count();
        $details['total'] = $details['drafts'] + $details['published'] + $details['live']; */

        if($repo)
            return view('appl.library.repository.show')
                    ->with('repo',$repo);
                    //->with('details',$details);
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
        $repo = Repository::where('slug',$id)->first();
        $this->authorize('update', $repo);

        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['content_engineer'] = Role::getUsers('content-engineer');

        $repo->engineers = $repo->users->pluck('id')->toArray();

        if($repo)
            return view('appl.library.repository.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('repo',$repo);
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
        $engineers = $request->get('engineers');

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $repo = Repository::where('id',$id)->first();

            $this->authorize('update', $repo);

            $struct = Structure::where('slug',$repo->slug)->first();
            $struct->name = $request->name;
            $struct->slug = $request->slug;
            $struct->save();

            $repo->name = $request->name;
            $repo->slug = $request->slug;
            $repo->user_id_data_manager = $request->user_id_data_manager;
            $repo->user_id_data_lead = $request->user_id_data_lead;
            $repo->status = $request->status;
            $repo->target = $request->target;
            $repo->save(); 

            $engineer_list = Role::getUsers('content-engineer')->pluck('id');
            // update engineers
            if($engineers)
            foreach($engineer_list as $engineer){
                if(in_array($engineer, $engineers)){
                    if(!$repo->users->contains($engineer))
                        $repo->users()->attach($engineer);
                }else{
                    if($repo->users->contains($engineer))
                        $repo->users()->detach($engineer);
                }
                
            }  

            flash('Repository (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('library.show',$request->slug);
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
        $repo = Repository::where('id',$id)->first();
        $this->authorize('update', $repo);
        $node = Structure::where('slug',$repo->slug)->first();
        $node->delete();
        $repo->delete();
        flash('Repository Successfully deleted!')->success();
        return redirect()->route('library.index');
       
    }
}
