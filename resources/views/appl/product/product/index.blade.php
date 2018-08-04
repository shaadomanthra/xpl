@extends('layouts.nowrap-product')
@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class="bg-white p-4  mb-4 ">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-7">
			<h1 class="mt-2 mb-4 mb-md-2">
			<img src="{{asset('img/logo_sample.png')}}" width="70px" >
       &nbsp;  Pragathi Degree College

			</h1>

		</div>
		<div class="col-12 col-md-5">
      <div class="mt-3">
    <form class="form" method="GET" action="{{ route('course.index') }}">
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control form-control-lg" id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
    </div>
  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-4" >  
      <div class="row">
      <div class="col-2">

        <div class="list-group ">
  <a href="#" class="list-group-item list-group-item-warning list-group-item-action disabled">
    Exam Filter
  </a>
  @foreach($tags as $tag)
  <a href="#" class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">{{ strtoupper($tag->value) }} <span class="badge badge-warning badge-pill">{{ count($tag->questions) }}</span></a>
  @endforeach
</div>
      </div>
      <div class="col-7">
        <div class="bg-white pr-3 pl-3">

        <table class="table  ">
  <thead>
    <tr>
      <th scope="col">Topics</th>
      <th scope="col">Concepts</th>
      <th scope="col">Practice Questions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan="3">Problems on Ages</td>
      <td> <i class="fa fa-youtube-play"></i> Ratio Problem</td>
      <td><span class="badge badge-success">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span></td>
    </tr>
    <tr>
      <td><i class="fa fa-youtube-play"></i> Relationship Data Problem</td>
      <td><span class="badge badge-success">4</span> <span class="badge badge-danger">5</span> <span class="badge badge-danger">6</span> <span class="badge badge-secondary">7</span> <span class="badge badge-secondary">8</span> <span class="badge badge-secondary">9</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i> Data Sufficiency Problem</td>
      <td><span class="badge badge-secondary">10</span> <span class="badge badge-secondary">11</span> <span class="badge badge-secondary">13</span></td>
    </tr>
    <tr>
      <td rowspan="2">Numbers</td>
      <td > <i class="fa fa-youtube-play"></i> Find Largest Number</td>
      <td><span class="badge badge-danger">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i>  Unknow value Question</td>
      <td><span class="badge badge-secondary">5</span> <span class="badge badge-secondary">6</span> <span class="badge badge-secondary">7</span></td>
    </tr>
    <tr>
      <td >Profit and Loss</td>
      <td><i class="fa fa-youtube-play"></i> simple question</td>
      <td><span class="badge badge-secondary">1</span> <span class="badge badge-secondary">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
    <tr>
      <td rowspan="3">Heights and Distances</td>
      <td> <i class="fa fa-youtube-play"></i> Ratio Problem</td>
      <td><span class="badge badge-success">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span></td>
    </tr>
    <tr>
      <td><i class="fa fa-youtube-play"></i> Relationship Data Problem</td>
      <td><span class="badge badge-success">4</span> <span class="badge badge-danger">5</span> <span class="badge badge-danger">6</span> <span class="badge badge-secondary">7</span> <span class="badge badge-secondary">8</span> <span class="badge badge-secondary">9</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i> Data Sufficiency Problem</td>
      <td><span class="badge badge-secondary">10</span> <span class="badge badge-secondary">11</span> <span class="badge badge-secondary">13</span></td>
    </tr>
    <tr>
      <td rowspan="2">Calendars</td>
      <td > <i class="fa fa-youtube-play"></i> Find Largest Number</td>
      <td><span class="badge badge-danger">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i>  Unknow value Question</td>
      <td><span class="badge badge-secondary">5</span> <span class="badge badge-secondary">6</span> <span class="badge badge-secondary">7</span></td>
    </tr>
    <tr>
      <td >Clocks</td>
      <td><i class="fa fa-youtube-play"></i> simple question</td>
      <td><span class="badge badge-secondary">1</span> <span class="badge badge-secondary">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
    <tr>
      <td rowspan="3">HCF and LCM</td>
      <td> <i class="fa fa-youtube-play"></i> Ratio Problem</td>
      <td><span class="badge badge-success">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span></td>
    </tr>
    <tr>
      <td><i class="fa fa-youtube-play"></i> Relationship Data Problem</td>
      <td><span class="badge badge-success">4</span> <span class="badge badge-danger">5</span> <span class="badge badge-danger">6</span> <span class="badge badge-secondary">7</span> <span class="badge badge-secondary">8</span> <span class="badge badge-secondary">9</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i> Data Sufficiency Problem</td>
      <td><span class="badge badge-secondary">10</span> <span class="badge badge-secondary">11</span> <span class="badge badge-secondary">13</span></td>
    </tr>
    <tr>
      <td rowspan="2">Problems on Trains</td>
      <td > <i class="fa fa-youtube-play"></i> Find Largest Number</td>
      <td><span class="badge badge-danger">1</span> <span class="badge badge-success">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
    <tr>
      <td > <i class="fa fa-youtube-play"></i>  Unknow value Question</td>
      <td><span class="badge badge-secondary">5</span> <span class="badge badge-secondary">6</span> <span class="badge badge-secondary">7</span></td>
    </tr>
    <tr>
      <td >Simplification</td>
      <td><i class="fa fa-youtube-play"></i> simple question</td>
      <td><span class="badge badge-secondary">1</span> <span class="badge badge-secondary">2</span> <span class="badge badge-secondary">3</span> <span class="badge badge-secondary">4</span></td>
    </tr>
  </tbody>
</table>

        </div>
      </div>

      <div class="col-3">
        <div class="bg-primary rounded text-white border-round p-3">
          <div>Welcome,</div>
          <h1> <b>Krishna Teja </b></h1>
          <button class="btn btn-warning btn-sm">Logout</button><br><br>

          <div class="row no-gutters">
            <div class="col-6">
                <div class=" border rounded p-2 mr-1 mb-2">
                  <span class="text-light small">Questions</span><br>
                  <h1>1520</h1>
                </div>
            </div>
            <div class="col-6">
                <div class=" border rounded p-2 ml-1 mb-2">
                  <span class="text-light small">Attempted</span><br>
                  <h1>12</h1>
                </div>
            </div>
          </div>
          <div class="row no-gutters">
            <div class="col-6">
                <div class=" border rounded p-2 mr-1">
                  <span class="text-light small">Correct</span><br>
                  <h1>4</h1>
                </div>
            </div>
            <div class="col-6">
                <div class=" border rounded p-2 ml-1">
                  <span class="text-light small">Incorrect</span><br>
                  <h1>2</h1>
                </div>
            </div>
          </div>
          <br>

          <div class="row no-gutters">
            <div class="col-6">
                <div class="  rounded p-2 mr-1">
                  <span class="text-light small">Accuracy</span><br>
                  <h1 class="text-warning">40%</h1>
                </div>
            </div>
            <div class="col-6">
                <div class=" rounded p-2 ml-1">
                  <span class="text-light small">Speed</span><br>
                  <h1 class="text-warning">4.5s</h1>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>

     </div>   
</div>

@endsection           