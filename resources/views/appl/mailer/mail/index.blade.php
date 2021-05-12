@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item">{{ ucfirst($app->module) }}</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> {{ ucfirst($app->module) }} </a>

          <form class="form-inline" method="GET" action="{{ route($app->module.'.index') }}">

            @can('create',$obj)
            <a href="{{route($app->module.'.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Create {{ ucfirst($app->module) }}</button>
            </a>
             <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal2" data-tooltip="tooltip" data-placement="top" title="Icon" ><i class="fa fa-list"></i></a>
            @endcan
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

        <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.list')
       </div>

     </div>
   </div>
 </div>
 <div class="col-md-3 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Templates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1>Test mail</h1>
        <textarea class="form-control" rows="10"><p>The cut off for Round 1 is 53 marks. You can check your score at <a href="https://xplore.co.in/test/084682/analysis">https://xplore.co.in/test/084682/analysis</a> </p>
              <p>Students who have crossed cut off can attempt any one of the following tests </p>
              <p><div>.NET & React Test URL: <a href="https://xplore.co.in/test/481567 ">https://xplore.co.in/test/481567</a> <br>
                Access Code: JNETRJFSD <br>

                Link Expires on : 13th May 2021, 10AM </div></p>
                <p><div>.NET & Angular Test URL: <a href="https://xplore.co.in/test/481567 ">https://xplore.co.in/test/481567</a> <br>
                Access Code: JNETRJFSD <br>

                Link Expires on : 13th May 2021, 10AM </div></p>
                <div class="default-style">
                    <br>Note : 1)You can take test only in<strong>&nbsp;Laptop/desktop&nbsp;.</strong>
                   </div>
                   <div class="default-style">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2) Please register at&nbsp;<a href="https://xplore.co.in/register">Xplore.co.in/register&nbsp;</a>&nbsp;before taking the test
                   </div>
                   <div class="default-style">
                    <br>&nbsp; &nbsp; &nbsp;
                    <br>Instructions:
                    <ul>
                     <li>Each question carries 1 mark and no negative marking</li>
                     <li><strong>Mandatory</strong>: This is a AI proctored examination and you are required to keep your web-camera on in the entire duration of the examination failing which, you might not get selected</li>
                     <li>The test should be taken only from&nbsp;<strong>desktop/laptop with webcam</strong>&nbsp;facilities. Mobile Phones and Tabs are restricted</li>
                     <li>Please make sure that you&nbsp;<strong>disable all desktop notifications</strong>. Else, the test will be terminated in between</li>
                     <li>Please make sure that you have uninterrupted power and internet facility (minimum 2 MBPS required)</li>
                     <li>Please make sure that your camera is switched on and you are facing the light source</li>
                    </ul>For step by step process of Xplore assessment please click the below link
                    <br>
                    <br><a href="https://xplore.co.in/files/User_Manual_ZenQ_Assessment.pdf">https://xplore.co.in/files/User_Manual_ZenQ_Assessment.pdf</a>
                    <br>
                    <br>
        </textarea>
         
        

        <h1>sampel mail</h1>
        <pre><code>

        </code></pre>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route($app->module.'.destroy',$obj->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


