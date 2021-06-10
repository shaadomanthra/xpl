
<style>
.disable-select {
    user-select: none; /* supported by Chrome and Opera */
   -webkit-user-select: none; /* Safari */
   -khtml-user-select: none; /* Konqueror HTML */
   -moz-user-select: none; /* Firefox */
   -ms-user-select: none; /* Internet Explorer/Edge */
}



</style>

@foreach($questions as $i=> $question)
<div class="question_block qblock_{{$i+1}}  " @if(!$data['qid'])@if($i!=0) style="display:none;" @endif @else @if($question->id!=$data['qid']) style="display:none;" @endif @endif>
   
  @if($question->passage)
  <div class="card my-3" style="background: #ddffef;border: 1px solid #caefdd;border-radius: 5px;">
    <div class="card-body">
      <b>Passage</b> <span class="btn view badge badge-warning cursor" data-item="passage" data-pno="{{$i}}">view</span><br>
      <div class="passage pt-2 passage_{{$i}}" style="display: none;">
        {!! $question->passage !!}
      </div>
    </div>
  </div>
  @endif
  <div class="card  mb-3">
    <div class="card-body mt-3 textcontainer">


      <div class="textcontainerbackground">
            {{'UX010'.$user->id}}
        </div>
        <div class="textcontainerbackground2 d-none d-md-block">
            {{'UX010'.$user->id}}
        </div>
        <div class="textcontainerbackground3">
            {{'UX010'.$user->id}}
        </div>
        <div class="textcontainerbackground4">
            {{'UX010'.$user->id}}
        </div>
        @if(auth::user()->college_id)
        <div class="textcontainerbackground5 d-none d-md-block">
            <b>{{'UX010'.$user->id}}</b> - {{$user->name}} @if($user->roll_number)- {{$user->roll_number}} @endif  @if(isset($data['colleges'][auth::user()->college_id])) - {{ $data['colleges'][$user->college_id]->name}}   @endif
        </div>
        @endif
        <div class="textcontainerbackground5 d-block d-md-none">
            <b>{{'UX010'.$user->id}}</b> - {{$user->name}} 
        </div>
      @if($question->type!='typing')
      <div class="row no-gutters">
        <div class="col-2 col-md-2">
          <div class="pr-3 pb-2 " >
            <div class="text-center p-1 rounded  w100 qno  qyellow "  style="" data-qqno="{{$question->id}}">
              {{ $i+1 }}
            </div>
          </div>
        </div>
        <div class="col-10 col-md-10">
          
          <div class="pt-1  disable-select">{!! $question->question!!}</div>
        </div>
      </div>
      @else
      <div class="row no-gutters">
        <div class="col-12 ">
          <div class="pt-1  disable-select typed_question_html">{!! $question->question!!}</div>
          <div class="d-none typed_question">{!! $question->question!!}</div>
        </div>
      </div>
      @endif
  @if($question->type=='maq')
    <div class="alert alert-info alert-important">Select one or more choices from the given options.</div>
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-2">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded bg-light w100 border" >
            <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_A" data-opt="A" type="checkbox" name="{{($i+1)}}[]" data-sno="{{($i+1)}}" value="A" @if(strpos($question->response,'A')!==false) checked @endif> A </div>
          </div>
        </div>
        <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->option_a!!}</div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-2">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded bg-light w100 border" >
              <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_B" data-opt="B" type="checkbox"  name="{{($i+1)}}[]" data-sno="{{($i+1)}}" value="B" @if(strpos($question->response,'B')!==false) checked @endif>  B</div>
            </div>
          </div>
          <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->option_b!!}</div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-2">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded bg-light w100 border" >

                <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_C" data-opt="C" type="checkbox"  name="{{($i+1)}}[]" data-sno="{{($i+1)}}"  value="C" @if(strpos($question->response,'C')!==false) checked @endif> C</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->option_c!!}</div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded bg-light w100 border" >
                  <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_D" data-opt="D" type="checkbox"  name="{{($i+1)}}[]" data-sno="{{($i+1)}}"  value="D" @if(strpos($question->response,'D')!==false) checked @endif> D</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->option_d!!}</div></div>
          </div>
          @endif

          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded bg-light w100 border" > 

                  <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_E" data-opt="E" type="checkbox"  name="{{($i+1)}}[]" data-sno="{{($i+1)}}" value="E" @if(strpos($question->response,'E')!==false) checked @endif>
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->option_e!!}</div></div>
          </div>
          @endif

  @elseif($question->type=='typing')
  <div class="bg-light border p-3 rounded mt-3">
          <h5>Type the above paragraph</h5><textarea class="form-control w-100 input input_{{($i+1)}} input_fillup_{{($i+1)}} typed_answer" type="text"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="" rows="6">@if($question->response){{$question->response}} @endif</textarea>

          <input id="{{($i+1)}}_time_start" class="form-input {{($i+1)}}_time_start" type="hidden" name="{{($i+1)}}_time_start"  value="0">
          <input id="{{($i+1)}}_time_end" class="form-input {{($i+1)}}_time_end" type="hidden" name="{{($i+1)}}_time_end"  value="0">
          <input id="{{($i+1)}}_wpm" class="form-input {{($i+1)}}_wpm" type="hidden" name="{{($i+1)}}_wpm"  value="0">
          <input id="{{($i+1)}}_accuracy" class="form-input {{($i+1)}}_accuracy" type="hidden" name="{{($i+1)}}_accuracy"  value="0">

        </div>

  @elseif($question->type=='mcq')
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-2">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded bg-light w100 border" >
            <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_A" data-opt="A" type="radio" name="{{($i+1)}}" data-sno="{{($i+1)}}" value="A" @if(strpos($question->response,'A')!==false) checked @endif> A </div>
          </div>
        </div>
        <div class="col-9 col-md-10"><div class="pt-1 a">{!! $question->option_a!!}</div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-2">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded bg-light w100 border" >
              <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_B" data-opt="B" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="B" @if(strpos($question->response,'B')!==false) checked @endif>  B</div>
            </div>
          </div>
          <div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->option_b!!}</div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-2">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded bg-light w100 border" >

                <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_C" data-opt="C" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}"  value="C" @if(strpos($question->response,'C')!==false) checked @endif> C</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 c">{!! $question->option_c!!}</div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded bg-light w100 border" >
                  <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_D" data-opt="D" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}"  value="D" @if(strpos($question->response,'D')!==false) checked @endif> D</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 d">{!! $question->option_d!!}</div></div>
          </div>
          @endif

          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded bg-light w100 border" > 

                  <input class="form-check-input input input_{{($i+1)}} input_{{($i+1)}}_E" data-opt="E" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="E" @if(strpos($question->response,'E')!==false) checked @endif>
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 e">{!! $question->option_e!!}</div></div>
          </div>
          @endif

        @endif
          @if($question->type=='code')
            @include('appl.exam.assessment.blocks.code')
          @endif

          @if($question->type=='csq')
            @include('appl.exam.assessment.blocks.csq')
          @endif

          @if($question->type=='fillup')
          <div class="bg-light border p-3 rounded mt-3">
          <h5>Enter your answer</h5>
          <input class="form-control w-100 input input_{{($i+1)}} input_fillup_{{($i+1)}}" type="text"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="@if($question->response){{$question->response}} @endif" >
        </div>
          @endif

          @if($question->type=='sq')
          <div class="bg-light border p-3 rounded mt-3">
          <h5>Enter your answer</h5><textarea class="form-control w-100 input input_{{($i+1)}} input_fillup_{{($i+1)}}" type="text"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="" rows="10">@if($question->response){{$question->response}} @endif</textarea>
        </div>
          @endif

          @if($question->type=='urq')
          <div class="bg-light border p-3 rounded mt-3 upload_image_box" style="@if(isset($settings['upload_time'])) @if($settings['upload_time']) display:none @endif @endif">
          <h5>Upload your response (image format)</h5>

          <input type="file" class="form-control w-100 input input_{{($i+1)}} input_urq_{{($i+1)}}" type="text"  name="{{($i+1)}}" data-name="{{($i+1)}}" data-type="urq" data-sno="{{($i+1)}}" value="" 
          >
          <button type="button" class="mt-3 btn btn-primary btn-urq btn_urq_{{($i+1)}}" data-name="{{($i+1)}}" data-iname="{{($exam->slug.'_'.$user->id.'_'.$question->id)}}" data-user_id="{{ $user->id }}" data-qid="{{ $question->id }}" data-token="{{ csrf_token() }}"  data-c="@if(isset($imgs[$question->id]['c'])) {{($imgs[$question->id]['c']+1)}}@else 1 @endif" data-url="{{ route('assessment.upload',$exam->slug)}}">Upload</button>

          <div class="spinner-border spinner-border-sm float-right mt-3 spinner_{{$i+1}}" role="status" style="display:none">
  <span class="sr-only">Loading...</span>
</div>
        </div>
        <div class="img_container_{{$i+1}} pt-3" >
          <div class="img_status img_status_{{$i+1}} py-2"></div>
          <div class="img_c img_c_{{$i+1}} {{$m=0}}">

            @if($question->images)
              @foreach(array_reverse($question->images) as $img)
                <img id="" class="img_{{$i+1}} w-100 {{$m=1}} py-2" src="{{$img}}" />
              @endforeach
            @endif
          </div>

          <!--<img id="img_{{$i+1}}" class="img_{{$i+1}} w-100" src="" />-->
          @if($m==1)
          <button type="button" class="mt-3 btn btn-danger btn-delete btn_delete_urq_{{($i+1)}}" data-name="{{($i+1)}}" data-user_id="{{ $user->id }}" data-qid="{{ $question->id }}" data-token="{{ csrf_token() }}" data-url="{{ route('assessment.delete.image',$exam->slug)}}">Delete</button>
          @else
          <button type="button" class="mt-3 btn btn-danger btn-delete btn_delete_urq_{{($i+1)}}" data-name="{{($i+1)}}" data-user_id="{{ $user->id }}" data-qid="{{ $question->id }}" data-token="{{ csrf_token() }}" data-url="{{ route('assessment.delete.image',$exam->slug)}}" style="display:none">Delete</button>
          @endif
          
        </div>
          @endif


          <input id="{{($i+1)}}_time" class="form-input {{($i+1)}}_time" type="hidden" name="{{($i+1)}}_time"  value="@if($question->time) {{$question->time}} @else 0 @endif">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_question_id"  value="{{$question->id}}">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_dynamic"  value="{{$dynamic[$i]}}">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_section_id"  value="{{$sections[$i]->id}}">
        </div>
      </div>
   </div>
