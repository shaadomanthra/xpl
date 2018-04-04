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

          @can('create',$ltag)
          <a href="{{route('ltag.create',$repo->slug)}}">
              <button type="button" class="btn btn-outline-success float-right"><i class="fa fa-plus"></i> New</button>
            </a>
          @endcan
        </nav>

         @if(count($ltags)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($ltags)}})</th>
                <th scope="col">Tag </th>
                <th scope="col">Values</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ltags as $key=>$coll)  
              <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>
                  {{ $key }}
                </td>
                <td>
                  @foreach($coll as $a=>$ltag)
                  @if($a==0)
                  <a href="{{ route('ltag.show',[$repo->slug,$ltag->id])}}">
                    {{ $ltag->value}} 
                  </a>
                  <a href="{{route('ltag.question',[$repo->slug,$ltag->id,''])}}">
                  (0)
                  </a>
                  @else
                    {{','}}
                    <a href="{{ route('ltag.show',[$repo->slug,$ltag->id])}}">
                    {{$ltag->value }}
                    </a>
                    <a href="{{route('ltag.question',[$repo->slug,$ltag->id,''])}}">
                    (0)
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
      @include('appl.library.snippets.menu')
  </div>
</div>

@endsection




