@extends('layouts.app2')
@section('title', 'Assessments to hire the best candidates')
@section('description', 'The best repository for placement papers and aptitude questions for infosys, tcs nqt,tcs ninja, tcs digital, amcat, cocubes, accenture, cognizant, wipro and many more ')
@section('keywords', 'campus placement preparation, wipro placement papers, infosys placement papers, aptitude questions, amcat previous papers, amcat preparation,tcs nqt, tcs ninja, tcs digital')
@section('content')
<style>

.bg-p {
  background-position: bottom;
  animation: 20s linear 0s infinite bp;
  align-items: center;
  justify-content: center;
}

@keyframes bp {
  from {
    background-position:  198px 0;
  }
  
  to {
    background-position:  0 198px;
  }
}

.heading_one{
	color:#3155b8;
	font-family: 'Montserrat', sans-serif;
	font-weight: 900;
	line-height: 1.2;
	font-size:60px;
}


.heading_two{
	color:#3155b8;
	font-family: 'Montserrat';
	font-size:40px;
	font-weight: 500;
}

</style>
<div class="p-3 bg-p text-center" style="color:#fff;background-color:#f6f9ff;background-image: url({{asset('img/colors/star2.png')}});">
<div class="container" style="">
<div class="p-3 p-md-5"></div>
    <div class="heading_one  text-center" >
    Now its the time to <br>hire the best
    </div>
    <div class="heading_two  mb-4 mt-3 text-center" >
   Choose from <span class="element" ></span> 
    </div>
    <div>
    	<a href="{{ route('login')}}" class="btn btn-lg btn-success">Try for Free</a>
    </div>

   
   <div class="p-2 p-md-5"></div>
</div>


</div>

<div class="" style="background:#fff">
  <div class="container">
        <div class="p-3 p-md-4"></div>
    <div class="display-3 mb-5 text-center">We hire for</div>
    <div class="p-0 p-md-2"></div>

    <div class="row">
            @for($i=1;$i<19;$i++)
            <div class="col-6 col-md-2">
              <img class="example-image p-1 mb-3" src="img/companies/{{$i}}.jpg"  width="100%" alt="Companies{{$i}}" />
            </div>
            @endfor
        </div>
        <div class="p-4 p-md-4"></div>
  </div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <div class="video_body">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection    