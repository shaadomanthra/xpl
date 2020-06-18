@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', '')
@section('content')


<div class="container mt-4">

<div class="row">
  <div class="col-12 ">
<div class="p-0 mb-4" style="border:1px solid #eee;box-shadow: 2px 2px 2px 1px #e7e7e7">
  <div class="p-2 bg-light"> </div>
<div class="  p-3 pt-5 bg-white" >


  <div class="row ">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-3">


          <img class="img-thumbnail rounded-circle mb-3" src="@if(\auth::user()->image) {{ (\auth::user()->image)}}@else {{ Gravatar::src(\auth::user()->email, 150) }}@endif">
        </div>
        <div class="col-12 col-md-9">

          <h2>Hi, {{  \auth::user()->name}}</h2>
      <p> Welcome aboard</p>

      <p class="lead">Develop a passion for learning. If you do, you will never cease to grow - 
            Anthony J Dangelo</p>



    <a href="{{ route('profile','@'.\auth::user()->username)}}" class="btn btn-primary">Profile</a>

      <a class="btn border border-success text-success " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>

            <br><br>

        
            

        </div>


      </div>


            
             
      
      @else

      @endif

    </div>
    
    <div class="col-12 col-md-3  ">
      <div class="float-right ">
                <img src="{{ asset('/img/student_front.png')}}" class="w-100 p-3 pt-0"/>
                
      </div>
    </div>
  </div>
</div>
</div>




  </div>

  
</div>

</div>
@endsection           