@endforeach

   <div class="card mb-0">
     <div class="card-body p-2 p-md-3">
      <button type="button" class="btn  btn-outline-primary  cursor left-qno" @if($data['sno']==1) data-sno="" @else data-sno="{{($data['sno']-1)}}" @endif data-testname="{{$exam->slug}}" >
        <i class="fa fa-angle-double-left"></i> <span class="d-none d-md-inline">Previous</span>
      </button>

      <button type="button" class="btn  btn-primary mark-qno cursor" data-sno="{{$data['sno']}}">Mark 
      </button>

      <button type="button" class="btn  btn-secondary clear-qno cursor" data-sno="{{$data['sno']}}">Clear <span class="d-none d-md-inline">Response</span>
      </button>
     
      <a href="#" data-toggle="modal" data-target="#exampleModal">
        <button type="button" id="s_button" class="btn  btn-success qno-sub cursor float-right" data-sno="{{$question->id}}" data-tooltip="tooltip"  data-placement="top" >
          End <span class="d-none d-md-inline">Test</span>
        </button>
      </a>
      @if(count($questions)!=1)
        <button type="button" class="btn  btn-outline-primary  cursor right-qno" data-sno="{{($data['sno']+1)}}" data-testname="{{$exam->slug}}" >
         Next <i class="fa fa-angle-double-right"></i>
       </button>
      @endif
     </div>
   </div>

   <div class="p-5  m-3 m-md-1"></div>

   <div class=" border  p-3 bg-light" style="margin-top: -5px; position: fixed; bottom:0;left:0;right:0;z-index:10">
    <h5 class="mb-0">Support&nbsp;&nbsp; <span class=" text-info"><b><i class="fa fa-phone-square"></i> @if(env('CONTACT_PHONE')) {{env('CONTACT_PHONE')}} @else 1800 890 1324 @endif</b></span> | <span class=" text-info"><b><i class="fa fa-inbox"></i> @if(env('CONTACT_MAIL')) {{env('CONTACT_MAIL')}} @else info@xplore.co.in @endif</b></span> 

      <span class=" text-secondary float-md-right timestamp"></span>

    </h5>

  </div>