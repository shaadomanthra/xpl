@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item "><a href="{{ route('job.index')}}">Jobs</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      Success 
    </li>
  </ol>
</nav>

  @include('flash::message')

  <div class="row ">

    <div class="col-md-12">
      <div class="card  ">
        <div class="card-body ">
          
          <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-check-circle"></i> Successfully applied ! 
            </a>
        </nav>

        <p class="mb-3">
        Thank you for your interest in the job posting. Our team will get in touch with you via email/phone very soon.
    </p>

      <a href="{{route('home')}}">
      <button class="btn btn-info"> Home</button>
  	</a>
        </div>

        

      </div>




    </div>


  </div> 

@endsection