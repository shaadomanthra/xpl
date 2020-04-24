@extends('layouts.nowrap-white')
@section('title', 'Create Question ')
@section('content')

<div class="container">
  <div class="mt-1 mb-4">
<div class="d-none d-md-block">
  <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{ $exam->name }}</a></li>
    <li class="breadcrumb-item">Create Question</li>
          </ol>
        </nav>
</div>
<div class="card">
  <div class="card-body">
    @if(!count($exam->sections))
      <p>Kindly create a (default) section before adding questions.</p>
      <a href="{{ route('sections.create',$exam->slug)}}" class="btn btn-primary"> Create Section </a>
    @else
      <h3 class="mb-3"><u>Sections - Create Question</u></h3>
      @foreach($exam->sections as $sec)
      <h4 class="mb-2">{{$sec->name}}</h4>
      <div class="btn-group mb-4" role="group" aria-label="Basic example">
  <a href="{{ route('question.create','default')}}?type=mcq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-primary"> Multi Choice Question (MCQ)</a>
  <a href="{{ route('question.create','default')}}?type=maq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-warning"> Multi Answer Question (MAQ) </a>
  <a href="{{ route('question.create','default')}}?type=fillup&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-success"> Fillup Question (FQ)</a>
  <a href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-secondary"> Code Question (CQ)</a>

</div>
    @endforeach
      
    @endif
    
  </div>
</div>
</div>
</div>
@endsection


