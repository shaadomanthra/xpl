

@if(!$question->b)



<div class="p-3 mt-4" style="background: #eee">
  <h5 class="mb-2"> Enter code in any one of your preferred language</h5>
<div class="input-group ">
  <div class="input-group-prepend">
    <label class="input-group-text bg-light border  rounded mr-3" for="inputGroupSelect01">Language</label>
  </div>
  <select class="w-25 lang" id="inputGroupSelect01_{{($i+1)}}" data-qno="{{($i+1)}}">
    @foreach(['c','cpp','java','python','perl'] as $lang)
    <option value="{{$lang}}">{{$lang}}</option>
    @endforeach
  </select>

</div>

</div>
<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">@if($question->c){{$question->c}}@endif</textarea>
<button type="button" class="btn btn-lg btn-primary mt-4 runcode runcode_{{($i+1)}}" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="clang" data-name="code_{{($i+1)}}" data-c="1">Run Code</button>

<img class="loading" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
@else

<div class="p-3 mt-4" style="background: #eee">Language : <span class="badge badge-warning">{{$question->b}}</span></div>

<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">{{$question->c}}</textarea>
<button type="button" class="btn btn-lg btn-primary mt-4 runcode" data-qno="{{($i+1)}}" data-url="{{ route('runcode') }}" data-lang="@if($question->b=='c' || $question->b=='cpp')clang @else {{$question->b}}@endif" data-name="code_{{($i+1)}}" data-c="@if($question->b=='c') 1 @else 0 @endif" data-input="@if($question->a) {{$question->a}} @endif">Run Code</button>
<img class="loading" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>

@endif

<h5 class="mt-3">Output</h5>
<pre class="border rounded bg-light"><code class="output_{{($i+1)}} ">-</code></pre>
<input class="form-control w-50 input input_{{($i+1)}}" type="hidden"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="" >