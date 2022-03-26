@extends('layouts.nowrap-white')
@section('title', 'Add Attempt - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Add Attempt</li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-plus-square"></i> Add Attempt

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
       
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>

@include('flash::message')

<div class="container ">
<div class='mt-4 mb-4'>
  <div class="row">
    <div class="col-6 col-md-6">
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
          <form action="{{ route('assessment.try',$exam->slug)}}" >
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="student" placeholder="Enter username">
              <input type="hidden" name="admin" value="1">
              <input type="hidden" name="code" value="{{$code}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
       </div>
     </div>
   </div>
   <div class="col-6 col-md-6">

    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
          <form action="{{ route('test.attempt',$exam->slug)}}" >
            <div class="form-group">
              <label for="exampleInputEmail1">Info</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="batch" placeholder="Enter batch number" value="{{ request()->get('batch')}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
       </div>
     </div>

   </div>
    </div>
  </div>

  @if(count($users))
  <div class="my-3">
    <div class="card">
      <div class="card-header">Batch Users : {{$bno}}</div>
      <div class="card-body">
        @foreach($users as $u)
          <a href="{{ route('assessment.try',$exam->slug)}}?code={{$code}}&admin=1&student={{$u->username}}&responses=1" class="mb-5 h5">{{ $u->name }}</a> &nbsp; 
          @if(isset($attempts[$u->id]))
            <i class="fa fa-check-circle text-success"></i> <span class="text-success">completed</span>
          @endif
          <br>
        @endforeach
      </div>
    </div>
  </div>
  @elseif(request()->get('batch'))
  <div class="my-3">
    <div class="card">
      <div class="card-header">No Users found</div>
      
    </div>
  </div>
  @endif
</div>

</div>

@endsection


