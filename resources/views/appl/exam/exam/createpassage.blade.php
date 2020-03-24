@extends('layouts.app')
@section('title', 'Create Passage | Xplore')
@section('content')

<div class="d-none d-md-block">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.index')}}">Exam</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug)}}">{{ $exam->name }}</a></li>
      <li class="breadcrumb-item"> Passage </li>
      <li class="breadcrumb-item">Create</li>
    </ol>
  </nav>
</div>
<div class="card">
  <div class="card-body">
    
      <h4 class="mb-4">Create your first passage</h4>
      <div class="btn-group" role="group" aria-label="Basic example">
      <a href="{{ route('passage.create','default')}}?type=mcq&default=1&exam={{$exam->id}}&url={{url()->current()}}" class="btn btn-primary"> Create Passage </a>
    </div>
    
  </div>
</div>

@endsection


