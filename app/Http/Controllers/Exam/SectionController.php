<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Models\Dataentry\Project;

class SectionController extends Controller
{
     public function __construct(){
        $this->cache_path =  '../storage/app/cache/exams/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $exam, Section $section,Request $request)
    {

        $this->authorize('view', $section);

        $exam = Exam::where('slug',$exam)->first();

        $search = $request->search;
        $item = $request->item;
        $sections = $section->where('name','LIKE',"%{$item}%")->where('exam_id',$exam->id)->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.exam.section.'.$view)
        ->with('sections',$sections)->with('exam',$exam);
    }


    public function processocr($url){

        $user = \auth::user();
          $post = [
                'url' => $url
            ];
            $payload = json_encode( $post );

            if(!Cache::get('url2_'.$user->username)){
                $ch = curl_init('https://centralindia.api.cognitive.microsoft.com/vision/v3.2/read/analyze');

                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Ocp-Apim-Subscription-Key:b0d522e12fb74962a8d829e0f3368fdb'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                    function ($curl, $header) use (&$headers) {
                        $len = strlen($header);
                        $header = explode(':', $header, 2);
                        if (count($header) < 2) // ignore invalid headers
                            return $len;

                        $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                        return $len;
                    }
                );
                $response = curl_exec($ch);
                 if(isset($headers['operation-location'][0])){
                    $eurl = $headers['operation-location'][0];
                    Cache::put('url2_'.$user->username, $eurl,3);
                }else{
                    echo "Not able to process! try again!";
                    dd($headers);
                    exit();

                }
                
                curl_close($ch);
            }else{
                $eurl = Cache::get('url2_'.$user->username);
            }

            
           
            

                $ch = curl_init($eurl);

                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Ocp-Apim-Subscription-Key:b0d522e12fb74962a8d829e0f3368fdb'));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
               
                $response = json_decode(curl_exec($ch),true);

                $text ='';
                $lines=[];
                if(isset($response['analyzeResult'])){
                    $lines = $response['analyzeResult']['readResults'][0]['lines'];
                }else{
                    if($response['status']=='running'){
                        $ch = curl_init($eurl);

                        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Ocp-Apim-Subscription-Key:b0d522e12fb74962a8d829e0f3368fdb'));
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                       
                        $response = json_decode(curl_exec($ch),true);

                    }

                    if(isset($response['analyzeResult'])){
                        echo "Not able to process now! try again! ";
                        exit();
                    }else if($response){
                        dd($response);
                        $lines = $response['analyzeResult']['readResults'][0]['lines'];
                    }
                }
                
