@extends('layouts.app-metronic')
@section('title', 'No Files - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')


@include('flash::message')

<div class="p-5 container">

<div class="card">
  <div class="card-body">

<h1>{{$message}}</h1>
<hr>
<h4>{{$user->name}}</h4>
<h5 class="text-primary">{{$user->roll_number}}</h5>
</div>
</div>

  
</div>



@endsection


