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
    <p class='alert alert-warning alert-important'> For video question, sectional timer has to be enabled</p>
    @if(!count($exam->sections))
      <p>Kindly create a (default) section before adding questions.</p>
      <a href="{{ route('sections.create',$exam->slug)}}" class="btn btn-primary"> Create Section </a>
    @else
      <h3 class="mb-3"><u>Sections - Create Question</u></h3>
      @foreach($exam->sections as $sec)
      <h4 class="mb-2">{{$sec->name}}</h4>
        <a href="{{ route('question.create','default')}}?type=mcq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Multi Choice Question (MCQ)</a>
        <a href="{{ route('question.create','default')}}?type=maq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Multi Answer Question (MAQ) </a>
        <a href="{{ route('question.create','default')}}?type=fillup&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Fillup Question (FQ)</a>
        <a href="{{ route('question.create','default')}}?type=mbfq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Multiblank Fillup Question(MBFQ)</a>
        <a href="{{ route('question.create','default')}}?type=mbdq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Multiblank Dropdown Question(MBFQ)</a>
        <a href="{{ route('question.create','default')}}?type=sq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Subjective Question (SQ)</a>
        <a href="{{ route('question.create','default')}}?type=urq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Upload Response Question (URQ)</a>
        <a href="{{ route('question.create','default')}}?type=vq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Video Question(VQ)</a>
        @if(\auth::user()->checkRole(['administrator']))
       <a href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Code Question (CQ)</a>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 )
       <a href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Code Question (CQ)</a>
        @else
        @endif

        <a href="{{ route('question.create','default')}}?type=csq&default=1&exam={{$exam->id}}&url={{url()->current()}}&section={{$sec->id}}" class="btn btn-outline-dark mb-2"> Code Submission Question (CSQ)</a>
        <hr>
    @endforeach
      
    @endif
    
  </div>
</div>
</div>
</div>
@endsection


