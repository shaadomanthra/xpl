<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id',
        'description',
        'intro_youtube',
        'intro_vimeo',
        'priority',
        'weightage_min',
        'weightage_avg',
        'weightage_max',
        'price',
        'important_topics',
        'reference_books',
        'status',
        'image',
        // add all other fields
    ];

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function products(){
        return $this->belongsToMany('PacketPrep\Models\Product\Product');
    }

    public function product(){
        $p=null;        
        $p = $this->belongsToMany('PacketPrep\Models\Product\Product')->where('slug',$this->slug)->first();

        if(isset($p->name))
            return $p;

        $products = $this->belongsToMany('PacketPrep\Models\Product\Product')->get();
        foreach($products as $product){
 
            if($product->slug!='premium-access' && $product->slug!='pro-access')
            {
                $p = $product;
                break;
            }
        }
        return $p;
    }


    public function updateCache($courses=null,$course=null){
        if($course){
            $course_data = $course->category_list($course->slug);
            if(isset($course_data['categories'])){
                        $course->categories = json_decode(json_encode($course_data['categories']));
                        $course->ques_count = $course_data['ques_count'];
                        $course->nodes = [];//$course_data['nodes'];
                        $course->exams = $course_data['exams'];
                        $course->tests = $course_data['tests'];
                    }else{

                        $course->categories = null;
                        $course->ques_count = null;
                        $course->nodes = null;
                        $course->exams = null;
                        $course->tests = null;
                    }

            
            $nodes = array();
            foreach($course_data['nodes'] as $node){
                $nodes[$node->name] = array();
                foreach($node->children as $n){
                    $item = ["id"=>$n->id,"name"=>$n->name,"slug"=>$n->slug];
                    array_push($nodes[$node->name] ,$item);
                }
              
            }
            $course->new_nodes = $nodes;

            //Cache::forget('course_'.$course->slug);
            Cache::forever('course_'.$course->slug,$course);

             
        }

        if($courses){
            Cache::forget('courses');
            Cache::forever('courses',$courses);
        }
        
    }

    public function colleges(){
        return $this->belongsToMany('PacketPrep\Models\College\College');
    }

    public function clients(){
        return $this->belongsToMany('PacketPrep\Models\Product\Client')->withPivot('visible');
    }

    public function exams(){
        return $this->hasMany('PacketPrep\Models\Exam\Exam');
    }

    public function getVisibility($client_id,$course_id){

        if(!is_int($client_id))
        {
            $client_id = DB::table('clients')
                ->where('slug', $client_id)
                ->first()->id;
        }
        $entry =DB::table('client_course')
                ->where('client_id', $client_id)
                ->where('course_id', $course_id)
                ->first();

        if($entry)
            return $entry->visible;
        else

        return null;
    }

    
    public function validityExpired(){

        $course_id = $this->id;
        $user_id = \auth::user()->id;

        $entry =DB::table('course_user')
                ->where('course_id', $course_id)
                ->where('user_id', $user_id)
                ->first();


        if(strtotime($entry->valid_till) > strtotime(date('Y-m-d')))
            return false;
        else
            return true;

    }

    public static function getName($slug){
    	 return (new Course)->where('slug',$slug)->first()->name;
    }

    public static function get($slug){
        return (new Course)->where('slug',$slug)->first();
    }

    public static function getID($slug){
        return (new Course)->where('slug',$slug)->first()->id;
    }

    public function category_list($id){

        $project = Project::where('slug',$id)->first();
        $parent =  Category::where('slug',$id)->first();

        if(!$parent)
            return [];
        
        //categories
        $categories_list = Category::defaultOrder()
                            ->descendantsOf($parent->id);
        $ap = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();


      

        $categories_ =array();
        foreach($categories_list as $categ){
            $cat = $categ->id;
            $categories_[$cat]['name'] = $categ->name;
            $categories_[$cat]['slug'] = $categ->slug;
            $categories_[$cat]['correct'] =0;
            $categories_[$cat]['incorrect']  =0;
            $categories_[$cat]['total'] = 0; 
            $categories_[$cat]['correct_percent'] =0;        
            $categories_[$cat]['incorrect_percent'] = 0;
        }


        
        $qset = DB::table('category_question')->select('category_id','intest')->whereIn('category_id', $ap)->select('category_id', DB::raw('count(*) as count'))->where('intest','!=',1)->groupBy('category_id')->get();


       

        $count =0;
        foreach($qset as $q){
            $categories_[$q->category_id]['total'] = $q->count;
            $count = $count + $q->count;
        }
        
       

        //$data['ques_count'] = 0;
        
        $data['categories'] = $categories_;

        $qcount = 0;$i=0;
        if($parent){
            $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();
            foreach($node as $k=>$n){
                $node[$k]['children'] = Category::defaultOrder()->descendantsOf($n->id)->toTree();

                foreach($node[$k]['children'] as $c){

                    $qc=0;
                    foreach($c->questions as $q){
                        if(!$q->intest)
                            $qc++;
                    }

                    $data['categories'][$c->id]['total']  = $qc;
                    //echo $c['name']."-".$qc."<br>";
                    $qcount = $qcount + $qc;
                }
               // dd($n);

                // $qc=0;
                // foreach($n->questions as $q){
                //     if(!$q->intest)
                //         $qc++;
                // }

                // //echo $i++."-".$node[$k]['children']['name']."-".$qc."<br>";
                // $qcount = $qcount + $qc;
                    
                foreach($node[$k]['children'] as $m => $c){
                    $node[$k]['children'][$m]->try = 1;
                    
                }
                //dd($qc);
            }
                          
        } 
        

        $data['nodes'] = $node;
        $data['ques_count'] = $qcount;

        //dd($data['ques_count']);

        // $i=0;
        // foreach($data['nodes'] as $a=>$b){
         
        //     foreach($b->children as $c){
                
        //         echo $i++."-".$c['name']."<br>";
        //     }
        // }

        // dd('here');

        if($qcount==0)
            $data['ques_count']  = $count;

        $examtype = Examtype::where('slug',$id)->first();
        $exams = [];
        if($id!='quantitative-aptitude')
        if($examtype)
            $exams = Exam::where('examtype_id',$examtype->id)->get();
        else{
            $exams = Exam::where('slug','LIKE',"%{$id}%")->get(); 
        }

        $exam_ids =[];
        foreach($categories_list as $t){
            if($t->exam_id)
                array_push($exam_ids, $t->exam_id);
            
        }

        $tests =[];

        if(!count($exams)){
             $exams = Exam::whereIn('slug',$exam_ids)->get()->keyBy('slug'); 
             $eids = $exams->pluck('id')->toArray();
             if(\auth::user())
             $attempts = Tests_Overall::whereIn('test_id',$eids)->where('user_id',\auth::user()->id)->get()->keyBy('test_id');
         else
            $attempts = [];
           
        }

        foreach($exams as $m=>$e){
            $exams[$m]->ques_count = 0;//$e->question_count();
            $exams[$m]->time = 0;//$e->time();
            if(isset($attempts[$e->id]))
            $exams[$m]->try =1;
            else
            $exams[$m]->try =0;
            unset($exams[$m]->sections);

            if(in_array($e->id, $exam_ids))
                unset($exams[$m]);
            $tests[$e->id] = $e->slug;

        }

        $data['exams'] = $exams;
        $data['tests'] = $tests;


        return $data;
    }

    public function attempt_data(){
        $practice = DB::table('practices')
                    ->where('course_id', $this->id)
                    ->where('user_id',\auth()->user()->id)
                    ->get();
        $sum =0;$time = 0;
        $count = count($practice);
        foreach($practice as $p){
            if($p->accuracy)
                $sum++;
            $time = $time + $p->time;
        }
        $data['practice'] = $practice;
        $data['attempted'] = count($practice);
        $data['accuracy'] = round(($sum*100)/$count,2);
        $data['time'] = round(($time)/$count,2);
        return $data;
    }

    public static function attempted($course){

        $exam = session('exam');
        $tag = Tag::where('value',$exam)->first();
        if($tag){
            $ques_tag = DB::table('question_tag')->where('tag_id', $tag->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
            return DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->whereIn('qid',$ques_tag)
                    ->count();
        }
        else
        {
                return DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->count();

        }


        
        
    }

    public static function time($course){
        
        $exam = session('exam');
        $tag = Tag::where('value',$exam)->first();
        if($tag){
            $ques_tag = DB::table('question_tag')->where('tag_id', $tag->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
            return round(DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->whereIn('qid',$ques_tag)
                    ->avg('time'),2);
        }
        else
        {
                return round(DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->avg('time'),2);

        }

    }

    public static function accuracy($course){
        $exam = session('exam');
        $tag = Tag::where('value',$exam)->first();
        if($tag){
            $ques_tag = DB::table('question_tag')->where('tag_id', $tag->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
            $sum = DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->whereIn('qid',$ques_tag)
                    ->sum('accuracy');
            $count = DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->whereIn('qid',$ques_tag)
                    ->count();
        }
        else
        {
            $sum = DB::table('practices')->where('course_id', $course->id)->where('user_id',\auth()->user()->id)->sum('accuracy');
            $count = DB::table('practices')->where('course_id', $course->id)->where('user_id',\auth()->user()->id)->count();
                
        }

         
         if($count){
            return round(($sum*100)/$count,2);
         }
         else
            return null;

    }
}
