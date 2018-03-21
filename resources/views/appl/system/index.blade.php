@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">System</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-9">

    <div class="card mb-3">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-2">
            <div class="text-center"><i class="fa fa-chrome fa-5x"></i> </div>
            </div>
            <div class="col-9">
              <h1 class=" mb-2"> System App</h1>
              <p class="mb-0">
                This is an internal app developed for packetprep team to maintain transparency and accountability.
              </p>
            </div>
         </div>
        </div>
    </div>

    <div class="card mb-3">
      <div class="card-body ">
        <div class="row no-gutter">
          <div class="col-6">
           <h2>Vision</h2> 
           <p class="mb-0">
            To create a world-class learning platform for self study
           </p>
         </div>
         <div class="col-6">
          <h2>Mission</h2> 
           <p class="mb-0">
            To develop comprehensive content that makes learning simple, interesting and effective. 
           </p>

         </div>
       </div>
     </div>
   </div>

    <div class="card mb-3">
      <div class="card-body bg-primary text-white">
        <h2><b>Goals</b></h2>
        <p class="mb-0 pb-0">
          <ol class="mb-0 pb-0">
            @if(isset($goals))
            @foreach($goals as $goal)
            <li>{{ $goal->title }} <span class="text-info">by {{\carbon\carbon::parse($goal->end_at)->format('M d Y')}}</span></li>
            @endforeach
            @endif
          </ol>
        </p>
     </div>
   </div>

   <div class="card">
      <div class="card-body ">
        <h2>Core Values</h2>
        <p class="mb-0 pb-0">
          <ol class="mb-0 pb-0">
            <li>Passion driven</li>
            <li>Creative Mindset</li>
            <li>Original content</li>
            <li>Empower learners</li>
            <li>Student centric</li>
          </ol>
        </p>
     </div>
   </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>

@endsection


