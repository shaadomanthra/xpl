@extends('layouts.app-metronic')
@section('title', 'Candidate Status - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')


<div class="mt-4 container" >
<div class="container">
  <div class="">
    <br><br>
    @include('flash::message')
    <h4>Current Page - <span class="bage badge-success rounded">&nbsp;{{count($tests)}}&nbsp;</span> &nbsp;&nbsp;|&nbsp;&nbsp; Total - <span class="bage badge-primary rounded">&nbsp; {{$total}} &nbsp;</span> </h4>
    <br>
    @foreach($tests as $u=>$t)
    {{ $t}} - <a href="{{ route('assessment.responses',$exam->slug) }}?student={{ $users->find($u)->username}}">{{$users->find($u)->name }}</a> 
    @if($qcount!=$t)
      <small><a href="{{ url()->current()}}?page={{request()->get('page')}}&rduplicates=1&user_id={{$u}}" class="btn btn-danger dtn-sm"> remove duplicates</a></small>


    @endif
    <br>
    @endforeach
    <br>
    <nav aria-label="Page navigation  " class="card-nav">
        {{$us->links('vendor.pagination.bootstrap-4') }}
      </nav>
    <br><br>   
  </div>
</div>

@endsection


