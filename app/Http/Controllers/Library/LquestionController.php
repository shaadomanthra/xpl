<?php

namespace PacketPrep\Http\Controllers\Library;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Library\Lquestion as Question;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Lpassage as Passage;
use PacketPrep\Models\Library\Structure as structure;
use PacketPrep\Models\Library\Ltag as Tag;

class LquestionController extends Controller
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
    public function index(Request $request, Question $question)
    {
        $search = $request->search;
        $item = $request->item;
        $questions = $question
                        ->where(function ($query) use ($item) {
                                $query->where('question','LIKE',"%{$item}%")
                                      ->orWhere('reference', 'LIKE', "%{$item}%");
                            })
                        ->where('repository_id',$this->repo->id)
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';

        $question->repository_id = $this->repo->id;
        $this->authorize('view', $question);

        return view('appl.library.lquestion.'.$view)
        ->with('repo',$this->repo)
        ->with('question',$question)
        ->with('questions',$questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Question $question)
    {

        $question->repository_id = $this->repo->id;
        $this->authorize('create', $question);

        $lpassages = Passage::where('repository_id',$this->repo->id)->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

        // structures
        $structure_parent =  structure::where('slug',$this->repo->slug)->first();   
        $structure_node = structure::defaultOrder()->descendantsOf($structure_parent->id)->toTree();
        //$node = structure::defaultOrder()->get()->toTree();
        if(count($structure_node))
            $structures = structure::displayUnorderedCheckList($structure_node,['repo_slug'=>$this->repo->slug,'type'=>'variant']);
        else
            $structures =null;

        //tags
        $tags =  Tag::where('repository_id',$this->repo->id)
                        ->orderBy('created_at','desc ')
                        ->get()->groupBy(function($item)
                        {
                          return $item->name;
                        });

        // Question Types
        $allowed_types = ['mcq','naq','maq','eq'];
        if(in_array(request()->get('type'), $allowed_types)){
            $type = request()->get('type');
        }
        else
            $type='mcq';             

        return view('appl.library.lquestion.createedit')
                ->with('repo',$this->repo)
                ->with('lpassages',$lpassages)
                ->with('passage','')
                ->with('type',$type)
                ->with('tags',$tags)
                ->with('structures',$structures)
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
        // merge answer for maq question
        if(is_array($request->answer)){
            $answer = implode(",",$request->answer);
            $request->merge(['answer' => $answer]);
        }

        $structures = $request->get('structure');
        $tags = $request->get('tag');

         try{

            


            if(!$request->get('reference')){
                flash('Kindly add a reference to the question.')->error();
                return redirect()->back()->withInput();
            }

            // keep the reference in capitals
            $request->merge(['reference' => strtoupper($request->reference)]);
            $question = Question::create($request->except(['structure','tag']));

            // create structures
            if($structures)
            foreach($structures as $structure){
                if(!$question->structures->contains($structure))
                    $question->structures()->attach($structure);
            }

            // create tags
            if($tags)
            foreach($tags as $tag){
                if(!$question->tags->contains($tag))
                    $question->tags()->attach($tag);
            }

            flash('A new question is created!')->success();
            return redirect()->route('lquestion.index',$this->repo->slug);
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
        $question = Question::where('id',$id)->first();
        $this->authorize('view', $question);

        if($question){

            if(request()->get('publish'))
            {
                $question->status = 2;
                $question->save();
            }

            $lpassage = Passage::where('id',$question->passage_id)->first();
            $questions = Question::select('id','status')
                                ->where('repository_id',$this->repo->id)
                                ->orderBy('created_at','desc ')
                                ->get();
            $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'repo']; 

            $details['curr'] = route('lquestion.show',[$repo_slug,$question->id]);
            foreach($questions as $key=>$q){

                if($q->id == $question->id){

                    if($key!=0)
                        $details['prev'] = route('lquestion.show',[$repo_slug,$questions[$key-1]->id]);

                    if(count($questions) != $key+1)
                        $details['next'] = route('lquestion.show',[$repo_slug,$questions[$key+1]->id]);

                    $details['qno'] = $key + 1 ;
                }
            } 
            return view('appl.library.lquestion.show')
                    ->with('repo',$this->repo)
                    ->with('mathjax',true)
                    ->with('question',$question)
                    ->with('lpassage',$lpassage)
                    ->with('details',$details)
                    ->with('questions',$questions);
        }
        else
            abort(404,'Question not found');
    }


        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function structure($repo_slug,$structure_slug,$id=null)
    {
        

        if($structure_slug == 'uncategorized')
        {
            $structure = new structure();
            $structure->name = 'Uncategorized';
            $structure->slug = 'uncategorized';
            $structure_slug = 'uncategorized';
            $structure->questions = structure::getUncategorizedQuestions($this->repo);

        }else
            $structure = structure::where('slug',$structure_slug)->first();

        if($id==null){
            if($structure_slug=='uncategorized')
                $id = $structure->questions->first()->id;
            elseif($structure->questions){
                $id = $structure->questions[0]->id;
            }else
                $id=null;
        }
        


        if($id){
            $question = Question::where('id',$id)->first();
            $this->authorize('view', $question);

            if($question){

                 if(request()->get('publish'))
                {
                    $question->status = 2;
                    $question->save();
                }

                $lpassage = Passage::where('id',$question->passage_id)->first();
                $questions = $structure->questions;

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'structure']; 
            
                $details['curr'] = route('structure.question',[$repo_slug,$structure_slug,$question->id]);
                foreach($questions as $key=>$q){

                    if($q->id == $question->id){

                        if($key!=0)
                            $details['prev'] = route('structure.question',[$repo_slug,$structure_slug,$questions[$key-1]->id]);

                        if(count($questions) != $key+1)
                            $details['next'] = route('structure.question',[$repo_slug,$structure_slug,$questions[$key+1]->id]);

                        $details['qno'] = $key + 1 ;
                    }
                } 

                return view('appl.library.lquestion.show')
                        ->with('repo',$this->repo)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('lpassage',$lpassage)
                        ->with('details',$details)
                        ->with('structure',$structure)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);

    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tag($repo_slug,$tag_id,$id=null)
    {
        
        $tag = Tag::where('id',$tag_id)->first();

        if($id==null){
            if($tag->questions){
                $id = $tag->questions[0]->id;
            }else
                $id=null;
        }
        


        if($id){
            $question = Question::where('id',$id)->first();
            $this->authorize('view', $question);

            if($question){

                 if(request()->get('publish'))
                {
                    $question->status = 2;
                    $question->save();
                }
            
                $lpassage = Passage::where('id',$question->passage_id)->first();
                $questions = $tag->questions;

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 
            
                $details['curr'] = route('ltag.question',[$repo_slug,$tag_id,$question->id]);
                foreach($questions as $key=>$q){

                    if($q->id == $question->id){

                        if($key!=0)
                            $details['prev'] = route('ltag.question',[$repo_slug,$tag_id,$questions[$key-1]->id]);

                        if(count($questions) != $key+1)
                            $details['next'] = route('ltag.question',[$repo_slug,$tag_id,$questions[$key+1]->id]);

                        $details['qno'] = $key + 1 ;
                    }
                } 

                return view('appl.library.lquestion.show')
                        ->with('repo',$this->repo)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('lpassage',$lpassage)
                        ->with('details',$details)
                        ->with('tag',$tag)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);

    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($repo_slug,$id)
    {
        $question = Question::where('id',$id)->first();
        $this->authorize('update', $question);


        // merge answer for maq question
        if($question->type=='maq'){
            $answer = explode(",",$question->answer);
            $question->answer = $answer;
        }

        $lpassage = Passage::where('id',$question->passage_id)->first();

        $lpassages = Passage::where('repository_id',$this->repo->id)->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

        // structures
        $structure_parent =  structure::where('slug',$this->repo->slug)->first();   
        $structure_node = structure::defaultOrder()->descendantsOf($structure_parent->id)->toTree();
        if(count($structure_node))
            $structures = structure::displayUnorderedCheckList($structure_node,['structure_id'=>$question->structures->pluck('id')->toArray(),'type'=>'variant']);
        else
            $structures =null;

        //tags
        $tags =  Tag::where('repository_id',$this->repo->id)
                        ->orderBy('created_at','desc ')
                        ->get()->groupBy(function($item)
                        {
                          return $item->name;
                        });
        $question->tags = $question->tags->pluck('id')->toArray();         

        if($question)
            return view('appl.library.lquestion.createedit')
                    ->with('repo',$this->repo)
                    ->with('question',$question)
                    ->with('lpassages',$lpassages)
                    ->with('lpassage',$lpassage)
                    ->with('structures',$structures)
                    ->with('tags',$tags)
                    ->with('type',$question->type)
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
        // merge answer for maq question
        if(is_array($request->answer)){
            $answer = implode(",",$request->answer);
            $request->merge(['answer' => $answer]);
        }

        $structures = $request->get('structure');
        $tags = $request->get('tag');

        try{
            $question = Question::where('id',$id)->first();
            $question->reference = strtoupper($request->reference);
            $question->question = $request->question;
            $question->a = $request->a;
            $question->b = $request->b;
            $question->c = $request->c;
            $question->d = $request->d;
            $question->e = $request->e;
            $question->answer = $request->answer;
            $question->explanation = $request->explanation;
            $question->dynamic = $request->dynamic;
            $question->passage_id= $request->passage_id;
            $question->status = $request->status;
            $question->save(); 

            // structures
            $structure_parent =  structure::where('slug',$this->repo->slug)->first();   
            $structure_list = structure::defaultOrder()->descendantsOf($structure_parent->id)->pluck('id');
            // update structures
            if($structures)
            foreach($structure_list as $structure){
                if(in_array($structure, $structures)){
                    if(!$question->structures->contains($structure))
                        $question->structures()->attach($structure);
                }else{
                    if($question->structures->contains($structure))
                        $question->structures()->detach($structure);
                }
                
            }   

            $tag_list =  Tag::where('repository_id',$this->repo->id)
                        ->orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
            //update tags
            if($tags)
            foreach($tag_list as $tag){
                if(in_array($tag, $tags)){
                    if(!$question->tags->contains($tag))
                        $question->tags()->attach($tag);
                }else{
                    if($question->tags->contains($tag))
                        $question->tags()->detach($tag);
                }
                
            } 

            flash('Question (<b>'.$question->slug.'</b>) Successfully updated!')->success();
            return redirect()->route('lquestion.show',[$repo_slug,$id]);
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
        $question = Question::where('id',$id)->first();
        $this->authorize('view', $question);
        $question->delete();
        flash('Question Successfully deleted!')->success();
        return redirect()->route('lquestion.index',$repo_slug);
    }
}
