@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Recruit</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-9">

  <div class="card mb-4">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-md-3 col-lg-2 d-none d-md-block">
            <div class="text-center"><i class="fa fa-reddit fa-5x"></i> </div>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
               <h1 class=" mb-2"> Recruit App</h1>
              <blockquote class="blockquote mb-0">
                <p class="mb-0">Talent wins games, but teamwork and intelligence win championships.</p>
                <footer class="blockquote-footer"><cite title="Source Title">Michael Jordan</cite></footer>
              </blockquote>
            </div>
         </div>
        </div>
    </div>


     <div class="row mb-4 mb-md-0 ">
      <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-arrow-circle-right"></i> Jobs 
                  <span class="s15 float-right">
                    <a href="{{ route('job.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
                @foreach($jobs as $job)
                  <div><b><a href="{{ route('job.show',$job->id) }}">{{ $job->title }}</a></b></div>
                  {!! str_limit(strip_tags($job->content),100) !!} <a href="{{ route('job.show',$job->id) }}">readmore</a><br><Br>
                @endforeach
              </div>
          </div>




      </div>
      <div class="col-md-6 ">
          <div class="card">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-wpforms"></i> Forms
                  <span class="s15 float-right">
                    <a href="{{ route('form.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
                <div class="row no-gutters">
                  <div class="col-6  col-lg-6 ">
                      <div class="bg-light border mr-2  mb-3 p-2">
                        <div>All </div>
                        <h3 class="text-dark ">  {{ $forms->count['all'] }}</h3>
                      </div>
                    </div>
                    <div class="col-6  col-lg-6 ">
                      <div class="bg-light border ml-2  mb-3 p-2">
                        <div>Open</div>
                        <h3 class="text-secondary ">  {{ $forms->count['open'] }}</h3>
                      </div>
                    </div>
                    <div class="col-6  col-lg-6 ">
                      <div class="bg-light border mr-2 mb-3 p-2">
                        <div>Accepted</div>
                        <h3 class="text-success"> <i class="fa fa-check-circle"></i> {{ $forms->count['accepted'] }}</h3>
                      </div>
                    </div>
                    <div class="col-6  col-lg-6 ">
                      <div class="bg-light border ml-2 p-2">
                        <div>Rejected</div>
                        <h3 class="text-danger "> <i class="fa fa-minus-circle"></i> {{ $forms->count['rejected'] }}</h3>
                      </div>
                    </div>
                </div>
                <h2> Latest</h2>
              @foreach($forms as $form)
                  <div><b><a href="{{ route('form.show',$form->id) }}">{{ $form->name }}</a></b></div>
                  <div> Age : {{ \carbon\carbon::parse($form->dob)->age }} years </div>
                   Applied : {{ $form->job->title }}<br><BR>
                   
                @endforeach
            </div>
         </div>
       </div>
    </div>



  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.recruit.snippets.menu')
    </div>
</div>

@endsection


