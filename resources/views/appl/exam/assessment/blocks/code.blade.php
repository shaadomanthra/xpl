


@if(!$question->b)


<div class="p-3 mt-4" style="background: #eee">
  <h5 class="mb-2"> Enter code in any one of your preferred language</h5>
<div class="input-group ">
  <div class="input-group-prepend">
    <label class="input-group-text bg-light border  rounded mr-3" for="inputGroupSelect01">Language </label>
  </div>
  <select class="w-25 lang lang_{{($i+1)}}" id="inputGroupSelect01_{{($i+1)}}" data-qno="{{($i+1)}}">
    @foreach(['c','cpp','java','python','csharp','javascript','php','bash','ruby','swift'] as $lang)
    <option value="{{$lang}}" class="{{$preset = 'preset_'.$lang}} {{'preset_'.$lang}}_{{($i+1)}}" data-code="@if(isset($question->d->$preset)){{$question->d->$preset}} @elseif(isset($question->$preset)){{$question->$preset}} @endif" data-qno="{{($i+1)}}" @if(isset($question->lang))@if($question->lang==$lang) selected data-dlang="{{$dlang=$lang}}"@endif @endif>{{$lang}}</option>
    @endforeach
  </select>
  <a href="#" class="ml-3 btn  btn-outline-primary" data-toggle="modal" data-target="#io_code">I/O Instructions</a>

</div>

</div>
<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">@if($question->code){{$question->code}} @else @if($question->c){{$question->c}} @elseif(isset($question->d->preset_c)){{$question->d->preset_c}} @else //Note: The testcase inputs are taken from command line arguments
// click on the I/O instructions button to learn about the language specific input options
// The output string has to exactly match with the execpted output @endif @endif</textarea>

  @if($question->a)
  <button type="button" class="btn btn-lg btn-primary btn-sm mt-4 runcode runcode_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-testcase="1" data-qslug="{{$question->slug}}" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="@if(isset($dlang)){{$dlang}}@else clang @endif" data-sno="{{($i+1)}}" data-name="code_{{($i+1)}}" data-test="{{$exam->slug}}" data-c="1">Save & Compile</button>
  <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode runcode_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-testcase="3" data-qslug="{{$question->slug}}" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="@if(isset($dlang)){{$dlang}}@else clang @endif" data-sno="{{($i+1)}}" data-name="code_{{($i+1)}}" data-test="{{$exam->slug}}" data-c="1">Submit Code</button>
  <img class="loading loading_{{($i+1)}}" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
  @endif
@else

<div class="p-3 mt-4" style="background: #eee">Language : <span class="badge badge-warning {{$lang = $question->b}}">{{$question->b}}</span>
<select class="w-25 lang lang_{{($i+1)}} d-none" id="inputGroupSelect01_{{($i+1)}}" data-qno="{{($i+1)}}">

    <option value="{{$lang}}" class="{{$preset = 'preset_'.$lang}} {{'preset_'.$lang}}_{{($i+1)}}" data-code="@if(isset($question->d->$preset)){{$question->d->$preset}} @elseif(isset($question->$preset)){{$question->$preset}} @endif" data-qno="{{($i+1)}}" @if(isset($question->lang))@if($question->lang==$lang) selected data-dlang="{{$dlang=$lang}}"@endif @endif>{{$lang}}</option>
  </select>
 <a href="#" class="ml-3 btn  btn-outline-primary btn-sm" data-toggle="modal" data-target="#io_code">I/O Instructions</a></div>

<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}" data-dalang="{{$lang = 'preset_'.$question->b}}" rows="5">@if($question->code){{$question->code}} @else @if($question->c){{$question->c}} @elseif(isset($question->d->$lang)){{$question->d->$lang}}@elseif($question->b=='sql') @else //Note: The testcase inputs are taken from command line arguments
// click on the I/O instructions button to learn about the language specific input options
// The output string has to exactly match with the execpted output @endif @endif</textarea>

  @if($question->b=='sql')
    @if($question->a)
    
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode runcode_{{($i+1)}}" data-qslug="{{$question->slug}}" data-test="{{$exam->slug}}" data-testcase="3" data-qno="{{($i+1)}}"  data-sno="{{($i+1)}}"  data-url="https://sql.p24.in/" data-stop="{{ route('stopcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="" data-output="{{json_decode($question->a,true)['out_1']}}">Submit Code</button>
    <img class="loading loading_{{($i+1)}}" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
    @endif
  @else
    @if($question->a)
    <button type="button" class="btn btn-lg btn-primary btn-sm mt-4 runcode runcode_{{($i+1)}}" data-qslug="{{$question->slug}}" data-test="{{$exam->slug}}" data-testcase="1" data-qno="{{($i+1)}}" data-sno="{{($i+1)}}"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="">Save & Compile </button>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode runcode_{{($i+1)}}" data-qslug="{{$question->slug}}" data-test="{{$exam->slug}}" data-testcase="3" data-qno="{{($i+1)}}"  data-sno="{{($i+1)}}"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="">Submit Code</button>
    <img class="loading loading_{{($i+1)}}" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
    @endif

  @endif
  

@endif

@if($question->a)
<div class="alert alert-important alert-warning mt-3">
  <h5>Important Note</h5>
<ul>
  <li>Kindly submit the code for each question to validate the testcases.</li>
  <li>Mark is awarded only to the question which pass all the test cases.</li>
  <li>If the compiler is frozen, you can refresh the page. </li>
  <li> In java programming, the classname has to be named Main only.</li>
