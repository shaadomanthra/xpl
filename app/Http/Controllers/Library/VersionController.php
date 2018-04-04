<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Version;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Structure;

class VersionController extends Controller
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
    public function index(Version $version,Request $request)
    {
        $search = $request->search;
        $item = $request->item;

        $this->authorize('view', $version);

        
        $versions = $version
                    ->where('repository_id',$this->repo->id)
                    ->where(function ($query) use ($item) {
                            $query->where('name','LIKE',"%{$item}%")
                                  ->orWhere('content', 'LIKE', "%{$item}%");
                        })
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';
       

        return view('appl.library.version.'.$view)
        ->with('repo',$this->repo)
        ->with('version',$version)
        ->with('versions',$versions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Version $version)
    {
        $this->authorize('create', $version);
        $parent =  Structure::where('slug',$this->repo->slug)->first();  

        //check if structure is created
        $tree = $parent->descendantsAndSelf($parent->id)->toTree();
        foreach($tree as $child){
            $hasChildren = (count($child->children) > 0);
            if(!$hasChildren)
                abort(403,'Create structure before proceeding.');
        }
        
        $select_options = Structure::displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree(),['type'=>'variant']);
        return view('appl.library.version.createedit')
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
    public function store(Request $request)
    {
        try{

            $version_exists = Version::where('name',$request->name)
                            ->where('content',$request->content)
                            ->where('repository_id',$request->repository_id)
                            ->first();
            if($version_exists){
                flash('Version already exists. Create unique version.')->error();
                return redirect()->back()->withInput();
            }

            $version_content = summernote_imageupload(\auth::user(),$request->content);

            $request->merge(['content'=>$version_content]);
            $version = Version::create($request->all());
            flash('A new version ('.$request->name.') is created!')->success();
            return redirect()->route('version.index',$this->repo->slug);
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
        $version = Version::where('id',$id)->first();
        $this->authorize('view', $version);


        if($version)
            return view('appl.library.version.show')
                    ->with('repo',$this->repo)
                    ->with('mathjax',true)
                    ->with('version',$version);
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
        $version = Version::where('id',$id)->first();
        $this->authorize('update', $version);

        $structure= Structure::where('id',$version->structure_id)->first();
        $root = Structure::where('slug',$repo_slug)->first();

        $select_options = Structure::displaySelectOption(Structure::defaultOrder()->descendantsOf($root->id)->toTree(),
            [   'select_id'     =>  $structure->id,
                'type' => 'variant',
            ]
        );

        if($version)
            return view('appl.library.version.createedit')
                    ->with('repo',$this->repo)
                    ->with('version',$version)
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
    public function update(Request $request,$repo_slug, $id)
    {
        $user = \auth::user();
        try{
            $version = Version::where('id',$id)->first();
            $version->name = $request->name;
            $version->content = summernote_imageupload($user,$request->content);
            $version->status = $request->status;
            $version->structure_id = $request->structure_id;
            $version->save(); 

            flash('Version (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('version.show',[$repo_slug,$id]);
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

        $version = Version::where('id',$id)->first();
        $this->authorize('update', $version);

        $version->passage = summernote_imageremove($version->passage);
        $version->delete();
        flash('Passage Successfully deleted!')->success();
        return redirect()->route('version.index',$repo_slug);
    }
}
