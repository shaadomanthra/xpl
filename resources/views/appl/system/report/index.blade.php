@extends('layouts.app')
@section('content')

@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  
    <div class="card mb-3 bg-light">
      <div class="card-body ">
        <h1 class="mb-0"><i class="fa fas fa-align-right"></i> Reports 
          <span class="">
            <a href="{{route('report.week')}}">
            <button class="btn btn-sm btn-outline-primary" type="button">This Week</button>
            </a>
          </span>
        <span class="float-right">
           @can('create',$report)
            <a href="{{route('report.create')}}">
              <button type="button" class="btn btn-outline-success"><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </span>
        </h1>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body ">
       

        <div id="search-items" class="p-3 ">
          @if($reports->total()!=0)
            @foreach($reports as $key=>$report)  

            @if($key != 0)
              <hr>
            @endif

            <div class="row">
              <div class="col-12 col-md-4 col-lg-3">
                <h3>{{ \carbon\carbon::parse($report->updated_at)->format('d M Y') }}</h3>
                
                
              </div>
              <div class="col-12 col-md-5 col-lg-6">
                <div >
                @if($report->type==1)
                  <span class="text-success"><i class="fa fa-quote-left "></i> Week Report</span>
                @elseif($report->type==2)
                  <span class="text-warning"><i class="fa fa-quote-left "></i> Month Report</span>
                @endif
                {!! $report->content !!}
                </div>
              </div>
              <div class="col-12 col-md-3 col-lg-3">
                      <a href="{{ route('profile','@'.\auth::user()->getUsername($report->user_id))}}">{{ \auth::user()->getName($report->user_id)}}</a><br>
                <small>{{ $report->created_at->diffForHumans() }}</small>
                @can('edit',$report)  
                <a href="{{ route('report.edit',$report->id) }}">
                <i class="fa fa-edit"></i> 
                </a>
                @endcan
              </div>
            </div>
             
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Reports listed
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

      <div class="list-group  mb-0">
        <a href="#" class="list-group-item list-group-item-action list-group-item-light  disabled" >
          <h2 class="mb-0"><i class="fa fa-sliders"></i> Filters</h2>
        </a>
        <a href="{{ route('report.index',['all'=>true])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('all') ? 'active' : ''  }}">
          All Reports
        </a>
        <a href="{{ route('report.index',['day'=>true])}}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('day') ? 'active' : ''  }} ">Day Report</a>
        <a href="{{ route('report.index',['week'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('week') ? 'active' : ''  }} ">Week Report</a>
        <a href="{{ route('report.index',['month'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('month') ? 'active' : ''  }} ">Month Report</a>
        </div>
      </div>

    </div>
</div>
@endsection


