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
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> Applicants ({{$data['total']}})
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
  <div  class="row my-3">
    <div class="col-12 col-md-6">
      <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Branches</th>
      <th scope="col">Count</th>
    </tr>
  </thead>
  <tbody class="{{$m=1}}">
  @foreach($data['branch_group'] as $k =>$v)
  @if(isset($data['branches'][$k]))
    <tr>
      <th scope="row">{{($m++)}}</th>
      <td>{{$data['branches'][$k]->name}}</td>
      <td>{{count($v)}}</td>
    </tr>
  @endif
  @endforeach
  </tbody>
</table>
    
    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Year of Passing</th>
      <th scope="col">Count</th>
    </tr>
  </thead>
  <tbody class="{{$m=1}}">
  @foreach($data['yop_group'] as $k =>$v)
  @if($k)
    <tr>
      <th scope="row">{{($m++)}}</th>
      <td>{{$k}}</td>
      <td>{{count($v)}}</td>
    </tr>
  @endif
  @endforeach
  </tbody>
</table>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Profile Video</th>
      <th scope="col">Count</th>
    </tr>
  </thead>
  <tbody class="">
    <tr>
      <th scope="row">1</th>
      <td>Completed</td>
      <td>{{$data['video']}}</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Incomplete</td>
      <td>{{$data['no_video']}}</td>
    </tr>
  </tbody>
</table>

    </div>
    <div class="col-12 col-md-6">
      <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">College</th>
      <th scope="col">Count</th>
    </tr>
  </thead>
  <tbody class="{{$m=1}}">
  @foreach($data['college_group'] as $k =>$v)
  @if(isset($data['colleges'][$k]))
    <tr>
      <th scope="row">{{($m++)}}</th>
      <td>{{$data['colleges'][$k]->name}}</td>
      <td>{{count($v)}}</td>
    </tr>
  @endif
  @endforeach
  </tbody>
</table>
    </div>
  </div>
</div>
@endsection


