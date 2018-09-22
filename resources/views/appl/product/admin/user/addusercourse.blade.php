@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">User Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.view',$user->username) }}"> {{ $user->name }}</a> </li>
    <li class="breadcrumb-item"> Add Course </li>
  </ol>
</nav>

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        Add Course 
       </h1>
      
      <form method="post" action="{{route('admin.user.course',$user->username)}}" >
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Course</label>
        <select class="form-control course_data" name="course_data">
          @foreach($client->courses as $course)
          @if($course->getVisibility($client->id,$course->id)==1)
          <option value="{{$course->id}}" >{{$course->name}}</option>
          @endif
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Validity</label>
        <select class="form-control validity_data" name="validity_data">
          <option value="1" >1 month</option>
          @for($i=2;$i < 12;$i++)
          <option value="{{$i}}">{{$i}} months</option>
          @endfor
           <option value="12" selected>12 months</option>
        </select>
        
        @foreach($client->courses as $course)
          <input type="hidden" class="course_{{$course->id}}" name="course" value="{{ $course->price }}">
        @endforeach
      </div>
      


      <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Add" >Add</a>
    </form>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Addition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post"  action="{{route('admin.user.course',$user->username)}}">
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput ">Course Name</label>
        <div class="course_name display-4">{{$client->courses[0]->name}}</div>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput ">Validity</label>
        <div class="course_validity display-4">12 Months</div>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput ">Credits</label>
        <div class=" "><span class="badge badge-warning"><span class="credit_count">{{$client->courses[0]->price}}</span> credit</span> will be deducted from your account </div>
        </div>
      </div>
      <div class="modal-footer">
        
        
        <input type="hidden" name="validity" class="validity" value="12">
        <input type="hidden" name="course_id" class="course_id" value="{{$client->courses[0]->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-primary">Confirm</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
      </form>
    </div>
  </div>
</div>
@endsection