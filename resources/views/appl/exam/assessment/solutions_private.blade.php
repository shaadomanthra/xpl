@extends('layouts.app-border')
@section('title', 'Solutions - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@if(auth::user()->checkRole(['hr-manager']))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}">{{ ucfirst($exam->name) }} - Analysis </a></li>
    <li class="breadcrumb-item">Solutions </li>
  </ol>
</nav>
@endif

@include('appl.exam.assessment.blocks.solutions')



@endsection