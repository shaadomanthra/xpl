@extends('layouts.app2')

@section('title', 'PacketPrep - Best platform to prepare for Campus Placements')

@section('description', 'PacketPrep is an online video learning preparation platform for quantitative aptitude, logical reasoning, mental ability, general english and interview skills.')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">
<div class="bg-white p-3 p-md-5">
<div class="container" style="">
  <div class="row ">
    <div class="col-12 col-md-8 ">
      <div class="display-4 mt-4 mb-4">The best platform to prepare for</div>
      <div class="display-1 mb-4" style="font-family: 'Anton', sans-serif;color:#236fb1">CAMPUS PLACEMENTS</div>
      <div class="">
        <a href="{{ route('course.show','quantitative-aptitude')}}">
        <span class="btn btn-outline-success  mr-3 mb-3">Quantitative Aptitude</span></a>
        <a href="{{ route('course.show','logical-reasoning')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Logical Reasoning</span></a> 
        <a href="{{ route('course.show','mental-ability')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Mental Ability</span></a>    
        <a href="{{ route('course.show','verbal-ability')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Verbal Ability</span></a>    
        <a href="{{ route('course.show','interview-skills')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Interview Skills</span></a>  
        <a href="{{ route('course.show','c-programming')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Programming Concepts</span></a>   
        <a href="{{ route('course.show','interview-skills')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Coding</span></a> 

  
      </div>
    </div>
    <div class="col-12 col-md-4">
      <img src="{{ asset('img/banner.png') }}" class="w-100 d-none d-md-block" >
    </div>
  </div>
</div>
</div>

<main role="main" style="z-index:-100;">

<div class=" " style="background: #e5f3ff;">
  <div class="container">

          <div class="mt-4">
          <div class="row">
              <div class="col-12 col-md-4">
<div class="border p-4 rounded bg-white"> <b><i class="fa fa-ravelry"></i> TARGET TCS</b><hr>
<p>A 100-day FREE online training to help students crack TCS NQT (National Qualifier Test) </p>
<button class="btn btn-outline-primary">Explore</button>
</div>
              </div>
              <div class="col-12 col-md-4">
<div class="border p-4 rounded bg-white"> <b><i class="fa fa-code"></i> Coding Bootcamp</b><hr>
<p>A great opportunity to utilize your leisure time to build a great realtime project, where you will learn to write code from scratch to the end. </p>
<button class="btn btn-outline-primary">Explore</button>
</div>
              </div>
          </div>
          
        </div>

    <div class="display-4 display-md-3 text-center mb-5">Best online platform to prepare for Campus Placements</div>
    <div class="row">
      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Quantitative Aptitude</h4>
  </div>
</div>
      </div>
      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Logical Reasoning</h4>
  </div>
</div>
      </div>
<div class="col-12 col-md-3">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Mental Ability</h4>
  </div>
</div>
      </div>
      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Verbal Ability</h4>
  </div>
</div>
      </div>
      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Interview Skills</h4>
  </div>
</div>
      </div>
<div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Programming Concepts</h4>
  </div>
</div>
      </div>
      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Coding</h4>
  </div>
</div>
      </div>

      <div class="col-12 col-md-3 mb-4">
<div class="card" >
  <div class="card-body">
    <h4 class="card-title" style="margin: 0px;">Target TCS</h4>
  </div>
</div>
      </div>

    </div>
  </div>
</div>

  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2>Heading</h2>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2>Heading</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


</main>




@endsection    


