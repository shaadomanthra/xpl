@extends('layouts.app')
@section('title', 'Solutions - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    @if(auth::user()->checkRole(['hr-manager']))
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    @endif
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}?student={{request()->get('student')}}">{{ ucfirst($exam->name) }} - Analysis </a></li>
    <li class="breadcrumb-item">Solutions </li>
  </ol>
</nav>

@include('appl.exam.assessment.blocks.solutions')



@endsection