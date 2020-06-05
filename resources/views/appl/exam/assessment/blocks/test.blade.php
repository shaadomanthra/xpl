@extends('layouts.none')
@section('title', $exam->name.' ')
@section('content')

<div class="p-2 p-md-3 ">
<form method="post" class="assessment" id="assessment" action="{{ route('assessment.submission',$exam->slug)}}" >

  <div class="row">
    <div class="col-md-9">

      <div class=" rounded p-3 mb-3 h4 d-none d-md-block" style="border:#dad6b5;background:#f8efba;">
        @if(isset($exam->image))
        @if(Storage::disk('public')->exists($exam->image))
        <picture>
        <img 
      src="{{ asset('/storage/'.$exam->image) }} " class=" d-print-none mr-2" alt="{{  $exam->name }}" style='max-width:40px;'>
      </picture>
        @endif
    @else
        <i class="fa fa-newspaper-o"></i> 
        @endif
        {{$exam->name}}</div>
          <div class=" mb-3 d-block d-md-none ">
  <div class="blogd text-white pl-3 pr-3 pb-2 pt-3 pb-2 rounded" style="background:#ca2428">
    <div class="mb-2 text-center"> Timer : <span class="text-bold " id="timer2"></span></div>
    

    <div class="p-2 mb-2 rounded" style="border:2px solid #bb061c">
    <div class="row ">
      <div class="col-3">
        <div class="left-qno cursor w100 p-1 text-center pl-2 " data-sno=""  style="display:none"><i class="fa fa-angle-double-left"data-testname="{{$exam->slug}}" ></i></div>
      </div>

      <div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
      <div class="col-3"> 
        <div class="right-qno cursor w100 p-1 text-center mr-3 " data-sno="2" data-testname="{{$exam->slug}}" ><i class="fa fa-angle-double-right" ></i></div>
      </div>


    </div>
    </div>
    
  </div>
</div>

     @include('appl.exam.assessment.blocks.questions')
    </div>
     <div class="col-md-3 pl-md-0">
      @include('appl.exam.assessment.blocks.qset')
    </div>
  </div> 

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Confirm Submission</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

        <div class="alert alert-warning alert-important mb-3">
          If you click end test, you will not be able to edit your responses for any of the given questions.
        </div>
        Your responses will be submitted and the test will end.  Kindly confirm your submission.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I will solve more questions</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="test_id" value="{{ $exam->id }}">
        <input type="hidden" name="code" value="{{ request()->get('code') }}">
        <input type="hidden" name="window_change" value="0" id="window_change">
        <button type="submit" class="btn  btn-warning " data-submit="1">
           I confirm, End Test
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Window Swap Detected</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body swap-message">
        We have noticed a window swap. Kindly note that 3 swaps will lead to cancellation of the test.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</form>
</div>

@endsection