                curl_close($ch);
                return $lines;
           
            
    }

    public function extractData($exam,$text){
        $r=request();
        $i=0;
        $data=array("time"=>0,"name"=>"","email"=>"","phone"=>"","score"=>0);

        foreach($exam->sections as $section){
            
            if($r->get('set'))
            $qset = $exam->getQuestionsSection($section->id,$r->get('set'));
            else if( $r->get('set')!=null)
            $qset = $exam->getQuestionsSection($section->id,$r->get('set'));
            else
            $qset = $section->questions;

            $k=0;
            foreach( $qset as $q){
                if($i==0){
                    $id = $q->id;
                }
                $q->section_name = $section->name;
                $questions[$i] = $q;
                $data['time'] = $data['time'] + $section->time;
                $i++;
            }
        }

        $i=0;
         foreach($text as $key=> $l)
            {
                if(trim($l['text'])=='Name:')
                {
                    $data['name'] = $text[$key+1]['text'];
                       
                }

                if(trim($l['text'])=='Email:')
                {
                    $data['email'] = $text[$key+1]['text'];
                       
                }

                if(trim($l['text'])=='Phone:')
                {
                    $data['phone'] = $text[$key+1]['text'];
                       
                }

                if(trim($l['text'])=='Your Answer:')
                {
                    $q =null;
                    if(isset($text[$key+2]['text'])){
                        $q = $text[$key+2]['text'];
                        $q = substr(str_replace('(Q','',$q),0,1);
                        $i = intval($q)-1;
                    }
                    
                    if(!trim($q)){
                        $i = rand();
                    }
                    $data[$i] = $text[$key+1]['text'];
                    $data['score']++;
                       
                }
            }

        return $data;


        // foreach($text as $l)
        // {
        //         $l['text'];
        // }

        //dd($questions);

    }

    
    public function ocrupload(Request $request){
         $exam = Exam::where('slug','29199')->first();
         $url = "https://i.imgur.com/QLsbILi.jpg";

        
            $result=0;
        if(isset($request->all()['_file'])){
            $file = $request->all()['_file'];
            $result=1;

             if(strtolower($file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
             else
                    $extension = strtolower($file->getClientOriginalExtension());

        $filename = rand().'.'.$extension;
        $path = Storage::disk('s3')->putFileAs('testocr', $file,$filename,'public');

        $url = Storage::disk('s3')->url($path);
      
        $data = $this->processocr($url);
         $result = $this->extractData($exam,$data);
       
        }

       

        if($exam)
            return view('appl.exam.section.testpage')
                     ->with('result',$result)
                    ->with('url',$url)
                    ->with('exam',$exam);
        else
            abort(404);

         

         dd($extractData);

       
         
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam)
    {
        $section = new Section();
        $this->authorize('create', $section);
        $exam = Exam::where('slug',$exam)->first();

        return view('appl.exam.section.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('section',$section)
                ->with('exam',$exam);
    }



    public function copy($exam,Request $r)
    {
        
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$r->get('id'))->first();

        $snew = $section->replicate();
        $snew->save();

        //attach questions
        foreach($section->questions as $q){
            if(!$snew->questions->contains($q->id))
                $snew->questions()->attach($q->id);
        }

        flash('Section('.$section->name.') is duplicated!')->success();
        return redirect()->route('sections.index',$exam->slug);
    }

    public function save($exam,Request $r)
    {
        
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$r->get('id'))->first();

        $r->session()->put('session_section_name',$section->name);
        $r->session()->put('session_section_id',$section->id);
        $r->session()->put('session_exam_name',$exam->name);
        $r->session()->put('session_exam_id',$exam->id);

        flash('Section('.$section->name.') is saved!')->success();
        return redirect()->route('sections.index',$exam->slug);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($exam, Section $section, Request $request)
    {
        try{
            $exam = Exam::where('slug',$exam)->first();
            $section->name = $request->name;
            $section->user_id = $request->user_id;
            $section->exam_id = $exam->id;
            $section->instructions = ($request->instructions) ? $request->instructions : null;
            $section->mark = $request->mark;
            $section->negative = $request->negative;
            $section->time = $request->time;
            $section->save(); 

            //update cache
            $obj = $exam;
                $filename = $obj->slug.'.json';
                $filepath = $this->cache_path.$filename;
                $obj->sections = $obj->sections;
                $obj->products = $obj->products;
                $obj->product_ids = $obj->products->pluck('id')->toArray();
                foreach($obj->sections as $m=>$section){
                    $obj->sections->questions = $section->questions;
                    foreach($obj->sections->questions as $k=>$question){
                       $obj->sections->questions[$k]->passage = $question->passage; 
                    }
                }
                
                $obj->updateCache();
                //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
            
           


            flash('A new section('.$request->name.') is created!')->success();
            return redirect()->route('sections.index',$exam->slug);
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
    public function download($exam,Request $r)
    {
        $exam= Exam::where('slug',$exam)->first();
        $this->authorize('update', $exam);

        $data =null;
        $ts = new Tests_Section;
        foreach($exam->sections as $key=>$section)
        $data = $data.$ts->tableSection($key+1,$section);

        $data = $ts->htmlWrapper($data,$exam);

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($data);
        Storage::disk('public')->put('docs/'.$exam->slug.'.html',$doc->saveHTML());
        $d = Storage::disk('public')->get('docs/'.$exam->slug.'.html');
        $ts->createDoc($d, $exam->slug);
        $r->merge(['export'=>1]);
        $name = str_replace(" ","_",$exam->name);

        if($r->get('html')){
            $headers = array(
              'Content-Type: application/html',
            );
            $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
            $path = $storagePath.'/docs/'.$exam->slug.'.html';
            return response()->download($path,$name.'.html',$headers);

        }elseif($r->get('backup')){

        }elseif($r->get('template')){
            $headers = [
              'Content-Type' => 'application/docx',
           ];

           
            return response()->download('template.docx', 'template.docx', $headers);
        }else{
            $headers = [
              'Content-Type' => 'application/doc',
           ];

            $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
            $path = $storagePath.'/doc/word/'.$exam->slug.'.doc';
            return response()->download($path, $name.'.doc', $headers);
        }
        
        
       
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload($exam,Request $r)
    {
        $exam= Exam::where('slug',$exam)->first();

        $this->authorize('update', $exam);
        $request = $r;
        /* If image is given upload and store path */
        if(isset($request->all()['file_'])){
            $file      = $request->all()['file_'];

            $extension = $file->getClientOriginalExtension();
            if(strtolower($file->getClientOriginalExtension()) != 'docx' && strtolower($file->getClientOriginalExtension()) != 'html'){
                flash('Only docx or html format are allowed')->error();
                return redirect()->back()->withInput();
            }

            $filename = $exam->slug.'.'.$extension;
            $path = Storage::disk('s3')->putFileAs('docs', $request->file('file_'),$filename,'public');
            $path = Storage::disk('public')->putFileAs('docs', $request->file('file_'),$filename,'public');
        }else{
            flash('File not selected!')->error();
            return redirect()->back()->withInput();
        }

        $sec = new Section();
        $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'docs/'.$exam->slug.'.'.$extension;
        $source = $path;
        

        if($r->get('type')=='html' && $extension=='html'){
            $data = $sec->readHtmlTables(file_get_contents($source));
            

        }elseif($extension=='docx'){
            $name = $storagePath.'docs/'.$exam->slug.'.html';
            $sec->wordToHtml($source,$name);
            $data = $sec->readHtmlTables(file_get_contents($name));

        }else{
            flash('Invalid File!')->error();
            return redirect()->back()->withInput();
        }
         // dd($data);

        foreach($data['sections'] as $key=>$value){

            $value['name'] = trim(strip_tags($value['name']));
         
            $s1 = Section::where('name',$value['name'])->where('exam_id',$exam->id)->first();
            if(!$s1)
                $s1 = new Section;


            $sno = intval($value['sno']);
            $s1->name = $value['name'];
            $s1->time = intval(trim(str_replace(" ","",strip_tags($value['time'])),"\xA0\xC2"));
            $s1->negative = intval(trim(str_replace(" ","",strip_tags($value['negative'])),"\xA0\xC2"));
            $s1->mark = intval(trim(str_replace(" ","",strip_tags($value['mark'])),"\xA0\xC2"));
            $s1->user_id = \auth::user()->id;
            $s1->exam_id = $exam->id;
            $s1->instructions = '';
            $s1->save();

            foreach($value['qset'] as $qno =>$qdata){
                $qno = trim(strip_tags($qno));
              
                $ref = strtoupper($exam->id.'_'.$sno.'_'.$qno);
                $q = Question::where('reference',$ref)->first();

                if(!$q){
                         $q= new Question;
                         $q->slug = $qdata['slug'];
                }
                   

                 try{

                    // keep the reference in capitals
                    $q->reference = $ref;
                    $q->question = $qdata['question'];
                    $q->a = static::is_empty($qdata['a']);
                    $q->b = static::is_empty($qdata['b']);
                    $q->c = static::is_empty($qdata['c']);
                    $q->d = static::is_empty($qdata['d']);
                    $q->e = static::is_empty($qdata['e']);
                    $q->answer = static::is_empty($qdata['answer']);
                    $q->explanation = static::is_empty($qdata['explanation']);
                
                    
                    $t=trim(str_replace(" ","",strip_tags($qdata['topic'])),"\xA0\xC2");
                    if($t!="" && $t!=" " ){
                        $q->topic = str_replace(' ','',strip_tags(strtolower($qdata['topic'])));
                    }
                    
                    $project = Project::where('slug','default')->first();
                    if($project)
                        $q->project_id = $project->id;
                    else
                    $q->project_id =78;
                    $q->user_id = \auth::user()->id;
                    $q->status =1;
                    $q->level = intval(trim(str_replace(" ","",strip_tags($qdata['level'])),"\xA0\xC2"));

                    $q->mark = intval(trim(str_replace(" ","",strip_tags($qdata['mark'])),"\xA0\xC2"));
                   
                    $q->type = str_replace(' ','',strtolower($qdata['type']));
                 
                    if(isset($qdata['passage'])){
                        $passage = $qdata['passage'];
                    }
                    else
                        $passage='';


                    if($passage!=''){
                        $q->passage = trim($qdata['passage'],"\xA0\xC2");
                    }else{
                        $q->passage =trim($qdata['passage'],"\xA0\xC2");
                    }

                    $q->save();

                    //attach section
                        if(!$q->sections->contains($s1->id))
                            $q->sections()->attach($s1->id);
                    
                }
                catch (QueryException $e){
                   flash('There is some error in storing the data...kindly retry.')->error();
                    return redirect()->back()->withInput();
                }

            }
        }
        flash('Question paper uploaded!')->success();
         return redirect()->back()->withInput();
    }

    public function is_empty($item){
        $t=trim(str_replace(" ","",strip_tags($item)),"\xA0\xC2");
        if($t!="" && $t!=" " ){
            return trim($item);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        
        $this->authorize('view', $section);

        if($exam)
            return view('appl.exam.section.show')
                    ->with('exam',$exam)->with('section',$section);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        $this->authorize('edit', $section);

        if($section)
            return view('appl.exam.section.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('exam',$exam)
                ->with('section',$section);
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
    public function update($exam, Request $request, $id)
    {
        try{
            $exam= Exam::where('slug',$exam)->first();
            $section= Section::where('id',$id)->first();

            $this->authorize('update', $section);

            $section->name = $request->name;
            $section->user_id = $request->user_id;
            $section->exam_id = $exam->id;
            $section->instructions = ($request->instructions) ? $request->instructions : null;
            $section->mark = $request->mark;
            $section->negative = $request->negative;
            $section->time = $request->time;
            $section->save(); 

            //dd($request->instructions);
            //update cache
            $obj = $exam;
                $filename = $obj->slug.'.json';
                $filepath = $this->cache_path.$filename;
                $obj->sections = $obj->sections;
                $obj->products = $obj->products;
                $obj->product_ids = $obj->products->pluck('id')->toArray();
                foreach($obj->sections as $m=>$section){
                    $obj->sections->questions = $section->questions;
                    foreach($obj->sections->questions as $k=>$question){
                       $obj->sections->questions[$k]->passage = $question->passage; 
                    }
                }
                
                $obj->updateCache();
            
           

            flash('Section (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('sections.show',[$exam->slug,$id]);
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
    public function destroy($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        $section->questions()->detach();
        $this->authorize('update', $section);

        $section->delete();
        flash('Section Successfully deleted!')->success();
        return redirect()->route('sections.index',$exam->slug);
    }
}
