@extends('layouts.nowrap-white')

@section('title', 'Attempts ')

@section('description', 'Know you tests')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')

@section('content')

@include('appl.exam.exam.xp_css')





<div class='pb-4 dblue' >
  <div class='container'>
     <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Attempts </li>
          </ol>
        </nav>
       <div class="row ">
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(!request()->get('month')) dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">All attempts</div>
          <div class="h2" ><a href="{{ route('attempts')}}">{{ $data['attempts_all']}}</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='thismonth') dblue border-secondary @else bg-white @endif" >
          <div class="h6">{{\carbon\carbon::now()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('attempts')}}?month=thismonth">{{ $data['attempts_thismonth']}}</a></div>
        </div>
      </div> 
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='lastmonth') dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('attempts')}}?month=lastmonth">{{ $data['attempts_lastmonth']}}</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
         <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='lastbeforemonth') dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth(2)->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('attempts')}}?month=lastbeforemonth">{{ $data['attempts_lastbeforemonth']}}</a></div>
        </div>
      </div>
  </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>

<div class="container mt-4 mb-4">

 

  <div class="mt-4 mb-4">
    @if($attempts->total()!=0)
        <div class="table-responsive">
          <div class="bg-light p-3 border-top border-left border-right " >Filter : <span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @else All Attempts @endif</span></div>
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$attempts->total()}})</th>
                <th scope="col">Test </th>
                <th scope="col">Candidate</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($attempts as $key=>$u)  
              <tr>
                <th scope="row">{{ $attempts->currentpage() ? ($attempts->currentpage()-1) * $attempts->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href="{{ route('assessment.analysis',[$u->exam()->slug]) }}?student={{$u->user->username}}" >
                  {{ $u->exam()->name }}
                  </a>
               
                </td>
                <td>
                  <a href="{{ route('profile','@'.$u->user->username)}}">
                  {{$u->user->name}}
                </a>
                </td>
                <td>
                  {{$u->created_at->format('d-m-Y')}}
                </td>
               
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Participants listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($attempts->total() > config('global.no_of_records'))mt-3 @endif">
        {{$attempts->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

  </div>

</div>

@endsection           