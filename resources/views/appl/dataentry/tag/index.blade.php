@extends('layouts.app')
@section('content')


@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')

<div  class="row ">

  <div class="col-md-9">
    <div class="card">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between p-3 mb-3 border">
          <a class="navbar-brand"><i class="fa fa-tags"></i> Tags </a>

          <a href="{{route('tag.create',$project->slug)}}">
              <button type="button" class="btn btn-outline-success float-right"><i class="fa fa-plus"></i> New</button>
            </a>
        </nav>

         @if(count($tags)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($tags)}})</th>
                <th scope="col">Tag </th>
                <th scope="col">Values</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tags as $key=>$coll)  
              <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>
                  {{ $key }}
                </td>
                <td>
                  @foreach($coll as $a=>$tag)
                  @if($a==0)
                  <a href="{{ route('tag.show',[$project->slug,$tag->id])}}">
                    {{ $tag->value}} 
                  </a>
                  <a href="{{route('tag.question',[$project->slug,$tag->id,''])}}">
                  ({{count($tag->questions)}})
                  </a>
                  @else
                    {{','}}
                    <a href="{{ route('tag.show',[$project->slug,$tag->id])}}">
                    {{$tag->value }}
                    </a>
                    <a href="{{route('tag.question',[$project->slug,$tag->id,''])}}">
                    ({{count($tag->questions)}})
                    </a>
                    @endif
                  @endforeach

                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Tags listed
        </div>
        @endif

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.menu')
  </div>
</div>

@endsection




