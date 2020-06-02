<?php
namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Exam;

class EditorController extends Controller
{
    public function tcscode(Request $request)
    {
    	$cpp =$data =null;
        return view('appl.product.editor.tcscode')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase(Request $request)
    {
    	$code = $request->get('code');
      $name = $request->get('name');
    	if($request->get('testcase')==1){
    		$input = 14;
    		$output = "17";
    	}
    	elseif($request->get('testcase')==2){
    		$input = 5;
    		$output = "2";
    	}else{
    		$input = 10;
    		$output = "11";

    	}
    	$data = $this->run_internal_p24($code,$input,'clang',1,$name);

    	$json = json_decode($data);
      $json->name = $name;
      if(isset($json->stderr)){
    		$json->input = $input;

        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;
        print json_encode($json);
      }
    	else if(isset($json->stdout)){
        $json->input = $input;
    		if($json->stdout == $output)
    			$json->success = 1;
    		else
    			$json->success = 0;

    		print json_encode($json);

    	}else{
        $json->success= 2;
        $json->input = $input;
        print json_encode($json);
      }

    }

    public function runcode(Request $request)
    {
      $code = $request->get('code');
      $name = $request->get('name');
      
      $input = $request->get('input');
      $lang = $request->get('lang');
      $c = $request->get('c');
      $data = $this->run_internal_p24($code,$input,$lang,$c,$name);
      //$data = $this->run_internal($code,$input);
      $json = json_encode(json_decode($data));
      print $json;

    }


    public function autoruncode(Request $request)
    {

      
      return (new Exam)->runCode($request);
      //print $json;

    }


    public function tcscode_one(Request $request)
    {
      $cpp =$data =null;
        return view('appl.product.editor.tcscode_one')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase_one(Request $request)
    {
      $code = $request->get('code');
      if($request->get('testcase')==1){
        $input = 4;
        $output = 1;
      }
      elseif($request->get('testcase')==2){
        $input = 5;
        $output = 0;
      }else{
        $input = 10;
        $output = 1;

      }
      $data = $this->run_internal_p24($code,$input);
      $json = json_decode($data);
      if($json->stderr)
        print $data;
      else{
        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;

        print json_encode($json);

      }

    }

    public function tcscode_two(Request $request)
    {
      $cpp =$data =null;
        return view('appl.product.editor.tcscode_two')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase_two(Request $request)
    {
      $code = $request->get('code');
      if($request->get('testcase')==1){
        $input = 14;
        $output = 17;
      }
      elseif($request->get('testcase')==2){
        $input = 5;
        $output = 2;
      }else{
        $input = 10;
        $output = 11;

      }
      $data = $this->run_internal($code,$input);
      $json = json_decode($data);
      if($json->stderr)
        print $data;
      else{
        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;

        print json_encode($json);

      }

    }

    public function run_internal($code,$input){


      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      $code = json_encode($code);

      $headers = [
          'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
          'Content-type: application/json'
      ];

      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://run.glot.io/languages/c/latest',
          CURLOPT_POST => 1,
      ]);

     // $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';

      $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);

      return $data;

    }

    public function run_internal_p24($code,$input,$lang,$c,$name){


      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://code.p24.in',
          CURLOPT_POST => 1,
          CURLOPT_TIMEOUT => 30,
      ]);

      $form = array('hash'=>'krishnateja','c'=>$c,'docker'=>'1','lang'=>$lang,'form'=>'1','code'=>$code,'input'=>$input,'name'=>$name);

      
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);


      return $data;

    }

    public function stop(){
      $name = request()->get('name');

      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://krishnateja.in/stopdocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>$name);
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }

    public function remove(){
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://krishnateja.in/removedocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>'');
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }

    public function run(Request $request){

      $code = $request->get('code');
      $input = $request->get('input');

      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      $code = json_encode($code);

      $headers = [
          'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
          'Content-type: application/json'
      ];

      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://run.glot.io/languages/c/latest',
          CURLOPT_POST => 1,
      ]);

      $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      // Send the request & save response to $resp
      print(curl_exec($curl));
      
      // Close request to clear up some resources
      curl_close($curl);

    }
  
}
