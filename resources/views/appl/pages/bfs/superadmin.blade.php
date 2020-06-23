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
            <div class="badge badge-info d-md-inline h5 mt-3 mt-md-0" data-toggle="tooltip" title="Account Type">
      Administrator
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
          <div class="h6">Total Users</div>
          <div class="display-4 mb-0" ><a href="{{ route('user.list')}}" data-toggle="tooltip" title="View Users">{{$user->where('client_slug',subdomain())->count()}}</a></div>
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
    <div class="col-12 col-md-4">
     

            <!--begin::Mixed Widget 1-->
                    <div class="card card-custom bg-gray-100  gutter-b">
                      <!--begin::Header-->
                      <div class="card-header border-0 bg-danger py-4 ">

                        
                        <div class="p-2 m-4">&nbsp;</div>

                        
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body p-0 ">
                        <!--begin::Chart-->
                        <div class="p-3"></div>
                        <!--end::Chart-->
                        <!--begin::Stats-->
                        <div class="card-spacer mt-n20">
                          <!--begin::Row-->
                          <div class="row m-0">
                            <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                              <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                <i class="fas fa-address-card fa-3x text-warning"></i>
                              </span>
                              <a href="{{route('user.list')}}?role=student" class="text-warning font-weight-bold font-size-h6">Students</a>
                            </div>
                            <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                              <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                <i class="fas fa-chalkboard-teacher fa-3x text-primary"></i>
                              
                              </span>
                              <a href="{{route('user.list')}}?role=hr-manager" class="text-primary font-weight-bold font-size-h6 mt-2">Trainers</a>
                            </div>
                          </div>
                          <!--end::Row-->
                          <!--begin::Row-->
                          <div class="row m-0">
                            <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                              <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                               <i class="fas fa-university fa-3x text-danger"></i>
                              </span>
                              <a href="{{route('user.list')}}?role=tpo" class="text-danger font-weight-bold font-size-h6 mt-2">Colleges</a>
                            </div>
                            <div class="col bg-light-success px-6 py-8 rounded-xl">
                              <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                <i class="fas fa-user-tie fa-3x text-success"></i>
                              </span>
                              <a href="{{route('user.list')}}?role=recruiter" class="text-success font-weight-bold font-size-h6 mt-2">Recruiters</a>
                            </div>
                          </div>
                          <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 1-->
    </div>
    <div class="col-12 col-md-8">
      @include('appl.pages.bfs.icons.superadmin')
    </div>
  </div>
</div>
</div>
@endsection           