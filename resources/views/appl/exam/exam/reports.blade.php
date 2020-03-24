@extends('layouts.app')
@section('title', 'Reports - '.$exam->name)

@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{ $exam->name}}</a></li>
    <li class="breadcrumb-item">Reports</li>
  </ol>
</nav>

@include('flash::message')


<div  class="row ">

  <div class="col-12 col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-inbox"></i> Reports - Access Code </a>

          <a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-primary btn-sm">View all</a>

          
          
        </nav>

        <div id="search-items">
         
 @if(count($codes)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($codes)}})</th>
                <th scope="col">Code</th>
                <th scope="col">Participant</th>
              </tr>
            </thead>
            <tbody>
              @foreach($codes as $key=>$code)  
              <tr>
                <th scope="row">{{$key+1 }}</th>
                <td>
                  <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}">{{ $code }}</a>
                  
                </td>
                <td>
                  {{ $user[$key] }}
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Reports listed
        </div>
        @endif
        

       </div>

     </div>
   </div>
 </div>

 <div class="col-md-3 pl-md-0">
      @include('appl.exam.snippets.menu')
    </div>
 
</div>

@endsection


