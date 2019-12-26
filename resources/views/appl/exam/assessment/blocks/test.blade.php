@extends('layouts.none')
@section('title', $exam->name.' | PacketPrep')
@section('content')

<div class="p-2 p-md-3 ">
<form method="post" class="assessment" action="{{ route('assessment.submission',$exam->slug)}}" >

  <div class="row">
    <div class="col-md-9">

      <div class=" rounded p-3 mb-3 h4 d-none d-md-block" style="border:#dad6b5;background:#f8efba;"><i class="fa fa-newspaper-o"></i> {{$exam->name}}</div>
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
        The following test will be submitted. Kindly confirm your submission.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="test_id" value="{{ $exam->id }}">
        <input type="hidden" name="code" value="{{ request()->get('code') }}">
        <button type="submit" class="btn  btn-warning " data-submit="1">
           End Test
        </button>
      </div>
    </div>
  </div>
</div>

</form>
</div>

@endsection