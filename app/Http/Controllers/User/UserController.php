<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\User\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PacketPrep\Models\Job\Post;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Course\Practice;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use PacketPrep\Exports\UExport;
use PacketPrep\Exports\UExport2;
use Maatwebsite\Excel\Facades\Excel;
use PacketPrep\Models\College\Metric;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\ActivateUser2;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
    

        if(strpos($username,'@')===0)
        {

            $username = substr($username, 1);
            $user = User::where('username',$username)->first();

            //$user_details = User_Details::where('user_id',$user->id)->first();


            if($user)
            {
                if(!auth::user())
                    $view = 'private';
                elseif(auth::user()->id == $user->id || auth::user()->checkRole(['administrator','hr-manager','employee']))
                    $view = 'index';
                else
                    $view = 'private';
                // if(!isset($user_details))
                //     $view = 'index';

                // elseif($user_details->privacy==0)
                //     $view = 'index';
                // elseif($user_details->privacy==1){
                //     if(auth::user())
                //       $view = 'index';
                //     else
                //       $view = 'private';

                // }else{

                //         if(!auth::user())
                //             $view = 'private';
                //         elseif(auth::user()->id == $user->id || auth::user()->isAdmin())
                //             $view = 'index';
                //         else
                //             $view = 'private';
                        
                // }

                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.jpg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.jpg');
                }
                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.png'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.png');
                }

                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.jpeg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.jpeg');
                }

                $colleges = Cache::remember('colleges',240,function(){
                    return College::all()->keyBy('id');
                });

                $branches = Cache::remember('branches',240,function(){
                    return Branch::all()->keyBy('id');
                });

                if(request()->get('ajax'))
                    $view = 'ajax';

                return view('appl.user.'.$view)
                            ->with('user',$user)->with('colleges',$colleges)->with('branches',$branches);

            }else{
                abort(404);
                }
        }
        else
            abort(404);
       
    }

    public  function agreement_list(Request $request){

        $users = User::where('info',$info)->get();
                 $uids = $users->pluck('id')->toArray();
                 $usx=[];
                 foreach($users as $k=>$user){
                    unset($user->password);
                    unset($user->language);
                    unset($user->fluency);
                    unset($user->confidence);
                    unset($user->personality);
                    unset($user->video);
                    $user->last_login = $user->updated_at;
                    unset($user->updated_at);
                    $usx[$k] = $user;
                }
                
        $username = $user->username;
        $status = 0; 
        $photo = 0;
        $filepath = '/agreement/agreement_'.$username.'.pdf';
        $agreement = Storage::disk('s3')->url($filepath);

        $filepath = '/agreement/aadhar_student_'.$username.'.pdf';
        $aadhar_student = Storage::disk('s3')->url($filepath);

        $filepath = '/agreement/aadhar_parent_'.$username.'.pdf';
        $aadhar_parent = Storage::disk('s3')->url($filepath);


        $filepath = '/agreement/photo_'.$username.'.png';
        $photo_png = Storage::disk('s3')->url($filepath);
        $filepath = '/agreement/photo_'.$username.'.jpg';
        $photo_jpg = Storage::disk('s3')->url($filepath);
        $filepath = '/agreement/photo_'.$username.'.jpeg';
        $photo_jpeg = Storage::disk('s3')->url($filepath);
        if($photo_png)
            $photo  = $photo_png;
        else if($photo_jpg)
            $photo = $photo_jpg;
        else if($photo_jpeg)
            $photo = $photo_jpeg;

        if($photo && $agreement && $aadhar_parent && $aadhar_student){
            $status = 1;
            $token = $request->get('token');
            if($token=='ppofficerwx4356'){
                $data['agreement'] = $agreement;
                $data['aadhar_student'] = $aadhar_student;
                $data['aadhar_parent'] = $aadhar_parent;
                $data['photo'] = $photo;
                return $data;
            }
        }
    }

    public function agreement(Request $request){


        if($request->get('username'))
            $user = User::where('username',$request->get('username'))->first();
        else
            $user = \auth::user();
        
        $username = $user->username;
        $status = 0; 
        $photo = 0;
        $filepath = '/agreement/agreement_'.$username.'.pdf';
        $agreement = Storage::disk('s3')->url($filepath);

        $filepath = '/agreement/aadhar_student_'.$username.'.pdf';
        $aadhar_student = Storage::disk('s3')->url($filepath);

        $filepath = '/agreement/aadhar_parent_'.$username.'.pdf';
        $aadhar_parent = Storage::disk('s3')->url($filepath);


        $filepath = '/agreement/photo_'.$username.'.png';
        $photo_png = Storage::disk('s3')->url($filepath);
        $filepath = '/agreement/photo_'.$username.'.jpg';
        $photo_jpg = Storage::disk('s3')->url($filepath);
        $filepath = '/agreement/photo_'.$username.'.jpeg';
        $photo_jpeg = Storage::disk('s3')->url($filepath);
        if($photo_png)
            $photo  = $photo_png;
        else if($photo_jpg)
            $photo = $photo_jpg;
        else if($photo_jpeg)
            $photo = $photo_jpeg;

        if($photo && $agreement && $aadhar_parent && $aadhar_student){
            $status = 1;
            $token = $request->get('token');
            if($token=='ppofficerwx4356'){
                $data['agreement'] = $agreement;
                $data['aadhar_student'] = $aadhar_student;
                $data['aadhar_parent'] = $aadhar_parent;
                $data['photo'] = $photo;

                $data = json_encode($data,JSON_PRETTY_PRINT);
                header('Content-Type: application/json; charset=utf-8');
                echo ($data);
                exit();
            }
        }
            
        
         /* If image is given upload and store path */
         if(isset($request->all()['file_agreement'])){
            $file      = $request->all()['file_agreement'];
            
            if($file->getClientOriginalExtension()=='pdf')
            {
                $filepath = '/agreement/agreement_'.$username.'.pdf';

                if(Storage::disk('s3')->exists($filepath)){
                    Storage::disk('s3')->delete($filepath);
                }

                Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                flash('Agreement PDF Successfully updated')->success();

                return redirect()->route('profile.agreement');

            }else{
                flash('Only pdf format supported for Agreement')->error();
                return redirect()->back();
            }   
        }

             if(isset($request->all()['file_aadhar_student'])){

                $file      = $request->all()['file_aadhar_student'];
                $username = \auth::user()->username;
                if($file->getClientOriginalExtension()=='pdf')
                {
                    $filepath = '/agreement/aadhar_student_'.$username.'.pdf';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }
                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                    flash('Student Aadhar PDF Successfully updated')->success();
                    return redirect()->route('profile.agreement');
                    
                }else{
                    flash('Only pdf format supported for Student Aadhar')->error();
                    return redirect()->back();
                }   

                

            }

              if(isset($request->all()['file_aadhar_parent'])){

                $file      = $request->all()['file_aadhar_parent'];
                $username = \auth::user()->username;
                if($file->getClientOriginalExtension()=='pdf')
                {
                    $filepath = '/agreement/aadhar_parent_'.$username.'.pdf';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }
                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                    flash('Parent Aadhar PDF Successfully updated')->success();
                    return redirect()->route('profile.agreement');
                    
                }else{
                    flash('Only pdf format supported for Parent Aadhar')->error();
                    return redirect()->back();
                }   

                

            }

              if(isset($request->all()['file_photo'])){

                $file      = $request->all()['file_photo'];
                $username = \auth::user()->username;
                if($file->getClientOriginalExtension()=='png')
                {
                    $filepath = '/agreement/photo_'.$username.'.png';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }
                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                    flash('Student Photo  Successfully updated')->success();
                    return redirect()->route('profile.agreement');
                    
                }else if($file->getClientOriginalExtension()=='jpg')
                {
                    $filepath = '/agreement/photo_'.$username.'.jpg';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }
                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                    flash('Student Photo Successfully updated')->success();
                    return redirect()->route('profile.agreement');
                    
                }else if($file->getClientOriginalExtension()=='jpeg')
                {
                    $filepath = '/agreement/photo_'.$username.'.jpeg';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }
                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');
                    flash('Student Photo Successfully updated')->success();
                    return redirect()->route('profile.agreement');
                    
                }
                else{
                    flash('Only png & jpg format supported for Photo')->error();
                    return redirect()->back();
                }   

            }


        return view('appl.user.agreement')->with('user',$user)->with('status',$status);

    }


    public function apiuser(Request $request){
        $token = $request->get('token');
        $email = $request->get('email');
        $user_id = $request->get('user_id');
        $info = $request->get('info');
        $job = $request->get('job');
        $practice = $request->get('practice');
        $assessment = $request->get('assessment');
        $mode=$request->get('mode');
        if($token=='ppofficerwx4356'){
            if($email || $user_id){
                if($email)
                $user = User::where('email',$email)->first();
                else if($user_id)
                $user = User::where('id',$user_id)->first();

                unset($user->password);
                unset($user->language);
                unset($user->fluency);
                unset($user->confidence);
                unset($user->personality);
                unset($user->video);
                $user->last_login = $user->updated_at;
                unset($user->updated_at);

                if(!$mode){
                    $user = json_encode($user);
                    header('Content-Type: application/json; charset=utf-8');
                    echo ($user);
                    exit();
                }else{
                    if($mode=='job'){
                       // my jobs
                        foreach($user->posts as $k=>$p){

                                $posts[$k]['id'] = $p->id;
                                $posts[$k]['name'] = $p->title;
                                $j = $user->posts->find($p->id);
                                $posts[$k]['created_at'] = $j->created_at;
                        }
                        $user->myjobs = $posts;
                        $user->myjob_count = count($user->posts);

                    }
                    unset($user->posts);
                    $user = json_encode($user,JSON_PRETTY_PRINT);
                    header('Content-Type: application/json; charset=utf-8');
                    echo ($user);
                    exit();
                }
               

            }elseif($info){
                 $users = User::where('info',$info)->get();
                 $uids = $users->pluck('id')->toArray();
                 $usx=[];
                 foreach($users as $k=>$user){
                    unset($user->password);
                    unset($user->language);
                    unset($user->fluency);
                    unset($user->confidence);
                    unset($user->personality);
                    unset($user->video);
                    $user->last_login = $user->updated_at;
                    unset($user->updated_at);
                    $usx[$k] = $user;
                }

                if($practice){
                    $course = Cache::get('course_'.$practice);
                    if(!$course){
                        $course = Course::where('slug',$practice)->first();
                        $course_data = $course->category_list($course->slug);
                        $course->categories = json_decode(json_encode($course_data['categories']));
                        $course->ques_count = $course_data['ques_count'];
                        $course->nodes = $course_data['nodes'];
                        $course->exams = $course_data['exams'];
                        $course->tests = $course_data['tests'];
                    }

                    
                    
                    $prac = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->orderBy('created_at','desc')->get()->groupBy('user_id');

                    $topics = [];
                    $categories = Category::get();
                    $user_data =[];
                    $pset=[];
                   
                    foreach($usx as $k=>$u){
                        if(isset($prac[$u->id]))
                        $pset = $prac[$u->id]->groupBy('category_id');
                        $user_data['user_completed']=0;
                        $user_data['total'] = 0;
                        $user_data['percentage'] = 0;

                        foreach($course->categories  as $cm=>$cp){
                            $user_data['total'] = $user_data['total'] + $cp->total;
                        }
                        foreach($pset as $pid=>$p){
                            $topic = $categories->find($pid);
                            $cid = $topic->id;
                            $usx[$k]->last_practiced_at = $p[0]->created_at;
                            $topic_name = $topic->name;
                            $topics[$topic_name]['user_completed'] = count($p); 
                            $topics[$topic_name]['last_practiced_at'] = $p[0]->created_at;
                            $user_data['user_completed'] = $user_data['user_completed'] + $topics[$topic_name]['user_completed'];
                            $topics[$topic_name]['total'] = $course->categories->$cid->total;
                        }

                        if($user_data['total']!=0)
                            $user_data['percentage'] = round($user_data['user_completed']/$user_data['total'] * 100,2);
                        $usx[$k]->practice_track  = $topics;
                        $usx[$k]->practice_percent  = $user_data;
                    }

                }else if($assessment){
                    $exam = Cache::get('test_'.$assessment);
                    if(!$exam){
                        $exam = Exam::where('slug',$assessment)->first();
                    }
                    $tests_overall = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$uids)->get()->groupBy('user_id');

                    foreach($usx as $k=>$u){
                        $usx[$k]->assessment = $tests_overall[$u->id]; 
                    }

                }

                $users = json_encode($usx,JSON_PRETTY_PRINT);
                header('Content-Type: application/json; charset=utf-8');
                echo ($users);
                exit();

            }elseif($job){

                $post = Post::where('slug',$job)->first();
                if(!$post)
                    $users =[];
                else
                $users = $post->users;
                $usx=[];


                foreach($users as $k=>$user){
                    unset($user->password);
                    unset($user->language);
                    unset($user->fluency);
                    unset($user->confidence);
                    unset($user->personality);
                    unset($user->video);
                    $user->last_login = $user->updated_at;
                    unset($user->updated_at);
                    
                    $user->applied_at = $user->pivot->created_at;
                    $data = json_decode($user->pivot->data);

                    $user->accesscode= $data->accesscode;
                    //$user->post = $post;
                
                    unset($user->pivot);
                    $usx[$k] = $user;

                   
                }

                unset($post->users);

                $usx['job'] = $post;
                
                $users = json_encode($usx,JSON_PRETTY_PRINT);
             
                header('Content-Type: application/json; charset=utf-8');
                echo ($users);
                exit();

            }


        }else{
            abort('403','Unauthorized Access');
        }
    }


    public function mydetails(Request $request)
    {
        $user = \auth::user();
         if($request->get('update')){
            $user->phone = $request->get('phone');
            $user->name= $request->get('name');
        $user->roll_number = $request->get('roll_number');
        $user->info = $request->get('info');
        $user->save();
        Cache::forget('id-' . $user->id);
        Cache::forget('user_'.$user->id);

        flash('Details Successfully updated')->success();
        return redirect()->route('profile.mydetails');

        }
        return view('appl.user.mydetails')->with('user',$user);
    }


    public function details(Request $request)
    {
        $user = \auth::user();
         if($request->get('update')){
            $user->phone = $request->get('phone');
            $user->name= $request->get('name');
        $user->roll_number = $request->get('roll_number');
        $user->hometown = $request->get('hometown');
        $user->current_city = $request->get('current_city');
        $user->dob = $request->get('dob');
        $user->gender = $request->get('gender');
        $user->video = $request->get('video');
        $user->personality = $request->get('personality');
        $user->confidence = $request->get('confidence');
        $user->fluency = $request->get('fluency');
        $user->language = $request->get('language');
        $user->info = $request->get('info');
        $user->save();
        Cache::forget('id-' . $user->id);
        Cache::forget('user_'.$user->id);

        flash('Details Successfully updated')->success();
        return redirect()->route('profile.details');

        }
        return view('appl.user.details')->with('user',$user);
    }

    public function resume(Request $request)
    {
         if($request->get('delete')){
            $username = \auth::user()->username;
            $filepath = '/resume/resume_'.$username.'.pdf';
            
            if(Storage::disk('s3')->exists($filepath)){
                Storage::disk('s3')->delete($filepath);
            }

            flash('PDF item removed from server')->success();
            if(request()->get('redirect'))
            return redirect()->to(request()->get('redirect'));
            else
            return redirect()->route('resume.upload');

        }
        return view('appl.user.resume');
    }

    public function resumesave(Request $request)
    {

        if($request->get('delete')){
            $username = \auth::user()->username;
            $filepath = '/resume/resume_'.$username.'.pdf';
            
            if(Storage::disk('s3')->exists($filepath)){
                Storage::disk('s3')->delete($filepath);
            }

            flash('PDF item removed from server')->success();
            if(request()->get('redirect'))
            return redirect()->to(request()->get('redirect'));
            else
            return redirect()->route('resume.upload');

        }


         /* If image is given upload and store path */
            if(isset($request->all()['file'])){

                $file      = $request->all()['file'];
                $username = \auth::user()->username;
                if($file->getClientOriginalExtension()=='pdf')
                {
                    $filepath = '/resume/resume_'.$username.'.pdf';
            
                    if(Storage::disk('s3')->exists($filepath)){
                        Storage::disk('s3')->delete($filepath);
                    }


                    
                    Storage::disk('s3')->put($filepath, file_get_contents($file),'public');

                    flash('PDF Successfully updated')->success();
                    if(request()->get('redirect'))
                    return redirect()->to(request()->get('redirect'));
                    else
                    return redirect()->route('resume.upload');
                    
                }else{
                    flash('Only pdf format supported')->error();
                    return redirect()->back();
                }   

                

            }else{
                $request->merge(['image' => '']);
            }

            flash('Unknown error in uploading the pdf file')->danger();
            if(request()->get('redirect'))
            return redirect()->to(request()->get('redirect'));
            else
            return redirect()->route('resume.upload');
       
    }

    public function update_user_tables()
    {
        $users = User::whereNull('college_id')->get();
        $user_ids = $users->pluck('id')->toArray();

        $user_details = User_Details::whereIn('user_id',$user_ids)->get()->groupBy('user_id');

        foreach($users as $user){
            //dd($user_details[$user->id][0]['phone']);
            $user->roll_number = $user_details[$user->id][0]['roll_number'];
            $user->year_of_passing = $user_details[$user->id][0]['year_of_passing'];
            $user->phone = $user_details[$user->id][0]['phone'];
            //dd($user->colleges->first());
            if($user->colleges)
            $user->college_id = $user->colleges->first()->id;
            if($user->branches->first())
            $user->branch_id = $user->branches->first()->id;

            echo $user->id.' - '.$user->name.'<br>';
            $user->save();
        }
    }

    public function validation(Request $request){
        $user = \auth::user();
        return view('appl.user.validate.index')->with('user',$user);
    }

    public function hrmanagers()
    {

        $hr = Role::where('slug','hr-manager')->first();
        $users = $hr->users;
        

        foreach($users as $k=>$user){

            $users[$k]->attempts_all  =0;
            $users[$k]->attempts_lastmonth =0;
            $users[$k]->attempts_thismonth =0;
        foreach($user->exams as $exam){
            $users[$k]->attempts_all = $users[$k]->attempts_all + $exam->getAttemptCount();
            $users[$k]->attempts_lastmonth = $users[$k]->attempts_lastmonth + $exam->getAttemptCount(null,'lastmonth');
            $users[$k]->attempts_thismonth = $users[$k]->attempts_thismonth + $exam->getAttemptCount(null,'thismonth');
          }
        }
            
        if($users)
        {
            return view('appl.user.hrmanagers')
                    ->with('users',$users);
        }else
            abort(404,'User not found');
    }


    public function userlist(Request $r){


    if(!\auth::user())
        abort('403','Unauthorized Access');

    if(!\auth::user()->checkRole(['hr-manager','administrator']))
        abort('403','Unauthorized Access');

    $filename = "exports/Userlist_".subdomain().".csv";

    if(request()->get('hr')){
        $users = User::where('role',11)->get();
        foreach($users as $user){
            if(!$user->roles->contains(28))
                $user->roles()->attach(28);
        }

        echo  count($users);

        $users = User::where('role',10)->get();
        foreach($users as $user){
            if(!$user->roles->contains(28))
                $user->roles()->attach(28);
        }
        echo "<br>";
        echo  count($users)."<br>";

        dd('done');
    }

    $ct=0;
    if(request()->get('sanitize')){
        $usrs = User::where('client_slug',subdomain())->whereDate('created_at', '>', '2021-08-01')->get();
        foreach($usrs as $ud){
            if(request()->get('do')){
                $ud->email = trim(strtolower($ud->email));
                $ud->username = str_replace('-','',$ud->username);
                $ud->username = str_replace('.','0',$ud->username);
                $ud->username = strtolower(str_replace('_','',$ud->username));
                $ud->save();
            }
            echo $ud->id."<br>";
            $ct++;
        }
        echo "total - ".$ct;
        flash('Updated all users - '.$ct)->success();
        dd();
    }

    if(request()->get('export')){

        // $users = User::where('client_slug',subdomain())->get();
        // if(!Storage::disk('s3')->exists($filename))
        //     Storage::disk('s3')->delete($filename);

        // //dd($users);
        // request()->session()->put('users',$users);
        // ob_end_clean(); // this
        // ob_start(); 
        // //ini_set('memory_limit', '1024M');
        // Excel::store(new UExport, $filename,'s3');

        // flash('Export is queued, it will be ready for download in 5min.')->success();
    }

    if(request()->get('downloadexport')){

        $users = User::where('client_slug',subdomain())->get();

        if(count($users)>0){
            request()->session()->put('users',$users);

            ob_end_clean(); // this
            ob_start(); 
            $filename ="Userlist_".subdomain().".xlsx";
            return Excel::download(new UExport2, $filename);

        }else{

            if(!Storage::disk('s3')->exists($filename))
                flash('Report is not available. Re-queue the data after 5 mins.')->success();
            else{
                $file = Storage::disk('s3')->get($filename);

                $headers = [
                    'Content-Type' => 'text/csv', 
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => "attachment; filename={$filename}",
                    'filename'=> $filename
                ];
                return response($file, 200, $headers);
            }

        }
        
    }


    $month = $r->get('month');

    if($month=='thismonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->month);
    elseif($month=='lastmonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth()->month);
    elseif($month=='lastbeforemonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth(2)->month);
    else
        $users = User::where('client_slug',subdomain());

    $users = $users->where('status','<>','2');
    if($r->get('info')){
        $users = $users->where('info',$r->get('info'));
    }

    $item = $r->get('item');
    if(is_numeric($item)){
        $users = $users->where('phone','LIKE',"%$item%");
    }elseif (strpos($r->get('item'), '@') !== false) {
        $users = $users->where('email','LIKE',"%$item%");
    }
    elseif($r->get('item')){
        $users = $users->where('name','LIKE',"%$item%");
    }

    $uids = null;
    

    if($r->get('info'))
    $users = Cache::remember('users_paginate_'.subdomain().'_'.$r->get('info'),240,function()use ($users){
        return $users->orderBy('id','desc')->with('roles')->paginate(30);
    });
    elseif(is_numeric($item)){
        $users = $users->orderBy('id','desc')->with('roles')->paginate(30);
    }
    elseif($r->get('item')){
       $users = $users->orderBy('id','desc')->with('roles')->paginate(30);
    }elseif (strpos($r->get('item'), '@') !== false) {
        $users = $users->orderBy('id','desc')->with('roles')->paginate(30);
    }
    else
        $users = Cache::remember('users_paginate_'.subdomain(),240,function()use ($users){
        return $users->orderBy('id','desc')->with('roles')->paginate(30);
    });



    if($uids){
    $data['users_all'] =  User::where('client_slug',subdomain())->where('status','<>','2')->whereIn('id',$uids)->count();
    $data['users_lastmonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
    $data['users_thismonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->month)->count();
    $data['users_lastbeforemonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();

    }else{
        $data = Cache::remember('data_users_'.subdomain(),240, function(){
            $data['users_all'] =  User::where('client_slug',subdomain())->where('status','<>','2')->count();
        $data['users_lastmonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $data['users_thismonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereMonth('created_at', Carbon::now()->month)->count();
        $data['users_lastbeforemonth'] = User::where('client_slug',subdomain())->where('status','<>','2')->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
        return $data;
        });
        

    }
    
    $count=0;
    if($r->get('role')=='student')
    foreach($users as $u){
        if($u->roles()->first())
            $count++;
    }
    
    if($r->get('username'))
        $user = User::where('username',$r->get('username'))->first();
    else    
        $user = \auth::user();

    $user_info = Cache::remember('user_info_'.subdomain(),240,function(){
        return User::where('client_slug',subdomain())->get()->groupBy('info');
    });


    
      return view('appl.user.userlist')
                    ->with('count',$count)
                    ->with('user_info',$user_info)
                    ->with('users',$users)->with('data',$data)->with('user',$user);

    }



    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }


    public function upload_users(Request $request)
    {

        if(request()->get('college') && isset($request->all()['file'])){
            $file      = $request->all()['file'];
            $data = $this->csvToArray($file);
         
            for ($i = 0; $i < count($data); $i ++)
            {
                $name = $data[$i]['college'];
                $c = College::where('name',$name)->first();
                if(!$c){
                    $c = new College();
                    $c->name = $name;
                    $c->save();
                     echo $data[$i]['college']." - added<br>";
                }else
                echo $data[$i]['college']." - exists <br>";
            }
            //dd($data);
            return 1;
            exit();
        }


        $data = [];
        if(isset($request->all()['file'])){

            $file      = $request->all()['file'];
            if(strtolower($file->getClientOriginalExtension()) != 'csv'){
                flash('Supports only .csv files')->error();
                return redirect()->back()->withInput(); 
            }

            $data = $this->csvToArray($file);
            
            for ($i = 0; $i < count($data); $i ++)
            {
                $client_slug = $data[$i]['client_slug'];
                $u = User::where('email',$data[$i]['email'])->where('client_slug',$client_slug)->first();

                $br =["CSE"=>"9","IT"=>10,"ECE"=>11,"EEE"=>12,"MECH"=>13,"CIVIL"=>14,"OTHER"=>15];

                if(!is_numeric($data[$i]['branch_id'])){
                    if(isset($br[$data[$i]['branch_id']]))
                        $bid = $br[$data[$i]['branch_id']];
                    else
                        $bid=15;
                }else{
                    $bid = $data[$i]['branch_id'];
                }

                if(!$u){
                    $u = new User([
                   'name'     => $data[$i]['name'],
                   'email'    => strtolower($data[$i]['email']), 
                   'username'    => strtolower($this->username($data[$i]['email'])), 
                   'client_slug' =>$client_slug,
                   'phone'    => $data[$i]['phone'], 
                   'roll_number'    => trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[$i]['roll_number'])), 
                   'branch_id' => $bid,
                   'college_id' => $data[$i]['college_id'],
                   'year_of_passing' =>$data[$i]['year_of_passing'],
                   'tenth' =>$data[$i]['tenth'],
                   'twelveth' =>$data[$i]['twelveth'],
                   'bachelors' =>$data[$i]['bachelors'],
                   'current_city' =>$data[$i]['current_city'],
                   'hometown' =>$data[$i]['hometown'],
                   'info'=>$data[$i]['info'],
                   'password' => bcrypt($data[$i]['phone']),
                   'status'   => 1,
                    ]);

                    $u->year_of_passing = $data[$i]['year_of_passing'];
                    $u->tenth = $data[$i]['tenth'];
                    $u->twelveth = $data[$i]['twelveth'];
                    $u->bachelors = $data[$i]['bachelors'];
                    $u->current_city = $data[$i]['current_city'];
                    $u->hometown = $data[$i]['hometown'];
                    $u->info = $data[$i]['info'];
                    $u->status = $data[$i]['status'];

                    $u->save();
                    $data[$i]['exists'] = 0;
                    
                }else{
                    if($data[$i]['name'])
                    $u->name = $data[$i]['name'];


                    if($data[$i]['phone'])
                    $u->phone = $data[$i]['phone'];


                    if($data[$i]['roll_number'])
                    $u->roll_number = trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[$i]['roll_number']));

                    
                    if($bid)
                    $u->branch_id = $bid;

                    if(isset($data[$i]['role'])){
                        $u->role = intval($data[$i]['role']);
                        if($u->role==10 || $u->role==11){
                            if(!$u->roles->contains(28))
                            $u->roles()->attach(28);
                        }elseif($u->role==1){
                            $u->roles()->detach(28);
                        }
                        
                    }
                    
                    if(isset($data[$i]['password']))
                    if($data[$i]['password'])
                    $u->password = bcrypt($data[$i]['password']);


                    if(isset($data[$i]['products']))
                    if($data[$i]['products']){


                        $p = explode(',',$data[$i]['products']);

                        foreach($p as $pt){
                            if(isset($data[$i]['validity']))
                                $validity = $data[$i]['validity'];
                            else
                                $validity = 12;
                            $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($validity*31).' days'));
                            $product = Product::where('slug',$pt)->first();

                            if(!$u->products->contains($product->id)){

                              $u->products()->attach($product->id,['validity'=>$validity,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);  
                            }
                            
                        }
                    }

                    if($data[$i]['college_id'])
                    $u->college_id = $data[$i]['college_id'];

                    // if($data[$i]['branch_id'])
                    // $u->branch_id = $data[$i]['branch_id'];

                    if($data[$i]['year_of_passing'])
                    $u->year_of_passing = $data[$i]['year_of_passing'];

                    if($data[$i]['tenth'])
                    $u->tenth = $data[$i]['tenth'];

                    if($data[$i]['twelveth'])
                    $u->twelveth = $data[$i]['twelveth'];

                    if($data[$i]['bachelors'])
                    $u->bachelors = $data[$i]['bachelors'];

                    if($data[$i]['current_city'])
                    $u->current_city = $data[$i]['current_city'];

                    if($data[$i]['hometown'])
                    $u->hometown = $data[$i]['hometown'];

                    if($data[$i]['info'])
                    $u->info = $data[$i]['info'];

                    if($data[$i]['status'])
                    $u->status = $data[$i]['status'];

                    $u->save();
                    $data[$i]['exists'] = 1;
                }
                
            }

            flash('Successfully uploaded ('.count($data).') users.')->success();
        }


        

        return view('appl.user.upload')
                    ->with('data',$data); 
    }

    public function username($email){
        $parts = explode("@", $email);
        $username = $parts[0];
        $u = User::where('username',$username)->first();
        if($u){
            $username = $username.rand(100,9999);
        }
        return $username;
    }
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {

        $username = substr($username, 1);
        $user = User::where('username',$username)->with('college')->with('branch')->first();

        $this->authorize($user);
        
            $user_details = null;
        // $user_details = User_Details::where('user_id',$user->id)->first();
        // if(!$user_details)
        //     $user_details = new User_Details();
            
        // $user_details->countries = $user_details->getCountry();

        $colleges = College::orderby('name','asc')->get();

        if(request()->get('dump')){
            dd($colleges);
        }

        if(request()->get('dump2')){
            dd(College::orderby('name','asc')->get());
        }

        if(request()->get('dump3')){
            dd(College::get());
        }

        if(!count($colleges)){
            $colleges = College::all();
        }

        $branches = Branch::all();

            
        if($user)
        {
            $editor = false;
            if(request()->get('complete_profile')){
                $view = 'complete_profile';
            }
            else{
                $view = 'edit';
                $editor  = true;
            }
            return view('appl.user.'.$view)
                    ->with('user',$user)
                    ->with('colleges',$colleges)
                    ->with('branches',$branches)
                    ->with('editor',$editor)
                    ->with('user_details',$user_details);
        }else
            abort(404,'User not found');
    }



    public function changePassword(Request $r){

        if($r->get('password')){
            $password = $r->get('password');
            $password_conf = $r->get('password_confirmation');


            if($password != $password_conf){
                flash('Password and Confirm-password mismatch...kindly re-enter password')->error();
                 return redirect()->back()->withInput();
            }if(strlen($password)<8){
                flash('Kindly use a password of character length atleast 8')->error();
                 return redirect()->back()->withInput();
            }

            else{
                $u = \auth::user();
                $u->password = bcrypt($password);
                $u->save();
                flash('Password succcessfully updated. Kindly relogin.')->success();
                auth()->logout();

                return redirect()->route('login');
            }
        }
        
        return view('auth.change');

    }

    public function sendOTP(Request $r){
        $code = $r->get('code');
        $url = "https://2factor.in/API/V1/95f80a8a-3945-11ec-a13b-0200cd936042/SMS/+91".$r->get('number')."/".$code;
        $d = $this->curl_get_contents($url);
        echo $d;
        
    }

    function curl_get_contents($url)
    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }



    public function apiregister(Request $request)
    {

        $phone = $request->phone;
        $email = $request->email;
        $name = $request->name;
        $hcode = $request->hashcode;
        $user = User::where('email',$email)->where('client_slug',subdomain())->first();
        $parts = explode("@", $request->email);
        $username = $parts[0];

        $u = User::where('username',$username)->first();

        if($u){
            $username = $username.'_'.rand(10,100);
        }

        if($hcode!='piofxapp734'){
            $data['error'] = 1;
            $data['message'] = 'Invalid hashcode used';
        }
        
        else if($user){
            $data['error'] = 2;
            $data['message'] = 'User with email ('.$email.') already exists';
            
        }else if(!$email || !$phone || !$name){
            $data['error'] = 1;
            $data['message'] = 'Email or phone or name not given';
        }else{
            $user = User::create([
                'name' => $name,
                'username' => strtolower($username),
                'email' => strtolower($request->email),
                'password' => bcrypt($phone),
                'activation_token' => str_random(20),
                'client_slug' => subdomain(),
                'user_id' =>'1',
                'status'=>1,
            ]);

            $user->phone = $request->get('phone');
            $user->roll_number = $request->get('fathername');
            $user->hometown = $request->get('hometown');
            $user->current_city = $request->get('current_city');
            $user->dob = $request->get('dob');
            $user->gender = $request->get('gender');
            $user->video = $request->get('video');
            $user->personality = $request->get('personality');
            $user->confidence = $request->get('confidence');
            $user->fluency = $request->get('fluency');
            $user->language = $request->get('language');

            $user->save();

            $data['error'] = 0;
            $data['message'] = 'User with email ('.$email.') is created';
        }


        echo json_encode($data);
        exit();
        

    }

    public function saveregister(Request $request)
    {
        $code = intval(request()->session()->get('code'));
        $code_verify = intval($request->otp);

        

        if($code_verify != $code){
            flash('Sms verification code did not match.')->error();
                 return redirect()->back()->withInput();
        }

        if($request->name==null){
            flash('Name cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->email==null){
            flash('Email cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        // if($request->fathername==null){
        //     flash('Fathers name cannot be empty')->error();
        //          return redirect()->back()->withInput();
        // }

        if($request->phone==null){
            flash('Phone number cannot be empty')->error();
                 return redirect()->back()->withInput();
        }


        if($request->password){
            if($request->password != $request->password_confirmation){
                flash('Password and Confirm-password mismatch...kindly re-enter password')->error();
                 return redirect()->back()->withInput();
            }
        }

        $user = User::where('email',$request->email)->where('client_slug',subdomain())->first();
     

        if($user){
            flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use a different email.')->error();
            return redirect()->back()->withInput();
        }

        $url = url()->full();
        $subdomain = subdomain();


        $parts = explode("@", $request->email);
        $username = $parts[0];

        $u = User::where('username',$username)->first();

        if($u){
            $username = $username.'_'.rand(10,100);
        }


        $usx = Cache::get('uid_1');

        if(!$usx){

            $usx = User::where('email','packetcode@gmail.com')->first();
            Cache::forever('uid_1',$usx);
        }
        $udx = null;
        if(request()->get('rcode'))
        {
            $udx = User::where('username',request()->get('rcode'))->first();
            if($udx)
                $usx = $udx;
        }

        if(subdomain()=='packetprep')
         $user = User::create([
            'name' => $request->name,
            'username' => strtolower($username),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'activation_token' => str_random(20),
            'client_slug' => $subdomain,
            'user_id' =>$usx->id,
            'status'=>5,
        ]);

        else
        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($username),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'activation_token' => str_random(20),
            'client_slug' => $subdomain,
            'user_id' =>$usx->id,
            'status'=>1,
        ]);

        $user->phone = $request->get('phone');
        $user->roll_number = $request->get('fathername');
        $user->hometown = $request->get('hometown');
        $user->current_city = $request->get('current_city');
        $user->dob = $request->get('dob');
        $user->gender = $request->get('gender');
        $user->video = $request->get('video');
        $user->personality = $request->get('personality');
        $user->confidence = $request->get('confidence');
        $user->fluency = $request->get('fluency');
        $user->language = $request->get('language');
        

        if(subdomain()=='packetprep'){
            $user->roll_number = $request->get('roll_number');
            $user->college_id = $request->get('college_id');
            $user->branch_id = $request->get('branch_id');
            $user->year_of_passing = $request->get('yop');
            $user->tenth = $request->get('tenth');
            $user->twelveth = $request->get('twelveth');
            $user->bachelors = $request->get('bachelors');
            $user->save();
            Mail::to($user->email)->send(new ActivateUser2($user));

            $code = request()->get('rcode');
            if($code=='packetprep'){
                //pro access
                    $pid = 10;
                    $month = 12;

                    $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                    if(!$user->products->contains($pid)){
                        $product = Product::where('id',$pid)->first();
                        if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                    }
            }
            if($udx){
                //pro access
                    $pid = 31;
                    $month = 12;

                    $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                    if(!$user->products->contains($pid)){
                        $product = Product::where('id',$pid)->first();
                        if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                    }
                }

            flash('Successfully created your account. Login with your email and password.')->success();
            return redirect()->route('login');
        }
        
        $user->save();
        

        flash('Successfully created your account.')->success();
        return redirect()->route('login');

    }

     public function hasSubdomain($url) {
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        return (count($exploded) > 2);
    }

    public function update_self(){
        $user = \auth::user();
        request()->request->add(['complete_profile' => '1']);
        if(isset($user->username))
            return $this->edit('@'.$user->username);
        else
            abort('403','Username not Found.Kindly reach out to administrator');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($username,Request $request)
    {
        
        $username = substr($username, 1);
        $obj=$user = User::where('username',$username)->first();
        // $user_details = User_Details::where('user_id',$user->id)->first();


        $this->authorize($user);

        /* create user details if not defined */
        // if(!$user_details)
        // {
        //     $user_details_new = new User_Details;
        //     $user_details_new->user_id = $user->id;
        //     $user_details_new->country = 'IN';
        //     $user_details_new->city = '';
        //     $user_details_new->save();
        //     $user_details = User_Details::where('user_id',$user->id)->first();
        // }

        if($request->get('newpassword'))
        {
            $user->password = Hash::make($request->get('newpassword'));
           $user->save();
           flash('Password updated')->success();
                 return redirect()->back()->withInput();

        }

        if($request->get('delete')==1)
        {
             if($obj->details)
            $obj->details->delete();
        $obj->roles()->detach();
        $obj->colleges()->detach();
        $obj->branches()->detach();
        $obj->zones()->detach();
        if($obj->exams)
            $obj->exams()->delete();
        Test::where('user_id',$user->id)->delete();
        Tests_Overall::where('user_id',$user->id)->delete();
        Tests_Section::where('user_id',$user->id)->delete();
        if($obj->products)
            $obj->products()->detach();
        $obj->delete();
           flash('user deleted')->success();
            return redirect()->route('dashboard');

        }

        // update basic data
        $user->name = $request->name;
        if($request->password){
            if($request->password == $request->repassword)
                $user->password = Hash::make($request->password);
            else
            {
                flash('Password and Repassword mismatch...kindly re-enter password')->error();
                 return redirect()->back()->withInput();
            }
        }

        /* If image is given upload and store path */
            if(isset($request->all()['file_'])){

                $image = '/articles/profile_'.$username;
            
                if(Storage::disk('s3')->exists($image.'.jpg')){
                    Storage::disk('s3')->delete($image.'.jpg');
                }

                 if(Storage::disk('s3')->exists($image.'.png')){
                    Storage::disk('s3')->delete($image.'.png');
                }

                 if(Storage::disk('s3')->exists($image.'.jpeg')){
                    Storage::disk('s3')->delete($image.'.jpeg');
                }

                $file      = $request->all()['file_'];

                $folder = public_path('../public/storage/profile/');

                if (!Storage::exists($folder)) {
                    Storage::makeDirectory($folder, 0775, true, true);
                }

                try {
                    $name = 'profile_'.$username;
                $filename = 'profile_'.$username.'.'.$file->getClientOriginalExtension();

                $path = Storage::disk('public')->putFileAs('profile',$request->file('file_'),$filename);
                $image= jpg_resize('profile/'.$name,$path,150);

                Storage::disk('s3')->put('articles/'.$filename, (string)$image,'public');

                //Storage::disk('s3')->putFileAs('urq', new File($newpath), $filename);
                $path = Storage::disk('s3')->url('articles/'.$filename);

                //$path = Storage::disk('s3')->putFileAs('articles', $request->file('file_'),$filename,'public');
                $request->merge(['image' => $path]);
                } catch (Exception $e) {

                }

            }else{
                $request->merge(['image' => '']);
            }

        
        
       
        
        if($request->get('confidence')){
            $user->confidence = $request->get('confidence');
        }
        
        if($request->get('fluency')){
            $user->fluency = $request->get('fluency');
        }
        
        if($request->get('language')){
            $user->language = $request->get('language');

            $user->personality = round(($user->confidence+$user->fluency+$user->language)/3,1);
        }

        if($request->get('video'))
            $user->video = $request->get('video');

        if(\auth::user()->isAdmin()){
            $user->video = $request->get('video');
        }

        $user->roll_number = $request->roll_number;
        $user->college_id = $request->college_id;
        $user->branch_id = $request->branch_id;
        $user->hometown = $request->hometown;
        $user->current_city = ($request->current_city)?$request->current_city:' ';
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->tenth = $request->tenth;
        $user->twelveth = $request->twelveth;
        $user->bachelors = $request->graduation;
        $user->masters = $request->masters;
        $user->year_of_passing = $request->year_of_passing;
        $user->aadhar = $request->aadhar;
        $user->client_slug = $request->client_slug;
        $user->info = $request->get('info');
        

        $user->save();

        //update user details
        // $user_details->user_id = $user->id;

        // $user_details->bio = scriptStripper(summernote_imageupload($user,$request->bio));
        // //dd($user_details->bio);
        // $user_details->country = $request->country;
        // $user_details->city = ($request->city)?$request->city:' ';
        // $user_details->facebook_link = $request->facebook_link;
        // $user_details->twitter_link = $request->twitter_link;
        // $user_details->privacy = $request->privacy;
        // $user_details->phone = $request->phone;

        
    
        // $user_details->save();

        $metrics = $request->get('metrics');

        

        if($metrics){
            $user->metrics()->detach();
            foreach($metrics as $metric){

                    $user->metrics()->attach($metric);
            } 
        }
        
       
        Cache::forget('id-' . $user->id);
        Cache::forget('user_'.$user->id);

        


        flash('User data updated!')->success();
        if(request()->get('redirect'))
            return redirect()->to(request()->get('redirect'));
        return redirect()->route('profile','@'.$username);

    }

    /**
     * Edit the specified resource from storage by manager
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($username,Request $request)
    {
        $username = substr($username, 1);
        $user = User::where('username',$username)->first();
        $this->authorize($user);

        $user_details = User_Details::where('user_id',$user->id)->first();

        $all_userroles = (new Role)->get()->pluck('id');

        if($request->update)
        {
            if(!$user_details){
                $user_details = new User_Details;
                $user_details->user_id = $user->id;
                $user_details->country = 'IN';
                $user_details->city = '';
            }

            $user_details->designation = $request->designation;
            $user_details->save();
               
                
            foreach($all_userroles as $u_role){
                $role_name = 'role_'.$u_role;
                if($request->$role_name){
                    if(!$user->roles->contains($u_role))
                        $user->roles()->attach($u_role);
                }else{
                    if($user->roles->contains($u_role)){
                        $user->roles()->detach($u_role);
                    }
                }
            }

            $user->status = $request->status;
            $user->save();

            flash('User data updated!')->success();
            return redirect()->route('profile','@'.$username);
        }

        $userroles = array();
        foreach($user->roles as $role){
            array_push($userroles, $role->id);
        }

        $roles = Role::displayUserRoleUnorderedList((new Role)->get()->toTree(),['select_id'=>$userroles]);   

        if($user)
        {
            return view('appl.user.manage')
                    ->with('user',$user)
                    ->with('user_details',$user_details)
                    ->with('roles',$roles);
        }else
            abort(404,'User not found');
    }

    public function certificate($user){

        if($user=='sample'){
            $user = User::where('username','demo123')->first();
            
            return view('appl.user.certificate')
                    ->with('user',$user);
        }else{
            $user = User::where('username',$user)->first();
            if($user){

                if(count($user->referrals)>=50){
                    return view('appl.user.certificate')
                    ->with('user',$user);
                }else{
                    abort('403','referrals Credits are less than 50');
                }

            }else{
                abort('404','page not found');
            }
        }
    }



    public function performance(Request $request){

        if(!\auth::user())
        abort('403','Unauthorized Access');

        if(!\auth::user()->isSiteAdmin() )
        abort('403','Unauthorized Access');

        $client_slug = \Auth::user()->client_slug;
        $client = Client::where('slug',$client_slug)->first();


        if($request->get('info')){
            if(strpos($request->get('info'),',')!==false){
                $info_batches = explode(',',$request->get('info'));
                $users = User::where('client_slug',$client_slug)->where('status','<>','2')->whereIn('info',$info_batches)->get()->keyBy('id');
            }else   
                $users = User::where('client_slug',$client_slug)->where('status','<>','2')->where('info',$request->get('info'))->get()->keyBy('id');
        }else{
            $users = User::where('client_slug',$client_slug)->where('status','<>','2')->get()->keyBy('id');

            //abort(403,'batch info is mandatory');
        }

        if(isset($client))
        $settings = json_decode($client->settings);
        $exam_slugs = [];
        if(isset($settings->exams))
        $exam_slugs = explode(',',$settings->exams);
        $scores = [];
        if($request->get('exam')){
            if(strpos($request->get('exam'),',')!==false){
                $exam_slugs = explode(',',$request->get('exam'));
                $exams = Exam::whereIn('slug',$exam_slugs)->get()->keyBy('id');
            }else
                $exams = Exam::where('slug',$request->get('exam'))->get()->keyBy('id');

            
        }
        else if($request->get('course')){
            $id = $request->get('course');
             $course = Cache::get('course_'.$id);

            if(!$course){
                $course = Course::where('slug',$id)->first();
                $course_data = $course->category_list($course->slug);
                $course->categories = json_decode(json_encode($course_data['categories']));
                $course->ques_count = $course_data['ques_count'];
                $course->nodes = $course_data['nodes'];
                $course->exams = $course_data['exams'];
                $course->tests = $course_data['tests'];
            }
            $exams = $course->exams->keyBy('id');
        }
        elseif($request->get('info')){
            $examtype = Examtype::where('name',$request->get('info'))->where('client',subdomain())->first();
        
            if($examtype)
                $exams = Exam::where('examtype_id',$examtype->id)->get()->keyBy('id');
            else
                $exams = [];

        }

        else
         $exams = Exam::whereIn('slug',$exam_slugs)->get()->keyBy('id');


        
            foreach($exams as $e){
                $add=0;
               foreach($e->sections as $a=>$b){
                    $total = 0;
                    foreach($b->questions as $m=>$n){
                        $total = $total + $n->mark;
                    }
                    $scores[$e->id]['section'][$b->id] = $total;
                    $add = $add+ $total;
               }
               $scores[$e->id]['exam'] = $add;
            }

        $exam_ids =[];
        $user_ids = [];
        foreach($exams as $id=>$e){
            array_push($exam_ids,$id); 
            // if($request->get('exam')){
            //     if($request->get('exam')==$e->slug)
            //         array_push($exam_ids,$id);
            // }else{
               
            // }
            
        }


        
        
        //$allusers = User::where('client_slug',$client_slug)->where('status','<>','2')->get();
        $totalusers = 0;//$allusers->count();
        $user_info = 0;//$allusers->groupBy('info');
        

        foreach($users as $id=>$u){
            array_push($user_ids,$id);
        }
        $tests_overall = Tests_Overall::whereIn('test_id',$exam_ids)->whereIn('user_id',$user_ids)->get()->groupBy('user_id');




        $data = [];

        $data_sorted = [];
        $data_unsorted=[];


        //one exam requested
        $sections = null;
        $tests_sections = null;
        $batches=[];
      
        if($request->get('exam')){
            $tests_sections = Tests_Section::whereIn('test_id',$exam_ids)->whereIn('user_id',$user_ids)->get()->groupBy('user_id');
            
            
        }

        foreach($users as $id=>$u){
            $count =0;
            $total =0;
            $max=0;
            $cgpa=0;
            $data[$id]['user'] = $u;
            $data[$id]['test'] = [];
            $data[$id]['status'] = [];
            foreach($exams as $eid=>$e){
                $data[$id]['test'][$eid] = null;
                $data[$id]['status'][$eid] = null;
                $data[$id]['section'][$eid]  = [];
            }
            if(isset($tests_overall[$id]))
            foreach($tests_overall[$id] as $a=>$b){
                $data[$id]['test'][$b->test_id] = $b->score;
                $data[$id]['status'][$b->test_id] = $b->status;
                
                $total +=$b->score;
                $max += $b->max;
                $count++;
                if($b->max)
                $exams[$b->test_id]->max = $b->max;

                if(isset($batches[strtoupper($u->info)]['attempt']))
                {
                    $batches[strtoupper($u->info)]['attempt']++;
                }else{
                    $batches[strtoupper($u->info)]['attempt']=1;
                }
            }

            if(isset($tests_sections[$id])){

                 foreach($tests_sections[$id] as $a=>$b){
                    $data[$id]['section'][$b->test_id][$b->id] = $b->score;
                }

            }


            if($count)
            $cgpa = round($total/$max*10,2);
        
            $data[$id]['cgpa'] = $cgpa;
            if(isset($batches[strtoupper($u->info)]['total'])){
                $batches[strtoupper($u->info)]['total'] = $batches[strtoupper($u->info)]['total'] + $cgpa;
                $batches[strtoupper($u->info)]['count']++;
            }
            else{
                $batches[strtoupper($u->info)]['total'] = $cgpa;
                $batches[strtoupper($u->info)]['avg'] = 0;
                $batches[strtoupper($u->info)]['count'] = 1;
                $batches[strtoupper($u->info)]['name'] = strtoupper($u->info);
            }
            $data_unsorted[$id] = $cgpa;
            $data[$id]['count'] = $count;

        }

        foreach($batches as $h=>$k){
            if($batches[$h]['count']){
               $batches[$h]['avg'] =  round($batches[$h]['total'] /  $batches[$h]['count'],2);
               if(isset($batches[$h]['attempt'] ))
               $batches[$h]['attempt_avg'] =  round($batches[$h]['attempt'] /  $batches[$h]['count'] / count($exams),2)*100;
                else
                   $batches[$h]['attempt_avg'] = 0; 
               $batches[$h]['exam_count'] = count($exams);
            }
            
        }
       
        
        arsort($data_unsorted);
        foreach($data_unsorted as $k=>$v){
            $data_sorted[$k]['user'] = $data[$k]['user'];
            $data_sorted[$k]['test'] = $data[$k]['test'];
            $data_sorted[$k]['status'] = $data[$k]['status'];
            $data_sorted[$k]['cgpa'] = $data[$k]['cgpa'];
            if(isset($data[$k]['section']))
            $data_sorted[$k]['section'] = $data[$k]['section'];
            else
                $data_sorted[$k]['section'] = [];
            $data_sorted[$k]['count'] = $data[$k]['count'];
        }

       

        if(request('export')){
            if (ob_get_level()) ob_end_clean();
            return  Tests_overall::export($data_sorted,$exams);
        }else{
            return view('appl.user.performance')->with('data',$data_sorted)->with('exams',$exams)->with('user_info',$user_info)->with('totalusers',$totalusers)->with('scores',$scores)->with('batches',$batches);
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
        $obj = User::where('username',$id)->first();
        $this->authorize('update', $obj);
        if($obj->details)
            $obj->details->delete();
        $obj->roles()->detach();
        $obj->colleges()->detach();
        $obj->branches()->detach();
        $obj->zones()->detach();
        if($obj->exams)
            $obj->exams()->delete();
        if($obj->products)
            $obj->products()->detach();
        $obj->delete();

        flash('User is  Successfully deleted!')->success();
        return redirect()->route('admin.user');
    }
}
