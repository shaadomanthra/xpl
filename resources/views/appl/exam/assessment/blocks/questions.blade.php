
@foreach($questions as $i=> $question)
<div class="question_block qblock_{{$i+1}}" @if($i!=0) style="display:none;" @endif>
  @if($passages[$i])
  <div class="card mb-3" style="background: #ddffef;border: 1px solid #caefdd;border-radius: 5px;">
    <div class="card-body">
      <b>Passage</b> <span class="btn view badge badge-warning cursor" data-item="passage" data-pno="{{$i}}">view</span><br>
      <div class="passage pt-2 passage_{{$i}}" style="display: none;">
        {!! $passages[$i]->passage !!}
      </div>
    </div>
  </div>
  @endif
  <div class="card  mb-3">
    <div class="card-body ">
      <div class="row no-gutters">
        <div class="col-2 col-md-2">
          <div class="pr-3 pb-2 " >
            <div class="text-center p-1 rounded  w100 qno  qyellow "  style="" data-qqno="{{$question->id}}">
              {{ $i+1 }}
            </div>
          </div>
        </div>
        <div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div>
        </div>
      </div>

    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-2">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded bg-light w100 border" >
            <input class="form-check-input input input_{{($i+1)}}" type="radio" name="{{($i+1)}}" data-sno="{{($i+1)}}" value="A"> A </div>
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
              <input class="form-check-input input input_{{($i+1)}}" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="B">  B</div>
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

                <input class="form-check-input input input_{{($i+1)}}" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}"  value="C" > C</div>
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
                  <input class="form-check-input input input_{{($i+1)}}" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}"  value="D"> D</div>
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

                  <input class="form-check-input input input_{{($i+1)}}" type="radio"  name="{{($i+1)}}" data-sno="{{($i+1)}}" value="E" >
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 e">{!! $question->option_e!!}</div></div>
          </div>
          @endif

          <input id="{{($i+1)}}_time" class="form-input {{($i+1)}}_time" type="hidden" name="{{($i+1)}}_time"  value="0">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_question_id"  value="{{$question->id}}">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_dynamic"  value="{{$dynamic[$i]}}">
          <input  class="form-input " type="hidden" name="{{($i+1)}}_section_id"  value="{{$sections[$i]->id}}">
        </div>
      </div>
   </div>
@endforeach

   <div class="card mb-0">
     <div class="card-body">
      <button type="button" class="btn  btn-outline-primary  cursor left-qno" data-sno="" data-testname="{{$exam->slug}}">
        <i class="fa fa-angle-double-left"></i> Prev<span class="d-none d-md-inline">ious</span>
      </button>

      <button type="button" class="btn  btn-secondary clear-qno cursor" data-sno="1">
        Clear <span class="d-none d-md-inline">Response</span>
      </button>
      <a href="#" data-toggle="modal" data-target="#exampleModal">
        <button type="button" id="submit" class="btn  btn-success qno-submit cursor" data-sno="{{$question->id}}" data-tooltip="tooltip"  data-placement="top" title="Submit">
          Submit <span class="d-none d-md-inline">Test</span>
        </button></a>
        <button type="button" class="btn  btn-outline-primary  cursor right-qno" data-sno="2" data-testname="{{$exam->slug}}" >
         Next <i class="fa fa-angle-double-right"></i>
       </button>
     </div>
   </div>