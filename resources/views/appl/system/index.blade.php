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
            <div class="col-4 col-md-3 col-lg-2">
            <div class="text-center"><i class="fa fa-chrome fa-5x"></i> </div>
            </div>
            <div class="col-8 col-md-9 col-lg-10">
              <h1 class=" mb-2"> System App</h1>
              <blockquote class="blockquote mb-0">
                <p class="mb-0">Ideas are cheap. Ideas are easy. Ideas are common. Everybody has ideas. Ideas are highly, highly overvalued. Execution is all that matters.</p>
                <footer class="blockquote-footer"><cite title="Source Title">Casey Neistat</cite></footer>
              </blockquote>
            </div>
         </div>
        </div>
    </div>
  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>

@endsection


