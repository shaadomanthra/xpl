@extends('layouts.app2')

@section('title', 'PacketPrep - Prepare for Campus Placements, Bank Exams and Government Jobs')

@section('description', 'PacketPrep is an online video learning preparation platform for quantitative aptitude, logical reasoning, mental ability, general english and interview skills.')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')

<main role="main" style="z-index:-100;">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">

      <div class="carousel-item active" style="background: linear-gradient(to top, rgba(0, 0, 0,0.4),rgba(0, 0, 0,0.8)), url({{asset('img/front/one.jpg')}}); height: stretch;background-repeat: no-repeat;background-size: auto;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">


        
       
      
        <div class="container">
          <div class="carousel-caption text-left">
            <h1 class="display-3 display-md-2">GigaCode <span class="d-none d-md-inline">Workshop</span></h1>
            <span class="badge badge-warning mb-3">Coding Interview Preparation</span>
            <p>One day Intensive classroom training workshop to help students crack coding interviews. The workshop covers basics of c programming,  important coding logics and a live implementation of 20 programming tasks.</p>
            <p><a class="btn btn-lg btn-outline-light" href="{{ url('gigacode')}}" role="button">Reserve your seat</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="background: linear-gradient(to top, rgba(0, 0, 0,0.4),rgba(0, 0, 0,0.8)), url({{asset('img/front/two.jpg')}}); height: stretch;background-repeat: no-repeat;background-size: auto;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
        
        <div class="container">
          <div class="carousel-caption">
            <h1 class="display-1">Target TCS</h1>
            <p>Free online course to help students prepare for TCS NQT - National Qualifier Test. The course includes 100 concept lectures, 300+ practice questions and 60+ online assessments covering quantitative aptitude, programming logic and coding.</p>
            <p><a class="btn btn-lg btn-outline-light" href="{{ url('course/targettcs')}}" role="button">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="background: linear-gradient(to top, rgba(0, 0, 0,0.4),rgba(0, 0, 0,0.8)), url({{asset('img/front/three.jpg')}}); height: stretch;background-repeat: no-repeat;background-size: auto;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
        
        <div class="container">
          <div class="carousel-caption text-right">
            <h1 class="display-2">Score <span class="badge badge-danger">320+</span> in GRE</h1>
            <p>PacketPrep offers all its users an opportunity to attend a session, take a test, and get industry acclaimed expert counselling - all for free!.</p>
            <p><a class="btn btn-lg btn-outline-light" href="{{ url('firstacademy')}}" role="button">Know More</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
<div class=" p-5  mb-5" style="background: #e5f3ff;">
  <div class="container">
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


