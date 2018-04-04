<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Video as video;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Structure;

class VideoController extends Controller
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
    public function index(video $video,Request $request)
    {
        $search = $request->search;
        $item = $request->item;

        $this->authorize('view', $video);

        
        $videos = $video
                    ->where('repository_id',$this->repo->id)
                    ->where(function ($query) use ($item) {
                            $query->where('name','LIKE',"%{$item}%")
                                  ->orWhere('video', 'LIKE', "%{$item}%");
                        })
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';
       

        return view('appl.library.video.'.$view)
        ->with('repo',$this->repo)
        ->with('video',$video)
        ->with('videos',$videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(video $video)
    {
        $this->authorize('create', $video);
        $parent =  Structure::where('slug',$this->repo->slug)->first();  

        //check if structure is created
        $tree = $parent->descendantsAndSelf($parent->id)->toTree();
        foreach($tree as $child){
            $hasChildren = (count($child->children) > 0);
            if(!$hasChildren)
                abort(403,'Create structure before proceeding.');
        }
        
        $select_options = Structure::displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree(),['type'=>'concept']);
        return view('appl.library.video.createedit')
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

            $video_exists = video::where('name',$request->name)
                            ->where('video',$request->video)
                            ->where('repository_id',$request->repository_id)
                            ->first();
            if($video_exists){
                flash('video already exists. Create unique video.')->error();
                return redirect()->back()->withInput();
            }

            $video = video::create($request->all());
            flash('A new video ('.$request->name.') is created!')->success();
            return redirect()->route('video.index',$this->repo->slug);
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
        $video = video::where('id',$id)->first();
        $this->authorize('view', $video);

        $type = null;
        if(url_exists('https://player.vimeo.com/video/'.$video->video))
            $type = 'vimeo';
        if(youtube_video_exists($video->video))    
            $type = 'youtube';


        if($video)
            return view('appl.library.video.show')
                    ->with('repo',$this->repo)
                    ->with('mathjax',true)
                    ->with('type',$type)
                    ->with('video',$video);
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
        $video = video::where('id',$id)->first();
        $this->authorize('update', $video);

        $structure= Structure::where('id',$video->structure_id)->first();
        $root = Structure::where('slug',$repo_slug)->first();

        $select_options = Structure::displaySelectOption(Structure::defaultOrder()->descendantsOf($root->id)->toTree(),
            [   'select_id'     =>  $structure->id,
                'type' => 'concept',
            ]
        );

        if($video)
            return view('appl.library.video.createedit')
                    ->with('repo',$this->repo)
                    ->with('video',$video)
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
            $video = video::where('id',$id)->first();
            $video->name = $request->name;
            $video->video = $request->video;
            $video->status = $request->status;
            $video->structure_id = $request->structure_id;
            $video->save(); 

            flash('Video (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('video.show',[$repo_slug,$id]);
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

        $video = video::where('id',$id)->first();
        $this->authorize('update', $video);
        $video->delete();
        flash('Video Successfully deleted!')->success();
        return redirect()->route('video.index',$repo_slug);
    }
}
