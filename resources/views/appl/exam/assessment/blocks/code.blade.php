

@if(!$question->b)



<div class="p-3 mt-4" style="background: #eee">
  <h5 class="mb-2"> Enter code in any one of your preferred language</h5>
<div class="input-group ">
  <div class="input-group-prepend">
    <label class="input-group-text bg-light border  rounded mr-3" for="inputGroupSelect01">Language</label>
  </div>
  <select class="w-25 lang" id="inputGroupSelect01_{{($i+1)}}" data-qno="{{($i+1)}}">
    @foreach(['c','cpp','java','python','csharp','javascript','php','bash','ruby','swift'] as $lang)
    <option value="{{$lang}}">{{$lang}}</option>
    @endforeach
  </select>
  <a href="#" class="ml-3 btn  btn-outline-primary" data-toggle="modal" data-target="#io_code">I/O Instructions</a>

</div>

</div>
<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">@if($question->code){{$question->code}} @else @if($question->c){{$question->c}}@endif @endif</textarea>

  @if($question->a)
  <button type="button" class="btn btn-lg btn-primary btn-sm mt-4 runcode runcode_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-testcase="1" data-qslug="{{$question->slug}}" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="clang" data-name="code_{{($i+1)}}" data-test="{{$exam->slug}}" data-c="1">Save & Compile</button>
  <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode runcode_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-testcase="3" data-qslug="{{$question->slug}}" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="clang" data-name="code_{{($i+1)}}" data-test="{{$exam->slug}}" data-c="1">Submit Code</button>
  <img class="loading loading_{{($i+1)}}" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
  @endif
@else

<div class="p-3 mt-4" style="background: #eee">Language : <span class="badge badge-warning">{{$question->b}}</span> <a href="#" class="ml-3 btn  btn-outline-primary btn-sm" data-toggle="modal" data-target="#io_code">I/O Instructions</a></div>

<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">@if($question->code){{$question->code}} @else @if($question->c){{$question->c}}@endif @endif</textarea>

  @if($question->a)
  <button type="button" class="btn btn-lg btn-primary btn-sm mt-4 runcode runcode_{{($i+1)}}" data-qslug="{{$question->slug}}" data-test="{{$exam->slug}}" data-testcase="1" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="">Save & Compile </button>
  <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode runcode_{{($i+1)}}" data-qslug="{{$question->slug}}" data-test="{{$exam->slug}}" data-testcase="3" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-namec="{{\auth::user()->username}}_{{$exam->slug}}_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="">Submit Code</button>
  <img class="loading loading_{{($i+1)}}" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
  @endif

@endif

@if($question->a)
<div class="alert alert-important alert-warning mt-3">
  <h5>Important Note</h5>
<ul>
  <li>Kindly submit the code for each question to validate the testcases.</li>
  <li>Mark is awarded only to the question which pass all the test cases.</li>
  <li>If the compiler is frozen, you can refresh the page.</li>
  <li> In java programming, the classname has to be named Main only.</li>
</ul>
</div>

<h5 class="mt-3">Output</h5>
<pre class="border rounded bg-light"><code class="output_{{($i+1)}} ">@if($question->response){{$question->response}} @else-@endif</code></pre>
<div class="output_testcase_{{($i+1)}}"></div>
<input class="form-control w-50 input input_{{($i+1)}}" type="hidden"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="@if($question->response){{$question->response}}@endif" >
<input class="form-control w-50 out out_{{($i+1)}}" type="hidden"  name="out_{{($i+1)}}" data-sno="{{($i+1)}}" value="" >
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