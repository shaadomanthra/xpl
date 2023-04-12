@extends('layouts.app')
@section('content')

  @include('appl.dataentry.snippets.breadcrumbs')
  @include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card  mb-3">
        <div class="card-body ">
          
          <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> {{ $category->name }}

          <span class="s15"><i class="fa fa-hashtag "></i>{{ $category->slug }}</span>
            </a>
          <a href="{{ route('category.question',[$project->slug,$category->slug,''])}}">
            <span class="s15">Questions ({{ count($category->questions)}})</span>
          </a>

          <a href="{{ route('category.cache',[$project->slug,$category->slug,''])}}">
            <span class="s15 btn btn-outline-primary">Cache Questions</span>
          </a>

          <a href="{{ route('question.index',[$project->slug])}}?category_slug={{$category->slug}}">
            <span class="s15 badge badge-secondary">Questions List </span>
          </a>


          
        </nav>

        <div class="p-3 border mb-3">
          <div class="mb-3">
            <h3>Topic Name : {{ request()->session()->get('topic_name') }}</h3><br>
            Module Name : {{ request()->session()->get('module_name') }}<br>
            Module Slug : {{ request()->session()->get('module_slug') }}<br>
          </div>
          <p class="bg-light mb-3 p-2 border"> We save to session in order to copy questions from one project to other</p>
          <a class="btn btn-outline-primary" href="{{ route('category.show',[$project->slug,$category->slug])}}?store_session=true">Save to Session
          </a>
        </div>

          

          @if($parent)
          <p class="h4 ">
            <span class="badge badge-secondary" >  PARENT : {{ $parent->name }}&nbsp; 
              <span class="s10">
              <i class="fa fa-hashtag "></i>{{ $parent->slug }}
            </span>
            </span>
          </p>
          @endif
          <br>

          @if($category->video_link)
          @if(youtube_video_exists($category->video_link))
          <div class="embed-responsive embed-responsive-16by9">
            <iframe src="https://www.youtube.com/embed/{{ $category->video_link }}"></iframe>
          </div><br>
          @else
          <div class="embed-responsive embed-responsive-16by9">
            <iframe src="//player.vimeo.com/video/{{ $category->video_link }}"></iframe>
          </div><br>
          @endif
          
          @endif
          
          <h3>Siblings </h3>
          <div id="sortlist" data-value="">
            @if($list)
            {!!$list!!}
            @else
            <span class="text-muted"><i class="fa fa-exclamation-circle"></i> No Siblings </span> 
            @endif
          </div>
          
          
          @can('update',$category)
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              <a href="{{ route('category.edit',['project'=>$project->slug,'category'=>$category->slug]) }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              
               @if($list) 
              <a href="{{ route('category.show',['project'=>$project->slug,'category'=>$category->slug]).'?order=up' }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Move Up"
                ><i class="fa fa-arrow-up"></i></a>
              <a href="{{ route('category.show',['project'=>$project->slug,'category'=>$category->slug]).'?order=down' }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Move Down"><i class="fa fa-arrow-down"></i></a>
               @endif
              
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
        
        This following action will delete the node as well as all the child nodes to it and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('category.destroy',['project'=>$project->slug,'category'=>$category->slug])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection