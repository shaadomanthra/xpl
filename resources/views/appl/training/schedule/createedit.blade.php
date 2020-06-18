@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Schedule
        @else
          Update Schedule
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store',[$app->training->slug])}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',[$app->training->slug,$obj->id])}}" enctype="multipart/form-data">
      @endif  

      <div class='row'>
      <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="formGroupExampleInput ">name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
      </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="form-group">
        <label for="formGroupExampleInput ">Sno</label>
        <input type="text" class="form-control" name="sno" id="formGroupExampleInput" placeholder="Enter the sno" 
            @if($stub=='Create')
            value="{{ (old('sno')) ? old('sno') : '' }}"
            @else
            value = "{{ $obj->sno }}"
            @endif
          >
      </div>
      
    </div>

    </div>

    
        
    
      

      <div class="form-group ">
        <label for="formGroupExampleInput ">Details</label><textarea class="form-control summernote" name="details"  rows="5">@if($stub=='Create'){{ (old('details')) ? old('details') : '' }}@else {{ $obj->details }} @endif</textarea>
      </div>


     
    

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Day</label>
      <input type="text" class="form-control" name="day"   value="{{isset($obj->day)? \carbon\carbon::parse($obj->day)->format('Y-m-d'):''}}" id="datepicker">
      </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
        </select>
      </div>

        </div>

      </div>
   
      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ \auth::user()->id }}">
        <input type="hidden" name="training_id" value="{{ $app->training->id }}">
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection