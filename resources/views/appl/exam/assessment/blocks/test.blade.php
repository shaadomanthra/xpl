@extends('layouts.app')
@section('content')

<form method="post" action="{{ route('assessment.submission',$exam->slug)}}" >
  <div class="row">
    <div class="col-md-9">
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
        Kindly confirm your submission of the test.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn  btn-success " >
            Submit Test
        </button>
      </div>
    </div>
  </div>
</div>

</form>

@endsection