</ul>
</div>

<div class="row">
  <div class="col-12 col-md-6">
    <h5 class="mt-3">Your Code Output</h5>
<pre class="rounded"><code class="rounded p-2 output_{{($i+1)}} ">@if($question->response){{$question->response}} @else-@endif</code></pre>
    
  </div>
  <div class="col-12 col-md-6">
    <h5 class="mt-3">Expected Output (Testcase #1)</h5>
    @if($question->b=='sql')
      <pre class=" rounded">@if(isset($question->d->output)){!!$question->d->output!!} @else-@endif</pre>
    @else
      <pre class=" rounded"><code class="rounded p-2 ex_output_{{($i+1)}} ">@if(isset($question->d->output)){{$question->d->output}} @else-@endif</code></pre>
    @endif
    
  </div>
</div>

<div class="output_testcase_{{($i+1)}}">
      <div class="output_testcase_{{($i+1)}}_t1 " data-nh="{{$out='out_1'}}" >
        @if(isset($question->$out)) @if($question->$out)
        <p class="mb-2"><span class=" {{$t = 1}} {{$time = json_decode($question->$out,true)['response']['time']}} {{$pass=intval(json_decode($question->$out,true)['pass'])}}"></span>
        <b>Testcase {{$t}}:</b> @if($pass)<i class="fa fa-check-circle text-success"></i> Pass @else <i class="fa fa-times-circle text-danger"></i> Fail @endif {{ round($time,2) }} ms </p>
        @endif @endif
      </div>
      <div class="output_testcase_{{($i+1)}}_t2 " data-nh="{{$out='out_2'}}" >
        @if(isset($question->$out))@if($question->$out)
        <p class="mb-2"><span class=" {{$t = 2}} {{$time = json_decode($question->$out,true)['response']['time']}} {{$pass=intval(json_decode($question->$out,true)['pass'])}}"></span>
        <b>Testcase {{$t}}:</b> @if($pass)<i class="fa fa-check-circle text-success"></i> Pass @else <i class="fa fa-times-circle text-danger"></i> Fail @endif {{round($time,2)}} ms</p>
        @endif @endif
      </div>
      <div class="output_testcase_{{($i+1)}}_t3 " data-nh="{{$out='out_3'}}" >
        @if(isset($question->$out))@if($question->$out)
        <p class="mb-2"><span class=" {{$t = 3}} {{$time = json_decode($question->$out,true)['response']['time']}} {{$pass=intval(json_decode($question->$out,true)['pass'])}}"></span>
        <b>Testcase {{$t}}:</b> @if($pass)<i class="fa fa-check-circle text-success"></i> Pass @else <i class="fa fa-times-circle text-danger"></i> Fail @endif {{round($time,2)}} ms</p>
        @endif @endif
      </div>
      <div class="output_testcase_{{($i+1)}}_t4 " data-nh="{{$out='out_4'}}" >
        @if(isset($question->$out))@if($question->$out)
        <p class="mb-2"><span class=" {{$t = 4}} {{$time = json_decode($question->$out,true)['response']['time']}} {{$pass=intval(json_decode($question->$out,true)['pass'])}}"></span>
        <b>Testcase {{$t}}:</b> @if($pass)<i class="fa fa-check-circle text-success"></i> Pass @else <i class="fa fa-times-circle text-danger"></i> Fail @endif {{round($time,2)}} ms</p>
        @endif @endif
      </div>
      <div class="output_testcase_{{($i+1)}}_t5 " data-nh="{{$out='out_5'}}" >
        @if(isset($question->$out))@if($question->$out)
        <span class=" {{$t = 5}} {{$time = json_decode($question->$out,true)['response']['time']}} {{$pass=intval(json_decode($question->$out,true)['pass'])}}"></span>
        <b>Testcase {{$t}}:</b> @if($pass)<i class="fa fa-check-circle text-success"></i> Pass @else <i class="fa fa-times-circle text-danger"></i> Fail @endif {{round($time,2)}} ms
        @endif @endif
      </div>
</div>
<input class="form-control w-50 input input_{{($i+1)}}" type="hidden"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="@if($question->response){{$question->response}}@endif" >
<input class="form-control w-50 out out_{{($i+1)}}" type="hidden"  name="out_{{($i+1)}}" data-sno="{{($i+1)}}" value="@if(isset($question->out))@if($question->out){{$question->out}} @endif @endif" >
@for($k=1;$k<6;$k++)
<input class="form-control w-50 out out_{{($i+1)}}_{{$k}} " type="hidden"  data-nh="{{$out='out_'.$k}}" name="out_{{($i+1)}}_{{$k}}" data-sno="{{($i+1)}}" value="@if(isset($question->$out))@if($question->$out){{$question->$out}} @endif @endif" >
@endfor
<input class="form-control w-50 codefragment_{{($i+1)}}" type="hidden"  name="codefragment_{{($i+1)}}" data-sno="{{($i+1)}}" value="@if($question->code){{$question->code}}@endif" >
@else

<div class="alert alert-important alert-warning mt-3">
  <h5>Important Note</h5>
<ul>
  <li>You are required to write  the optimal solution for the above problem statement</li>
  <li>The code will be evaluated by the technical team for code quality and accuracy</li>
</ul>
</div>

@endif