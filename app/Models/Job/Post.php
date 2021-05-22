<?php

namespace PacketPrep\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'details',
        'education',
        'salary',
        'salary_num',
        'location',
        'academic',
        'last_date',
        'yop',
        'user_id',
        'viewer_id',
        'exam_ids',
        'status',
        'extra',
        'conditions'
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function viewer(){
      return $this->belongsTo('PacketPrep\User','viewer_id');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User')->withPivot(['created_at','score','shortlisted','data']);
    }

    public function updateApplicant($post_id,$user_id,$score,$shortlisted,$return=false){
        $entry = DB::table('post_user')->where('post_id', $post_id)->where('user_id',$user_id)
                ->update(['score' => $score,'shortlisted'=>$shortlisted]);
        if($return)
            return 1;
        echo $entry;
        exit();
    }

      public function uploadFile($file){

            $client_id = 'xplore';

           
            $fname = str_replace(' ','',$file->getClientOriginalName());
            $extension = strtolower($file->getClientOriginalExtension());

            if(in_array($extension, ['jpg','jpeg','png','gif','svg','webp']))
                $type = 'files';
            else if(in_array($extension, ['pdf','','doc','txt','docx','xls','xlsx']))
                $type = 'files';
            else
                $type = $extension;
                
            $filename = 'file_'.$fname;

            $path = Storage::disk('s3')->putFileAs('files/'.$client_id, $file,$filename,'public');

            return [$path,$filename];
        
    }

    public function processForm($data){
        $d = [];
        $form = explode(',',$data);
        foreach($form as $k=>$f){
            $item = ["name"=>$f,"type"=>"input","values"=>""];
            if(preg_match_all('/<<+(.*?)>>/', $f, $regs))
            {
                foreach ($regs[1] as $reg){
                    $variable = trim($reg);
                    $item['name'] = str_replace($regs[0], '', $f);


                    if(is_numeric($variable)){
                        $item['type'] = 'textarea';
                        $item['values'] = $variable;

                    }else if($variable=='file'){
                        $item['type'] = 'file';
                        $item['values'] = $variable;
                    }else{
                        $options = explode('/',$variable);
                        $item['values'] = $options;
                        $item['type'] = 'checkbox';
                    }
                    
                }
            }

            if(preg_match_all('/{{+(.*?)}}/', $f, $regs))
            {

                foreach ($regs[1] as $reg){
                    $variable = trim($reg);
                    $item['name'] = str_replace($regs[0], '', $f);
                    $options = explode('/',$variable);
                    $item['values'] = $options;
                    $item['type'] = 'radio';
                    
                }
            }

            if($item['name'])
            $d[$k] = $item;

        }

        return $d;
    }

    public function questions($data){
        $d = [];
        $form = explode(',',$data);
        foreach($form as $k=>$f){
            $item = ["name"=>$f,"type"=>"input","values"=>""];
            if(preg_match_all('/<<+(.*?)>>/', $f, $regs))
            {
                $item['name'] = str_replace($regs[0], '', $f);   
            }

            if(preg_match_all('/{{+(.*?)}}/', $f, $regs))
            {
                $item['name'] = str_replace($regs[0], '', $f);
            }

            if($item['name'])
                $d[$k] = $item['name'];

        }

        return $d;
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

}
