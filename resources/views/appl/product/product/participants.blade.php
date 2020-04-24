@extends('layouts.nowrap-white')

@section('title', 'Participants ')

@section('description', 'Know you tests')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')

@section('content')

@include('appl.exam.exam.xp_css')

<div class='p-1  ddblue' >
</div>

<div class="container mt-4 mb-4">

  <div class="row ">
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">All participants</div>
          <div class="h2" ><a href="{{ route('exam.index')}}">{{ $user->participants}}</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">{{\carbon\carbon::now()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('exam.index')}}">{{ $user->participants_thismonth}}</a></div>
        </div>
      </div> 
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('exam.index')}}">{{ $user->participants_lastmonth}}</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
         <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth(2)->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('exam.index')}}">{{ $user->participants_lastbeforemonth}}</a></div>
        </div>
      </div>
  </div>

  <div class="mt-4 mb-4">
    @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Tests</th>
                <th scope="col">Scores</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$u)  
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href="{{ route('profile','@'.$u->username)}}">
                  {{ $u->name }}
                  </a>
               
                </td>
                <td>
                  @foreach($u->tests() as $e)
                    @if(in_array($e->id,$examlist))
                    <a href="{{ route('assessment.analysis',$e->slug)}}?student={{$u->username}}" >
                    {{$e->name}}</a> &nbsp; <i><small class="text-secondary float-right">{{\carbon\carbon::parse($e->attempt_at)->diffForHumans()}}</small></i><br>
                    @endif
                  @endforeach
                </td>
                <td>
                  @foreach($u->tests() as $e)
                    @if(in_array($e->id,$examlist))
                    @if($e->slug!='psychometric-test')
                      @if($e->score){{$e->score}} @else 0 @endif / {{$e->max}} <br>
                    @endif
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
          No Participants listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

  </div>

</div>

@endsection           