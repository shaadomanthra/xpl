

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

@else

<div class="p-3 mt-4" style="background: #eee">Language : <span class="badge badge-warning">{{$question->b}}</span></div>

<textarea id="code_{{($i+1)}}" class="form-control code code_{{($i+1)}}" name="dynamic_{{($i+1)}}"  rows="5">{{$question->c}}</textarea>


@endif

<input class="form-control w-50 input input_{{($i+1)}}" type="hidden"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="" >