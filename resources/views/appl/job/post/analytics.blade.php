@extends('layouts.nowrap-white')
@section('title', 'Analytics - '.$obj->title)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Job post</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.show',$obj->slug) }}">{{$obj->title}}</a></li>
            <li class="breadcrumb-item">Analytics </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> Applicants ({{$obj->users->count()}})
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
         
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>

@include('flash::message')
<div class="container">
  <div  class="  mb-4 mt-4">
    <div id="search-items">
    sample
    </div>
  </div>
</div>
@endsection


