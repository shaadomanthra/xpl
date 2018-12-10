@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')

  <div class="row">

    <div class="col-md-9">

      @if($passage)
      <div class="card mb-3">
        <div class="card-body">
          <b class="pb-2">Passage</b>@can('update',$passage)
              <a href="{{ route('passage.edit',['project'=>$project->slug,'passage'=>$passage->id]) }}" class="btn  float-right" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('passage.show',['project'=>$project->slug,'passage'=>$passage->id]) }}" class="btn  float-right" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-eye"></i></a>
          @endcan <span class="btn view badge badge-warning" data-item="passage">view</span>
          <div style="display: none;" class="passage pt-2" >
          {!! $passage->passage !!}
          </div>
          
        </div>
      </div>
      @endif
      <div class="card  mb-3">
        <div class="card-body ">
          
        <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2 " >
        			<div class="text-center p-1 rounded  w100 "  style="background:#F8EFBA;border:1px solid #e4d998;">
        				{{ $details['qno'] }}
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div></div>
        </div>

        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 rounded bg-light w100 border" >A</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 a">{!! $question->a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 rounded bg-light w100 border" >B</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 b">{!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 rounded bg-light w100 border" >C</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 c">{!! $question->c!!}</div></div>
        </div>
        @endif
        
        @if($question->d)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 rounded bg-light w100 border" >D</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 d">{!! $question->d!!}</div></div>
        </div>
        @endif

        @if($question->e)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 rounded bg-light w100 border" >E</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->e!!}</div></div>
        </div>
        @endif
         
        </div>
      </div>

      @if($question->answer)
      <div class="card mb-3 ">
      	<div class="card-body">
      		<h3>Answer</h3>
      		<div class="answer">{!! $question->answer !!}</div>
      	</div>
      </div>
      @endif

      @if($question->explanation)
      <div class="card mb-3 mb-md-0">
      	<div class="card-body">
      		<h3>Explanation</h3>
      		<div class="explanation">{!! $question->explanation !!}</div>
      	</div>
      </div>
      @endif

      @include('appl.dataentry.snippets.exam')

    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.qset')
      @include('appl.dataentry.snippets.qdetails')
    </div>

  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        
        This following action will delete the node and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('question.destroy',['project'=>$project->slug,'question'=>$question->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-warning">Warning !</span></h3>
        This following action will publish the question to LIVE status which disables the editing option.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <a href="{{ $details['curr'].'?publish=true'}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Publish</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection