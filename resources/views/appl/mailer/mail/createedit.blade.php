@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create {{ $app->module }}
        @else
          Update {{ $app->module }}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" >
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Event Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Reference Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
      </div>

    
      

      <div class="form-group">
        <label for="formGroupExampleInput2">Subject</label>
        <input type="text" class="form-control" name="subject" id="formGroupExampleInput2" placeholder="Enter the mail subject"
            @if($stub=='Create')
            value="{{ (old('subject')) ? old('subject') : '' }}"
            @else
            value = "{{ $obj->subject }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Message</label>
         <textarea class="form-control summernote" name="message"  rows="20">{{isset($obj)?$obj->message:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Emails</label>
         <textarea class="form-control" name="emails"  rows="10">{{isset($obj)?$obj->emails:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Inactive</option>
          <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
        </select>
      </div>

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection