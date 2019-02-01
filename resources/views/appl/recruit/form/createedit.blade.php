@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item "><a href="{{ route('job.index')}}">Jobs</a></li>
    <li class="breadcrumb-item "><a href="{{ route('job.show',$job->slug)}}">{{ $job->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      @if($stub=='Create')
          Apply
        @else
          Update Application
        @endif  
    </li>
  </ol>
</nav>
@include('flash::message')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="card">
    <div class="card-body">
      <h1 class="card bg-light mb-3">
        <div class="card-body">
        @if($stub=='Create')
          Application - {{ $job->title }}
        @else
          Update Application
        @endif  
      </div>
       </h1>
      

      @if($stub=='Create')
      <form method="post" action="{{route('form.store')}}" class="p-2">
      @else
      <form method="post" action="{{route('form.update',$form->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Full Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" 
            @if($stub=='Create')
            value="@if(\auth::user()) {{ \auth::user()->name }}@endif"
            @else
            value = "{{ $form->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Date of Birth</label>
        <input id="datepicker" type="text" class="form-control" name="dob" 
            @if($stub=='Create')
            value="{{ (old('dob')) ? old('dob') : '' }}"
            @else
            value = "{{ $form->dob }}"
            @endif

          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="@if(auth::guest()) @else {{ auth::user()->id }} @endif">
        <input type="hidden" name="job_id" value="{{ $job->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Email</label>
        <input type="email" class="form-control" name="email" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="@if(\auth::user()) {{ \auth::user()->email }}@endif"
            @else
            value = "{{ $form->email }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">Phone</label>
        <input type="text" class="form-control" name="phone" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="@if(\auth::user())@if(\auth::user()->details) {{ \auth::user()->details->phone }}@endif @endif"
            @else
            value = "{{ $form->phone }}"
            @endif
          >
      </div>

     <div class="form-group">
        <label for="formGroupExampleInput2">Address </label>
         <textarea id="summernote" class="form-control summernote2" name="address"  rows="3">
@if($stub=='Create')
            
            @else
            {{ $form->address }}
            @endif
        </textarea>
      </div>

      

      <div class="form-group">
        <label for="formGroupExampleInput2">Experience</label>
         <textarea id="summernote" class="form-control summernote2" name="experience"  rows="3" placeholder="Mention if you are a class representative or if you have participated in any of the events as a coordinator">
            @if($stub=='Create')
            {{ (old('experience')) ? old('experience') : '' }}
            @else
            {{ $form->experience }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Why do you think you are apt for this position?</label>
         <textarea id="summernote" class="form-control summernote2" name="why"  rows="3">
            @if($stub=='Create')
            {{ (old('why')) ? old('why') : '' }}
            @else
            {{ $form->why }}
            @endif
        </textarea>
      </div>

      @if($stub=='Create')
      <div class="g-recaptcha mb-3" data-sitekey="6Lc9yFAUAAAAALZlJ3hsqVZQKjOGNIrXezGmawtf"></div>
      @endif

      @can('update',$form)
      <div class="form-group">
        <label for="formGroupExampleInput2">reason</label>
         <textarea id="summernote" class="form-control summernote2 " name="reason"  rows="3">
            @if($stub=='Create')
            {{ (old('reason')) ? old('reason') : '' }}
            @else
            {{ $form->reason }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if($form->status==0) selected @endif  >Open</option>
          <option value="1" @if($form->status==1) selected @endif  >Accepted</option>
          <option value="2" @if($form->status==2) selected @endif  >Rejected</option>
        </select>
      </div>
      @endcan

      @cannot('update',$form)
      <input type="hidden" name="reason" value="">
      <input type="hidden" name="status" value="0">
      @endcannot
      <input type="hidden" name="user_id" value="@if(\auth::user()) {{ \auth::user()->id }}@endif ">
      <input type="hidden" name="education" value="">
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection