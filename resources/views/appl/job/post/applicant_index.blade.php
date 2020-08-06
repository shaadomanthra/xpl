@extends('layouts.nowrap-white')
@section('title', 'Applicants - '.$obj->title)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Job post</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.show',$obj->slug) }}">{{$obj->title}}</a></li>
            <li class="breadcrumb-item">Applicants </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> Applicants ({{$obj->users_count}})
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
          
        <a href="{{ route('job.applicants',$obj->slug)}}?export=1" class="btn  btn-success float-right  "><i class="fa fa-download"></i>&nbsp; Excel</a>
        

          <form class="form-inline mr-3 " method="GET" action="{{ route('job.applicants',$obj->slug) }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
          

         
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>

@include('flash::message')
<div class="container">
  <div  class="row  mb-4 mt-4">
    <div class="col-12 ">
    <div id="search-items">
    @include('appl.job.post.applicant_list')
    </div>
  </div>

  </div>
</div>
@endsection

<div class="modal fade " id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="" id="">
        <div class="p-3 loading">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>  
        </div> Loading...
        
        </div>
        <div id="user_data">
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

