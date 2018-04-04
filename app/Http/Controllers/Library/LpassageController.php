<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Lpassage;
use PacketPrep\Models\Library\Repository;

class LpassageController extends Controller
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
    public function index(Lpassage $lpassage,Request $request)
    {
        $search = $request->search;
        $item = $request->item;
        $api = $request->api;

        $this->authorize('view', $lpassage);

        if($api){
            $lpassages = $lpassage
                        ->where('repository_id',$this->repo->id)
                        ->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('passage', 'LIKE', "%{$item}%");
                            })
                        ->orderBy('created_at','desc ')
                        ->get();

            $view = $search ? 'list_attach': 'index';
        }
        else{
            $lpassages = $lpassage
                        ->where('repository_id',$this->repo->id)
                        ->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('passage', 'LIKE', "%{$item}%");
                            })
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

            $view = $search ? 'list': 'index';
        }

        return view('appl.library.lpassage.'.$view)
        ->with('repo',$this->repo)
        ->with('lpassage',$lpassage)
        ->with('lpassages',$lpassages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Lpassage $lpassage)
    {
        $this->authorize('create', $lpassage);
        return view('appl.library.lpassage.createedit')
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

            $lpassage_exists = Lpassage::where('name',$request->name)
                            ->where('passage',$request->passage)
                            ->where('repository_id',$request->repository_id)
                            ->first();
            if($lpassage_exists){
                flash('Passage already exists. Create unique passage.')->error();
                return redirect()->back()->withInput();
            }

            $lpassage_content = summernote_imageupload(\auth::user(),$request->passage);

            $request->merge(['passage'=>$lpassage_content]);
            $lpassage = Lpassage::create($request->all());
            flash('A new passage ('.$request->name.') is created!')->success();
            return redirect()->route('lpassage.index',$this->repo->slug);
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
        $lpassage = Lpassage::where('id',$id)->first();
        $this->authorize('view', $lpassage);
        if($lpassage)
            return view('appl.library.lpassage.show')
                    ->with('repo',$this->repo)
                    ->with('mathjax',true)
                    ->with('lpassage',$lpassage);
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
        $lpassage = Lpassage::where('id',$id)->first();
        $this->authorize('update', $lpassage);

        if($lpassage)
            return view('appl.library.lpassage.createedit')
                    ->with('repo',$this->repo)
                    ->with('lpassage',$lpassage)
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
    public function update(Request $request,$repo_slug, $id)
    {
        $user = \auth::user();
        try{
            $lpassage = Lpassage::where('id',$id)->first();
            $lpassage->name = $request->name;
            $lpassage->passage = summernote_imageupload($user,$request->passage);
            $lpassage->status = $request->status;
            $lpassage->save(); 

            flash('Passage (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('lpassage.show',[$repo_slug,$id]);
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
    public function destroy($repo_slug,$id)
    {

        $lpassage = Lpassage::where('id',$id)->first();
        $this->authorize('update', $lpassage);

        $lpassage->passage = summernote_imageremove($lpassage->passage);
        $lpassage->delete();
        flash('Passage Successfully deleted!')->success();
        return redirect()->route('lpassage.index',$repo_slug);
    }
}
