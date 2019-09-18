<?php

namespace PacketPrep\Http\Controllers\Content;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Content\Article as Obj;
use PacketPrep\Models\Content\Label;
use PacketPrep\Models\Dataentry\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleController extends Controller
{
    public function __construct(){
        $this->app      =   'content';
        $this->module   =   'article';
        $this->cache_path =  '../storage/app/cache/articles/';
        $this->questions_path =  '../storage/app/cache/questions/';
        $this->cache_label_path =  '../storage/app/cache/label/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

     $search = $request->search;
     $item = $request->item;
     $page = $request->page;
     $filename = 'index.'.$this->app.'.'.$this->module.'.json';
     $filepath = $this->cache_path.$filename;

     /* update in cache folder */
     if($request->refresh){

        // update articles
        $objs = $obj->orderBy('created_at','desc')->where('status',1)->get();  
        file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));

        foreach($objs as $obj){ 
            $filename = $obj->slug.'.json';
            $label1 = $obj->labels()->first();
            $label2 = $obj->labels()->skip(1)->first();
            $obj->labels = $obj->labels;
            if($label1){
                $obj->related1 = $label1->articles()->limit(4)->get(); 
            }
            if($label2){
                $obj->related2 = $label2->articles()->limit(4)->get(); 
            }
            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
        }

        //update labels
        $labels = Label::where('status',1)->orderBy('created_at','desc')->get();
        file_put_contents($filepath, json_encode($labels,JSON_PRETTY_PRINT));

        foreach($labels as $label){ 
            $filename = $label->slug.'.json';
            $label->articles = $label->articles;
            $filepath = $this->cache_label_path.$filename;
            file_put_contents($filepath, json_encode($label,JSON_PRETTY_PRINT));
        }

        flash('Articles/Labels Cache Updated')->success();
    }

    $filename = 'index.'.$this->app.'.'.$this->module.'.json';
    $filepath = $this->cache_path.$filename;

    if(file_exists($filepath) && !$search && !$page){
    	$objs = json_decode(file_get_contents($filepath));
        $objs = $this->paginateAnswers($objs,18);

        $filename = 'index.'.$this->app.'.label.json';
        $filepath = $this->cache_label_path.$filename;
        $labels = collect(json_decode(file_get_contents($filepath)));

    }else{
    	$objs = $obj->where('name','LIKE',"%{$item}%")
    	->where('status',1)
    	->orderBy('created_at','desc')
    	->paginate(18);  

        $labels = Label::get();
    }
    
    $view = $search ? 'list': 'index';

    return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
        ->with('objs',$objs)
        ->with('labels',$labels)
        ->with('obj',$obj)
        ->with('app',$this);
    }

    protected function paginateAnswers(array $answers, $perPage = 10)
    {
        $page = Input::get('page', 1);

        $offset = ($page * $perPage) - $perPage;

        $paginator = new LengthAwarePaginator(
            array_slice($answers, $offset, $perPage, true),
            count($answers),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }


    public function label($slug,Obj $obj,Request $request)
    {

     $search = $request->search;
     $item = $request->item;
     $page = $request->page;
     $filename = $slug.'.json';
     $filepath = $this->cache_label_path.$filename;


    if(file_exists($filepath) && !$search && !$page){
        $label = json_decode(file_get_contents($filepath));
        $objs = $this->paginateAnswers($label->articles,18);

        $filename = 'index.'.$this->app.'.label.json';
        $filepath = $this->cache_label_path.$filename;
        $labels = collect(json_decode(file_get_contents($filepath)));

    }else{
        $label = Label::where('slug',$slug)->first();
        $labels = Label::get();
        if(!$search)
        $objs = $label->articles()->paginate(18);  
        else{
           $objs=  $label->articles()->where('name','LIKE',"%{$item}%")->paginate(18);
        }
    }
    
    $view = $search ? 'list': 'index';

    return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
        ->with('objs',$objs)
        ->with('label',$label)
        ->with('labels',$labels)
        ->with('obj',$obj)
        ->with('app',$this);
    }


    /** PUBLIC LISTING
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function public(Obj $obj,Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','data-lead','data-manager','blog-writer']))
                abort('404','Page Not Found');
    	
        $search = $request->search;
        $item = $request->item;

        $labels = Label::get();
        if($request->get('user_id')){
            $objs = $obj->where('user_id',$request->get('user_id'))
                    ->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate(18); 
        }else{
            $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate(18);
        }

        $view = $search ? 'list': 'index';
        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('labels',$labels)
                ->with('listing',1)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    /** PUBLIC LISTING
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myblogs(Obj $obj,Request $request)
    {
        
        $search = $request->search;
        $item = $request->item;

        $labels = Label::get();
        $objs = $obj->where('user_id',\auth::user()->id)
                    ->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate(18); 
        

        $view = $search ? 'list': 'index';
        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('labels',$labels)
                ->with('myblogs',1)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $this->authorize('create', $obj);
        $labels = Label::where('status',1)->get();

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('labels',$labels)
                ->with('editor','true')
                ->with('app',$this);
    }

    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
         try{

            // update slug with name if its empty
            if(!$request->get('slug')){
                $request->merge(['slug' => strtolower(str_replace(' ','-',$request->get('name')))]);
            }

            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file_'),$filename);

                $request->merge(['image' => $path]);
            }else{
                $request->merge(['image' => '']);
            }

            /* create a new entry */
            $obj = $obj->create($request->except(['file_']));

            $sizes = [300,600,900,1200];
            if(isset($path))
            foreach($sizes as $s)
                image_resize($path,$s);

            // attach the tags
            $labels = $request->get('labels');
            if($labels)
            foreach($labels as $label){
                $obj->labels()->attach($label);
            }


            /* update cache file of this product */
            $filename = $obj->slug.'.json';

            $label1 = $obj->labels()->first();
            $label2 = $obj->labels()->skip(1)->first();
            $obj->labels = $obj->labels;
            if($label1){
                $obj->related1 = $label1->articles()->limit(4)->get(); 
            }
            if($label2){
                $obj->related2 = $label2->articles()->limit(4)->get(); 
            }

            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            /* update in cache folder main file */
            $filename = 'index.'.$this->app.'.'.$this->module.'.json';
            $filepath = $this->cache_path.$filename;
            $objs = $obj->orderBy('created_at','desc')->where('status',1)
                        ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));

            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
            return redirect()->route('page',$request->get('slug'));
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //cache file
        $filename = $slug.'.json';
        $filepath = $this->cache_path.$filename;

        // load page data from cache
        if(file_exists($filepath))
            $obj = json_decode(file_get_contents($filepath));
        else{
            $obj = Obj::where('slug',$slug)->first();

            if(!$obj)
                abort('404');

            $label1 = $obj->labels()->first();
            $label2 = $obj->labels()->skip(1)->first();
            $obj->labels = $obj->labels;
            if($label1){
                $obj->related1 = $label1->articles()->limit(4)->get(); 
            }

            if($label2){
                $obj->related2 = $label2->articles()->limit(4)->get(); 
            }
        }
        
        if(!$obj)
        {
        	abort('404','Page Not Found');
        }
        if(isset($obj->status))
        {
            if(!$obj->status){
                if(!\auth::user())
                abort('404','Page Not Found');

            if(!\auth::user()->checkRole(['administrator','data-lead','data-manager']))
                abort('404','Page Not Found');
            }
        	
        }else{
            abort('404','Page Not Found');
        }

        $filepath = $this->questions_path.$filename;
        //load questions if they exist
        if(file_exists($filepath))
            $questions = json_decode(file_get_contents($filepath));
        else{

            $category = Category::where('slug',$slug)->first();
            ($category)? $questions = $category->questions: $questions = null;
        }



        if($obj)
            if(!isset($obj->math)){
                return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)
                    ->with('questions',$questions)
                    ->with('app',$this)
                    ->with('share',true); 
            }
            else if($obj->math==1){
                return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)
                    ->with('questions',$questions)
                    ->with('app',$this)
                    ->with('mathjax',true)
                    ->with('share',true);
            }else if($obj->math==2){
                return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)
                    ->with('questions',$questions)
                    ->with('app',$this)
                    ->with('highlight',true);
            }
            else
              return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)
                    ->with('questions',$questions)
                    ->with('app',$this)
                    ->with('share',true);  
        else
            abort(404);
    }

    public function companies()
    {
       $companies =['infosys','wipro','capgemini','tcs','dell'];
       return view('appl.content.article.companies')->with('companies',$companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $obj= Obj::where('slug',$slug)->first();
        $this->authorize('edit', $obj);
        $labels = Label::where('status',1)->get();


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor','true')
                ->with('labels',$labels)
                ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
         try{
            $obj = Obj::where('slug',$slug)->first();

             /* delete file request */
            if($request->get('deletefile')){

                if(Storage::disk('public')->exists($obj->image)){
                    Storage::disk('public')->delete($obj->image);
                }
                redirect()->route('page',$slug);
            }

            $this->authorize('update', $obj);
            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file_'),$filename);
                $request->merge(['image' => $path]);
            }

            $labels = $request->get('labels');
            if($labels){
                $obj->labels()->detach();
                foreach($labels as $label){
                $obj->labels()->attach($label);
                }
            }else{
                $obj->labels()->detach();
            }


            $obj->update($request->except(['file_'])); 

            $sizes = [300,600,900,1200];
            if($obj->image)
            foreach($sizes as $s)
                image_resize($obj->image,$s);

            /* update cache file of this product */
            $filename = $obj->slug.'.json';
            $filepath = $this->cache_path.$filename;

            $label1 = $obj->labels()->first();
            $label2 = $obj->labels()->skip(1)->first();
            $obj->labels = $obj->labels;
            if($label1){
                $obj->related1 = $label1->articles()->limit(4)->get(); 
            }
            if($label2){
                $obj->related2 = $label2->articles()->limit(4)->get(); 
            }

            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            /* update in cache folder main file */
            $filename = 'index.'.$this->app.'.'.$this->module.'.json';
            $filepath = $this->cache_path.$filename;
            $objs = $obj->orderBy('created_at','desc')->where('status',1)
                        ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));
            

            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route('page',$slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
     public function destroy($slug)
    {
        $obj = Obj::where('slug',$slug)->first();
       
        $this->authorize('update', $obj);

        $filename = $obj->slug.'.json';
        $filepath = $this->cache_path.$filename;

        if(file_exists($filepath)){
            unlink($filepath);
        }


        $sizes = [300,600,900,1200];
        foreach($sizes as $s){
            $image3 = '/articles/'.$obj->slug.'.png';
            $image1 = '/articles/'.$obj->slug.'_'.$s.'.jpg';
            $image2 = '/articles/'.$obj->slug.'_'.$s.'.webp';
            
            if(Storage::disk('public')->exists($image1)){
                Storage::disk('public')->delete($image1);
            }
            if(Storage::disk('public')->exists($image2)){
                Storage::disk('public')->delete($image2);
            }
            if(Storage::disk('public')->exists($image3)){
                Storage::disk('public')->delete($image3);
            }
        }
        $obj->delete();

        /* update in cache folder main file */
            $filename = 'index.'.$this->app.'.'.$this->module.'.json';
            $filepath = $this->cache_path.$filename;
            $objs = $obj->orderBy('created_at','desc')->where('status',1)
                        ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));
            

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
