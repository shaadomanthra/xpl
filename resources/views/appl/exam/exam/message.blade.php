@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
     <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exams</a></li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-md-12">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> Exams Successfully Created
            <a href="{{ route('exam.index') }}"><button class="btn btn-lg btn-outline-primary">Exams</button></a>
          
          </p>
        </div>
      </div>

     
  
    </div>

    

  </div> 




@endsection