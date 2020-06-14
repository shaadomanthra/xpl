@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Job Post
        @else
          Update Job Post
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->slug)}}" enctype="multipart/form-data">
      @endif  

      <div class='row'>
      <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="formGroupExampleInput ">Job post title</label>
        <input type="text" class="form-control" name="title" id="formGroupExampleInput" placeholder="Enter the title" 
            @if($stub=='Create')
            value="{{ (old('title')) ? old('title') : '' }}"
            @else
            value = "{{ $obj->title }}"
            @endif
          >
      </div>
      </div>

      <div class="col-12 col-md-6">

          <div class="form-group">
        <label for="formGroupExampleInput ">Job Slug (unique identifier)</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput" placeholder="Enter unique identifier" 
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : $slug }}"
            @else
            value = "{{ $obj->slug }}"
            @endif
          >
          <small class="text-secondary">https://{{ $_SERVER['HTTP_HOST'].'/job/{slug}'}}</small>

          
      </div>
    </div>

    </div>

    <div class='row'>
      <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="formGroupExampleInput ">Logo </label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
          <small class="text-secondary">Kindly use only .jpg or .png</small>
      </div>
      </div>

      <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="formGroupExampleInput ">Banner image </label>
        <input type="file" class="form-control" name="file2_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
          <small class="text-secondary">Kindly use only .jpg or .png</small>
      </div>
      </div>

    </div>
        
    
      

      <div class="form-group ">
        <label for="formGroupExampleInput ">Details</label><textarea class="form-control summernote" name="details"  rows="5">@if($stub=='Create'){{ (old('details')) ? old('details') : '' }}@else {{ $obj->details }} @endif</textarea>
      </div>


      <div class="form-group">
        
        <div class="border rounded">
          <div class="bg-light p-3 border-bottom rounded">
            <label class="mb-0"><b>Location</b></label>
          <label class="mb-0 float-right">
              <input type="checkbox" class="check" id="checkAll" data-name="location"> Check All &nbsp;&nbsp;
            </label>
          </div>
          <div class="row p-3">
          @foreach($app->location as $a=>$location)
          <div class="col-12 col-md-4">
            <input  class="location" type="checkbox" name="locations[]" value="{{$location}}"
              @if($stub=='Create')
                @if(old('location'))
                  @if(in_array($app->location,old('location')))
                  checked
                  @endif
                @endif
              @else
                @if($obj->location)
                  @if(in_array($location,explode(',',$obj->location)))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$location }}
          </div>
        @endforeach
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        
        <div class="border rounded">
          <div class="bg-light p-3 border-bottom rounded">
            <label class="mb-0"><b>Education</b></label>
          <label class="mb-0 float-right">
              <input type="checkbox" class="check" id="checkAll" data-name="education"> Check All &nbsp;&nbsp;
            </label>
          </div>
          <div class="row p-3">
          @foreach($app->education as $a=>$location)
          <div class="col-12 col-md-3">
            <input class="education" type="checkbox" name="educations[]" value="{{$location}}"
              @if($stub=='Create')
                @if(old('location'))
                  @if(in_array($app->education,old('location')))
                  checked
                  @endif
                @endif
              @else
                @if($obj->location)
                  @if(in_array($location,explode(',',$obj->education)))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$location }}
          </div>
        @endforeach
          </div>
        </div>
      </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
        <div class="border rounded">
          <div class="bg-light p-3 border-bottom rounded">
            <label class="mb-0"><b>Year of passing</b></label>
          <label class="mb-0 float-right">
              <input type="checkbox" class="check" id="checkAll" data-name="yop"> Check All &nbsp;&nbsp;
            </label>
          </div>
          <div class="row p-3">
          @foreach($app->yop as $a=>$location)
          <div class="col-12 col-md-4">
            <input  class="yop" type="checkbox" name="yops[]" value="{{$location}}"
              @if($stub=='Create')
                @if(old('location'))
                  @if(in_array($app->yop,old('location')))
                  checked
                  @endif
                @endif
              @else
                @if($obj->location)
                  @if(in_array($location,explode(',',$obj->yop)))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$location }}
          </div>
        @endforeach
          </div>
        </div>
      </div>

        </div>
        
      </div>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Academics</label>
        <select class="form-control" name="academic">
          @foreach($app->academic as $s)
          <option value="{{$s}}" @if(isset($obj)) @if($obj->academic==$s) selected @endif @endif >{{$s}}</option>

          @endforeach
        </select>
      </div>
        </div>
        <div class="col-12 col-md-6">

          <div class="form-group">
        <label for="formGroupExampleInput ">Salary</label>
        <select class="form-control" name="salary">
          @foreach($app->salary as $s)
          <option value="{{$s}}" @if(isset($obj)) @if($obj->salary==$s) selected @endif @endif >{{$s}}</option>

          @endforeach
        </select>
      </div>

        </div>
        
      </div>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Last Date for Application</label>
      <input type="text" class="form-control" name="last_date"   value="{{isset($obj->last_date)? \carbon\carbon::parse($obj->last_date)->format('Y-m-d'):''}}" id="datepicker">
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
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection