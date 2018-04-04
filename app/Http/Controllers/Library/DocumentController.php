<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Document as document;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Structure;

class DocumentController extends Controller
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
    public function index(document $document,Request $request)
    {
        $search = $request->search;
        $item = $request->item;

        $this->authorize('view', $document);

        
        $documents = $document
                    ->where('repository_id',$this->repo->id)
                    ->where(function ($query) use ($item) {
                            $query->where('name','LIKE',"%{$item}%")
                                  ->orWhere('document', 'LIKE', "%{$item}%");
                        })
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';
       

        return view('appl.library.document.'.$view)
        ->with('repo',$this->repo)
        ->with('document',$document)
        ->with('documents',$documents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(document $document)
    {
        $this->authorize('create', $document);
        $parent =  Structure::where('slug',$this->repo->slug)->first();  

        //check if structure is created
        $tree = $parent->descendantsAndSelf($parent->id)->toTree();
        foreach($tree as $child){
            $hasChildren = (count($child->children) > 0);
            if(!$hasChildren)
                abort(403,'Create structure before proceeding.');
        }
        
        $select_options = Structure::displaySelectOption($parent->descendantsAndSelf($parent->id)->toTree(),['type'=>'lesson']);

        return view('appl.library.document.createedit')
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

            $document_exists = document::where('name',$request->name)
                            ->where('document',$request->document)
                            ->where('repository_id',$request->repository_id)
                            ->first();
            if($document_exists){
                flash('document already exists. Create unique document.')->error();
                return redirect()->back()->withInput();
            }

            $document = document::create($request->all());
            flash('A new document ('.$request->name.') is created!')->success();
            return redirect()->route('document.index',$this->repo->slug);
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
        $document = document::where('id',$id)->first();
        $this->authorize('view', $document);


        if($document)
            return view('appl.library.document.show')
                    ->with('repo',$this->repo)
                    ->with('mathjax',true)
                    ->with('document',$document);
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
        $document = document::where('id',$id)->first();
        $this->authorize('update', $document);

        $structure= Structure::where('id',$document->structure_id)->first();
        $root = Structure::where('slug',$repo_slug)->first();

        $select_options = Structure::displaySelectOption(Structure::defaultOrder()->descendantsOf($root->id)->toTree(),
            [   'select_id'     =>  $structure->id,
                'type' => 'lesson',
            ]
        );



        if($document)
            return view('appl.library.document.createedit')
                    ->with('repo',$this->repo)
                    ->with('document',$document)
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
            $document = document::where('id',$id)->first();
            $document->name = $request->name;
            $document->document = $request->document;
            $document->status = $request->status;
            $document->structure_id = $request->structure_id;
            $document->save(); 

            flash('document (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('document.show',[$repo_slug,$id]);
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

        $document = document::where('id',$id)->first();
        $this->authorize('update', $document);
        $document->delete();
        flash('document Successfully deleted!')->success();
        return redirect()->route('document.index',$repo_slug);
    }
}
