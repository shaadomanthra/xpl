@extends('layouts.app')
@section('title', 'Create Question | Xplore')
@section('content')

<div class="d-none d-md-block">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.index')}}">Tests</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug)}}">{{ $exam->name }}</a></li>
      <li class="breadcrumb-item"> Questions</li>
      <li class="breadcrumb-item">Create</li>
    </ol>
  </nav>
</div>
<div class="card">
  <div class="card-body">
    @if(!count($exam->sections))
      <p>Kindly create a (default) section before adding questions.</p>
      <a href="{{ route('sections.create',$exam->slug)}}" class="btn btn-primary"> Create Section </a>
    @else
      <h4 class="mb-4">Create your first question</h4>
      <div class="btn-group" role="group" aria-label="Basic example">
  <a href="{{ route('question.create','default')}}?type=mcq&default=1&exam={{$exam->id}}&url={{url()->current()}}" class="btn btn-primary"> MCQ Question </a>
  <a href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&url={{url()->current()}}" class="btn btn-secondary"> Code Question </a>
</div>
      
    @endif
    
  </div>
</div>

@endsection


