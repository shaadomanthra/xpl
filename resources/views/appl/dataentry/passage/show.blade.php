@extends('layouts.app')
@section('content')

  @include('appl.dataentry.snippets.breadcrumbs')
  @include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card  mb-3">
        <div class="card-body ">
          
          <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-file-o"></i> {{ $passage->name }}
            </a>
        </nav>

        <div>
          {!! $passage->passage !!}
        </div>

        <div class="bg-light border p-3 rounded">
          <div class="pb-2">Questions ({{ count($passage->questions) }})</div>

          @foreach($passage->questions as $k=>$question)
          @if($k!=0)
          {{ ','}}
          <a href=" {{ route('question.show',[$project->slug,$question->id]) }} ">
                  <span>
                    {!! $question->id !!}
                  </span>
                  </a>
          
          @else
          <a href=" {{ route('question.show',[$project->slug,$question->id]) }} ">
                  <span>
                    {!! $question->id !!}
                  </span>
                  </a>
           @endif       
          @endforeach
        </div>
        
        @can('update',$passage)
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              <a href="{{ route('passage.edit',['project'=>$project->slug,'passage'=>$passage->id]) }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              
              <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
        @endcan
        </div>
      </div>


    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.menu')
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
        
        <form method="post" action="{{route('passage.destroy',['project'=>$project->slug,'tag'=>$passage->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection