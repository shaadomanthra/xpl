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
            <a href="{{route('report.index')}}">
            <button class="btn btn-sm btn-outline-primary" type="button">view all</button>
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

    
       

        <div id="search-items" class=" ">
          @if(count($reports)!=0)
            @foreach($reports as $key=>$item)  
            <div class="card mb-3">
            <div class="card-body ">
            

            
            <div class="row">
              <div class="col-8 col-md-3 col-lg-2 mb-3  mb-md-0">

              <div class="d-none d-md-block">
                <div class="bg-light p-2 rounded border text-center">
                <div>{{ \carbon\carbon::parse($item[0]->updated_at)->format('M') }}</div>
                <h1>{{ $key }}</h1>
                <div>{{ \carbon\carbon::parse($item[0]->updated_at)->format('Y') }}</div>
                </div>
              </div>
              <div class="d-block d-md-none">
                <div class="bg-light p-2 rounded border pl-3">
                <div>{{ \carbon\carbon::parse($item[0]->updated_at)->format('d M Y') }}</div>
                </div>
              </div>
              </div>
              
              <div class="col-12 col-md-9 col-lg-10">
                @foreach($item as $id=>$report)

                @if($id!=0)
                <hr>
                @endif
                <div class="row">
                  <div class="col-8">
                     <div>
                      @if($report->type==1)
                      <span class="text-success"><i class="fa fa-quote-left "></i> Week Report</span>
                      @elseif($report->type==2)
                      <span class="text-warning"><i class="fa fa-quote-left "></i> Month Report</span>
                      @endif
                      {!! $report->content !!}
                      
                      </div>
                  </div>
                  <div class="col-4">
                      <div class="">
                      <a href="{{ route('profile','@'.\auth::user()->getUsername($report->user_id))}}">{{ \auth::user()->getName($report->user_id)}}</a><br>

                      <small>{{ $report->updated_at->diffForHumans() }}</small>
                      @can('edit',$report)  
                      <a href="{{ route('report.edit',$report->id) }}">
                      <i class="fa fa-edit"></i>
                      </a>
                      @endcan
                      </div>
                  </div>
                </div>
                @endforeach

              </div>
              
              

            </div>
            

             </div>
             </div>
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Reports listed
          </div>
          @endif
         
        </div>

      

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>
@endsection


