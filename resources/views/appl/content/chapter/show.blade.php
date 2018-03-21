@extends('layouts.app')
@section('content')

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('docs.index')}}">Docs</a></li>
      <li class="breadcrumb-item "><a href="{{ route('docs.show',$doc->slug)}}">{{ $doc->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $chapter->title }} </li>
    </ol>
  </nav>
  @include('flash::message')

  <div class="row">
    <div class="col-md-12">
      <div class="card  mb-3">


        <div class="card-body ">

          <div class="bg-light p-2 mb-3">
            @if($chapter->prev)
            <a href="{{route('chapter.show',[$doc->slug,$chapter->prev]) }}">
            <i class="fa fa-angle-double-left"></i>
            </a>
            @endif
          <a class="navbar-brand ml-2">
            {{ $chapter->title }}
          </a>
          @if($chapter->next)
          <span class="float-right mt-2"> 
            <a href="{{route('chapter.show',[$doc->slug,$chapter->next]) }}">
              <i class="fa fa-angle-double-right"></i>
            </a> 
          </span>
          @endif
        </div>


          <div >{!!$chapter->content!!}</div>
          
          
          <span class="btn-group mt-4" role="group" aria-label="Basic example">
              
               @if($chapter->prev) 
              <a href="{{ route('chapter.show',[$doc->slug,$chapter->prev]) }}" class="btn btn-outline-secondary" title="Previous Chapter"
                ><i class="fa fa-angle-double-left"></i> prev</a>
                @endif

                @if($chapter->next) 
              <a href="{{ route('chapter.show',[$doc->slug,$chapter->next]) }}" class="btn btn-outline-secondary"  title="Next Chapter">next <i class="fa fa-angle-double-right"></i></a>
               @endif
              
            </span>
        </div>
      </div>

      @can('update',$chapter)
      <div class="card">
        <div class="card-body">
          <h3>Siblings </h3>
          <div id="sortlist" data-value="">
            @if($list)
            {!!$list!!}
            @else
            <span class="text-muted"><i class="fa fa-exclamation-circle"></i> No Siblings </span> 
            @endif
          </div>
          
          
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              @if($chapter->slug!='administrator')
              <a href="{{ route('chapter.edit',['doc'=>$doc->slug, 'chapter'=> $chapter->slug]) }}" class="btn btn-outline-info" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              @endif
              
               @if($list) 
              <a href="{{ route('chapter.show',['doc'=>$doc->slug, 'chapter'=> $chapter->slug]).'?order=up' }}" class="btn btn-outline-info" data-tooltip="tooltip" data-placement="top" title="Move Up"
                ><i class="fa fa-arrow-up"></i></a>
              <a href="{{ route('chapter.show',['doc'=>$doc->slug, 'chapter'=> $chapter->slug]).'?order=down' }}" class="btn btn-outline-info" data-tooltip="tooltip" data-placement="top" title="Move Down"><i class="fa fa-arrow-down"></i></a>
               @endif
              
              @if($chapter->slug!='administrator')
              <a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              @endif
            </span>
        </div>
      </div>
      @endcan

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
        
        This following action will delete the node as well as all the child nodes to it and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('chapter.destroy',['doc'=>$doc->slug, 'chapter'=> $chapter->slug])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection