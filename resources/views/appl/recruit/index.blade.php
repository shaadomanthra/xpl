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

    <div class="card mb-3">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-2">
            <div class="text-center"><i class="fa fa-reddit fa-5x"></i> </div>
            </div>
            <div class="col-9">
              <h1 class=" mb-2"> Recruit App</h1>
              <blockquote class="blockquote mb-0">
                <p class="mb-0">Talent wins games, but teamwork and intelligence win championships.</p>
                <footer class="blockquote-footer"><cite title="Source Title">Michael Jordan</cite></footer>
              </blockquote>
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


