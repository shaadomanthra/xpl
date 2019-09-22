<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PacketPrep\Exceptions\Handler;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\User\Role;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project,Request $request)
    {
        $this->authorize('view', $project);

        $search = $request->search;
        $item = $request->item;
        $projects = $project->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $project->count = $project->getAllQuestionsCount($project->where('name','LIKE',"%{$item}%")->get());
        $view = $search ? 'list': 'index';

        return view('appl.dataentry.project.'.$view)
        ->with('projects',$projects)->with('project',$project);
    }


    public function material(){
        return view('appl.dataentry.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project();
        $this->authorize('create', $project);

        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['feeder'] = Role::getUsers('feeder');
        $users['proof_reader'] = Role::getUsers('proof-reader');
        $users['renovator'] = Role::getUsers('renovator');
        $users['validator'] = Role::getUsers('validator');

        return view('appl.dataentry.project.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('project',$project)
                ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {

        try{

            if(!$request->slug )
            $request->slug  = $request->name;
            $request->slug = strtolower(str_replace(' ', '-', $request->slug));

            $project->name = $request->name;
            $project->slug = $request->slug;
            $project->user_id_data_manager = $request->user_id_data_manager;
            $project->user_id_data_lead = ($request->user_id_data_lead) ? $request->user_id_data_lead : null;
            $project->user_id_feeder = ($request->user_id_feeder)? $request->user_id_feeder : null;
            $project->user_id_proof_reader = ($request->user_id_proof_reader) ? $request->user_id_proof_reader : null;
            $project->user_id_renovator = ($request->user_id_renovator) ? $request->user_id_renovator : null;
            $project->user_id_validator = ($request->user_id_validator) ? $request->user_id_validator : null;
            $project->status = $request->status;
            $project->target = ($request->target) ? $request->target : null;
            $project->save(); 

            // save category
            $category = new Category;
            $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
            $child = new Category($child_attributes);
            $child->save();

            flash('A new project('.$request->name.') is created!')->success();
            return redirect()->route('dataentry.index');
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
    public function show($id)
    {


        $project = Project::where('slug',$id)->first();

        
        $this->authorize('view', $project);

        $details['drafts'] = Question::where('project_id',$project->id)->where('status',0)->count();
        $details['published'] = Question::where('project_id',$project->id)->where('status',1)->count();
        $details['live'] = Question::where('project_id',$project->id)->where('status',2)->count();
        $details['total'] = $details['drafts'] + $details['published'] + $details['live'];

        if($project)
            return view('appl.dataentry.project.show')
                    ->with('project',$project)
                    ->with('details',$details);
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
        $project = Project::where('slug',$id)->first();
        $this->authorize('update', $project);

        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['feeder'] = Role::getUsers('feeder');
        $users['proof_reader'] = Role::getUsers('proof-reader');
        $users['renovator'] = Role::getUsers('renovator');
        $users['validator'] = Role::getUsers('validator');

        if($project)
            return view('appl.dataentry.project.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('project',$project);
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
    public function update(Request $request, $slug)
    {

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $project = Project::where('slug',$slug)->first();

            $this->authorize('update', $project);

            $category = Category::where('slug',$project->slug)->first();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();



            $project->name = $request->name;
            $project->slug = $request->slug;
            $project->user_id_data_manager = $request->get('user_id_data_manager')?$request->get('user_id_data_manager'):null;
            $project->user_id_data_lead = $request->get('user_id_data_lead')?$request->get('user_id_data_lead'):null;
            $project->status = $request->status;
            $project->target = ($request->target) ? $request->target : null;
            $project->user_id_proof_reader = $request->get('user_id_proof_reader')?$request->get('user_id_proof_reader'):null;
            $project->user_id_feeder = $request->get('user_id_feeder')?$request->get('user_id_feeder'):null;
             

            $project->save(); 

            flash('Project (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('dataentry.show',$request->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }
        }
    }


    public function fork(){

        $request = request();
        $project = Project::where('slug',$request->project_slug)->first();
        
        $this->authorize('update', $project);

        $proj_exists  = Project::where('slug',$request->slug)->first();

        if(!$proj_exists){

             // create new project
            $project_new = new Project();
            $project_new->name = $request->name;
            $project_new->slug = $request->slug;
            $project_new->user_id_data_manager = $request->user_id_data_manager;
            $project_new->status = 0;
            $project_new->save();

            // base category
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();

            //copy categories
            $parent =  Category::where('slug',$project->slug)->first();   
            $categories = Category::defaultOrder()->descendantsOf($parent->id)->toFlatTree();
            foreach ($categories as  $cat) {
                $child_attributes =['name'=>$cat->name,'slug'=> $project_new->slug.'-'.$cat->slug,'project_id'=>$project_new->id];
                $parent = Category::where('slug',$project_new->slug.'-'.Category::where('id','=',$cat->parent_id)->first()->slug)->first();
                $child = new Category($child_attributes);
                if($parent)
                    $parent->appendNode($child); 
                else
                    $category->appendNode($child);
            }

            // copy tags
            $tags = Tag::where('project_id',$project->id)->get();
            foreach($tags as $item){
                $tag = new Tag();
                $tag->name = $item->name;
                $tag->value = $item->value;
                $tag->user_id = $item->user_id;
                $tag->project_id = $project_new->id;
                if(!Tag::where('project_id',$project_new->id)->where('value',$item->value)->first())
                $tag->save();
            }

            // copy passages
            $passages = Passage::where('project_id',$project->id)->get();
            foreach($passages as $item){
                $passage = new Passage();
                $passage->name = $item->name;
                $passage->passage = $item->passage;
                $passage->user_id = $item->user_id;
                $passage->project_id = $project_new->id;
                $passage->stage = $item->stage;
                $passage->status = $item->status;
                if(!Passage::where('project_id',$project_new->id)->where('passage',$item->passage)->first())
                $passage->save();
            }

            // copy questions
            $questions = Question::where('project_id',$project->id)->get();
            foreach($questions as $item){
                $question = new Question();
                $question->slug = $item->slug;
                $question->reference = $item->reference;
                $question->type = $item->type;
                $question->question = $item->question;
                $question->a=$item->a;
                $question->b=$item->b;
                $question->c=$item->c;
                $question->d=$item->d;
                $question->e=$item->e;
                $question->answer=$item->answer;
                $question->explanation=$item->explanation;
                $question->dynamic=$item->dynamic;
                $question->project_id=$project_new->id;
                if(Passage::where('id',$item->passage_id)->first())
                $question->passage_id = Passage::where('passage',Passage::where('id',$item->passage_id)->first()->passage)->where('project_id',$project_new->id)->first()->id;
                $question->user_id = $item->user_id;
                $question->stage = $item->stage;
                $question->status = $item->status;
                if(!Question::where('project_id',$project_new->id)->where('slug',$item->slug)->first())
                $question->save();

                // attach Categories
                $categories = $item->categories;
                // update categories
                if($categories)
                foreach($categories as $category){
                    $new_cat = Category::where('slug',$project_new->slug.'-'.$category->slug)->first();
                    if($new_cat)
                    if(!$question->categories->contains($new_cat->id))
                            $question->categories()->attach($new_cat->id);
                    
                }   

                // attach tags
                $tags = $item->tags;
                
                if($tags)
                foreach($tags as $tag){
                    if(isset($tag->value)){
                        $new_tag = Tag::where('project_id',$project_new->id)->where('value',$tag->value)->first();
                        if($new_tag)
                        if(!$question->tags->contains($new_tag->id))
                            $question->tags()->attach($new_tag->id); 
                    }
                       
                } 

            }

            flash('Project (<b>'.$request->name.'</b>) Successfully created!')->success();
            return redirect()->route('dataentry.index');

        }else{
            flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
            return redirect()->back()->withInput();
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
        $project = Project::where('id',$id)->first();
        $this->authorize('update', $project);

        $qids = Question::where('project_id',$id)->pluck('id')->toArray();
        //detach tags and categories
        DB::table('category_question')->whereIn('question_id', $qids)->delete();
        DB::table('question_tag')->whereIn('question_id', $qids)->delete();
        // delete questions
        Question::where('project_id',$id)->delete();
        //delete passages
        Passage::where('project_id',$id)->delete();
        //delete tags
        Tag::where('project_id',$id)->delete();
        //delete categories
        Category::where('slug',$project->slug)->first()->delete();
        //delete project
        $project->delete();

        flash('Project Successfully deleted!')->success();
        return redirect()->route('dataentry.index');
       
    }
}
