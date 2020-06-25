@extends('layouts.nowrap-white')
@section('title', 'Admin Dashboard ')
@section('description', 'Know you tests')
@section('keywords', '')
@section('content')

<div class="bg">
<div class="" style="background:#C9F7F5;border-bottom:1px solid #1BC5BD;margin-bottom:25px;">
  <div class="container">

    <div class="row py-4">
      <div class="col-12 col-md">
        
        <div class=' pb-1'>
          <p class="heading_two mb-1 f30 mt-3" >
            <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-2">
          <div class="text-center text-md-left">
            <img class="img-thumbnail rounded-circle mb-3 mt-2" src="@if(\auth::user()->image) {{ (\auth::user()->image)}} @else {{ Gravatar::src(\auth::user()->email, 150) }}@endif" style="width:120px;height:120px;">
          </div>
          </div>
          <div class="col-12 col-md-10">
            <div class='mt-3 text-center text-md-left'>
           <h2>Hi, {{  \auth::user()->name}}
            <div class="badge badge-primary d-md-inline h5 mt-3 mt-md-0" data-toggle="tooltip" title="Account Type">
      Trainer
    </div>
           </h2>
      <p> Welcome aboard</p>
      <a class="btn btn-warning " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </div>
          </div>
        </div>
          </p>
        </div>
      </div>
      <div class="col-12 col-md-2">
        <div class="row mt-4">
          <div class="col-12 ">
            <div class="card card-custom card-stretch gutter-b mt-md-3 text-center" style=''>
              <div class="card-body">
          <div class="h6">My Trainings</div>
          <div class="display-4 mb-0" ><a href="{{ route('training.index')}}" data-toggle="tooltip" title="View Trainings">{{$user->trainings->count()}}</a></div>
        </div>
      </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<div class="container  ">
  <div class="row mt-5">
    <div class="col-12 col-md-2">
      <!--begin::Tiles Widget 11-->
      <a href="{{ route('training.index')}}">
        <div class="card card-custom bg-primary gutter-b" style="height: 150px">
          <div class="card-body">
           <span class="svg-icon  svg-icon-white svg-icon-5x">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z" fill="#000000" fill-rule="nonzero"/>
                <path d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z" fill="#000000" opacity="0.3"/>
              </g>
            </svg></span>
            <div class="text-inverse-success font-weight-bolder font-size-h3 mt-3">Trainings</div>
          </div>
        </div>
      </a>

      

      <!--end::Tiles Widget 11-->
      <a href="{{ route('exam.index')}}">
            <!--begin::Tiles Widget 11-->
            <div class="card card-custom bg-info gutter-b" style="height: 150px">
              <div class="card-body">
               <span class="svg-icon svg-icon-white svg-icon-5x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Done-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"/>
                  <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                  <path d="M16.7689447,7.81768175 C17.1457787,7.41393107 17.7785676,7.39211077 18.1823183,7.76894473 C18.5860689,8.1457787 18.6078892,8.77856757 18.2310553,9.18231825 L11.2310553,16.6823183 C10.8654446,17.0740439 10.2560456,17.107974 9.84920863,16.7592566 L6.34920863,13.7592566 C5.92988278,13.3998345 5.88132125,12.7685345 6.2407434,12.3492086 C6.60016555,11.9298828 7.23146553,11.8813212 7.65079137,12.2407434 L10.4229928,14.616916 L16.7689447,7.81768175 Z" fill="#000000" fill-rule="nonzero"/>
                </g>
              </svg><!--end::Svg Icon--></span>
              <div class="text-inverse-success font-weight-bolder font-size-h3 mt-3">Tests</div>
            </div>
          </div>
        </a>
      <!--end::Tiles Widget 11-->
     
    </div>
    <div class="col-12 col-md-10">
      <div class="row">
      @include('appl.pages.bfs.icons.trainer')

  </div>
    </div>
  </div>
</div>
</div>
@endsection           