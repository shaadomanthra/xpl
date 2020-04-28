@extends('layouts.nowrap-white')
@section('title', 'Reports - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Reports</li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-area-chart"></i> Reports

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2">
         <a href='' class="float-right btn btn-success">View All</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>

@include('flash::message')

<div class="container ">
<div class='mt-4 mb-4'>
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <div id="search-items">
          <h4 class="mb-3"><i class="fa fa-angle-right"></i> All participant reports </h4>
          <a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-success mb-2 "> view all</a>

          <h4 class="mb-3 mt-4"><i class="fa fa-angle-right"></i> Categorised by Access Codes <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Employer can uniquely name the access codes to categorise the participants based on job opening."></i></h4>
      
      <div class="">
      @foreach($codes as $key=>$code)  
              @if($code)
              <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}" class="btn btn-outline-primary mb-2 ">{{ $code}}({{ $exam->getAttemptCount($code)}})</a>
              @else
              <span class="text-secondary"> - No access codes defined</span>
              @endif &nbsp;&nbsp;
      @endforeach
       </div>

       </div>
     </div>
</div>

</div>

</div>

@endsection


