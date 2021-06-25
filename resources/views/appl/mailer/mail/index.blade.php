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
             <a href="#" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#exampleModal2" data-tooltip="tooltip" data-placement="top" title="Icon" ><i class="fa fa-bars"></i> Templates</a>
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Templates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Test Link Mail</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Shortlisted Mail</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Rejection Mail</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
     <h1 class="mt-4">Test Link Mail - Preview</h1>
        
        <div class="bg-light rounded p-3 mb-4 border">
          <p>YuppTV - Developer Role&nbsp; Pre-Assessment is scheduled for 13th June.</p><p><b>Date:</b> 13-June-21</p><p><b>Time:</b> 11.00 AM</p><p><b>Test URL:&nbsp;</b><a href="https://xplore.co.in/test/51467" target="_blank">https://xplore.co.in/test/51467</a></p><p><b>Access Code: </b>YUPP0406</p><p><b>Note :</b> Before attempting test create account in Xplore (https://xplore.co.in/register). If you already have an account login with your credentials.</p><p><b>Test Instructions :</b></p><p>1. The test contains 20 questions to be answered in 40 minutes</p><p>2. Each correct answers carries 2 marks</p><p>3.  For Each Wrong answer carries 1 negative mark</p><p>4. The test should be taken only from Desktop and laptop</p><p>5. Please make sure that you have uninterrupted power and internet facility (minimum 2 MBPS required)</p><p>6. Please turn off all notifications before taking the test</p><p>7. Please don't exit the full screen while attempting the test</p><p>8. Do not swap the window multiple times may, which terminate your test</p><p>9. Malpractice will leads to disqualify the test</p>
        </div>
        <h1>Mail Html Code</h1>
        <textarea class="form-control" rows="5"><p>YuppTV - Developer Role&nbsp; Pre-Assessment is scheduled for 13th June.</p><p><b>Date:</b> 13-June-21</p><p><b>Time:</b> 11.00 AM</p><p><b>Test URL:&nbsp;</b><a href="https://xplore.co.in/test/51467" target="_blank">https://xplore.co.in/test/51467</a></p><p><b>Access Code: </b>YUPP0406</p><p><b>Note :</b> Before attempting test create account in Xplore (https://xplore.co.in/register). If you already have an account login with your credentials.</p><p><b>Test Instructions :</b></p><p>1. The test contains 20 questions to be answered in 40 minutes</p><p>2. Each correct answers carries 2 marks</p><p>3.  For Each Wrong answer carries 1 negative mark</p><p>4. The test should be taken only from Desktop and laptop</p><p>5. Please make sure that you have uninterrupted power and internet facility (minimum 2 MBPS required)</p><p>6. Please turn off all notifications before taking the test</p><p>7. Please don't exit the full screen while attempting the test</p><p>8. Do not swap the window multiple times may, which terminate your test</p><p>9. Malpractice will leads to disqualify the test</p>
       
        </textarea>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h1 class="mt-4">Shortlisted Mail - Preview</h1>
        
        <div class="bg-light rounded p-3 mb-4 border">
          <p>Congratulations! You are shortlisted for Round-2 at JNET Technologies. You will receive a detailed followup mail about the further proceedings couple of days.  </p>
        </div>
        <h1>Mail Html Code</h1>
        <textarea class="form-control" rows="5"><p>Congratulations! You are shortlisted for Round-2 at JNET Technologies. You will receive a detailed followup mail about the further proceedings couple of days.  </p>
        
        </textarea>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
     <h1 class="mt-4">Rejection Mail - Preview</h1>
        
        <div class="bg-light rounded p-3 mb-4 border">
          <p>Thank you for your interest in JNET Technologies. Unfortunately, you could not cross the cut off mark, therefore we will not be moving forward with your application, but we appreciate your time and interest in JNET.
          </p>
        </div>
        <h1>Mail Html Code</h1>
        <textarea class="form-control" rows="5"><p>Thank you for your interest in JNET Technologies. Unfortunately, you could not cross the cut off mark, therefore we will not be moving forward with your application, but we appreciate your time and interest in JNET.
          </p>
        </textarea>
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


