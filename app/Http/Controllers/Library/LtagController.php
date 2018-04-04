<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Ltag;
use PacketPrep\Models\Library\Repository;

class LtagController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ltag $Ltag)
    {
        
        $Ltags =  Ltag::where('repository_id',$this->repo->id)
                        ->orderBy('created_at','desc ')
                        ->get()->groupBy(function($item)
                        {
                          return $item->name;
                        });
        
        $this->authorize('view', $Ltag);

        return view('appl.library.ltag.index')
            ->with('repo',$this->repo)
            ->with('ltags',$Ltags)
            ->with('ltag',$Ltag)
            ->with('i',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ltag $ltag)
    {   //dd(request()->route('repo'));
        $this->authorize('create', $ltag);

        return view('appl.library.ltag.createedit')
                ->with('repo',$this->repo)
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
        try{

            $Ltag_exists = Ltag::where('name',$request->name
                            )->where('value',$request->value)
                            ->where('repository_id',$request->repository_id)
                            ->first();
            if($Ltag_exists){
                flash('Tag already exists. Create unique tag.')->error();
                return redirect()->back()->withInput();
            }

            $Ltag = Ltag::create($request->all());
            flash('A new tag ('.$request->name.') is created!')->success();
            return redirect()->route('ltag.index',$this->repo->slug);
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
    public function show($repo_slug,$id)
    {
        $ltag = Ltag::where('id',$id)->first();
        $this->authorize('view', $ltag);
        if($ltag)
            return view('appl.library.ltag.show')->with('repo',$this->repo)->with('ltag',$ltag);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($repo_slug,$id)
    {
        $ltag = Ltag::where('id',$id)->first();
        
        $this->authorize('update', $ltag);
        if($ltag)
            return view('appl.library.ltag.createedit')
                    ->with('repo',$this->repo)
                    ->with('ltag',$ltag)
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
    public function update(Request $request, $repo_slug, $id)
    {
        
        try{
            $Ltag = Ltag::where('id',$id)->first();
            $Ltag->name = $request->name;
            $Ltag->value = $request->value;
            $Ltag->save(); 

            flash('Ltag (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('ltag.show',[$repo_slug,$id]);
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
    public function destroy($repo_slug, $id)
    {
        $Ltag = Ltag::where('id',$id)->first();
        $Ltag->delete();
        $this->authorize('update', $Ltag);
        flash('Tag Successfully deleted!')->success();
        return redirect()->route('ltag.index',$repo_slug);
    }
}
