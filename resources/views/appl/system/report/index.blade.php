@extends('layouts.app')
@section('content')

@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  
    <div class="card mb-3">
      <div class="card-body ">
        <nav class="navbar navbar-light bg-light justify-content-between mb-4">
          <a class="navbar-brand"><i class="fa fas fa-align-right"></i> Reports </a>
          @can('create',$report)
            <a href="{{route('report.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 "><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </nav>

        <div id="search-items" class="p-3 ">
          @if($reports->total()!=0)
            @foreach($reports as $key=>$report)  

            @if($key != 0)
              <hr>
            @endif

            <div class="row">
              <div class="col-3">
                <h3>{{ \carbon\carbon::parse($report->updated_at)->format('d M Y') }}</h3>
                @can('edit',$report)  
                <a href="{{ route('report.edit',$report->id) }}">
                <i class="fa fa-edit"></i> edit
                </a>
                @endcan
                
              </div>
              <div class="col-6">
                
                <div >
    
                
                {!! $report->content !!}
                
                </div>

              

              </div>
              <div class="col-3">
                      <a href="{{ route('profile','@'.\auth::user()->getUsername($report->user_id))}}">{{ \auth::user()->getName($report->user_id)}}</a><br>
                <small>{{ $report->updated_at->diffForHumans() }}</small>
              </div>
            </div>

             
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Goals listed
          </div>
          @endif
          <div class="mt-4">
          <nav aria-label="Page navigation example">
            {{$reports->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>
        </div>

      </div>
    </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>
@endsection


