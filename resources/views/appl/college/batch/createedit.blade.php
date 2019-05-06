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
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
       
      </div>
      <div class="form-group   border">
        <div for="formGroupExampleInput " class="mb-3 bg-light p-3 border-bottom">Select Image</div>
        
        <div class="row p-3">
          @for($i=1;$i<=10;$i++)
          <div class="col-12 col-md-2 mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="image" id="exampleRadios1" value="{{$i}}" @if($obj->image==$i) checked @endif>
              <label class="form-check-label" for="exampleRadios1">
                <img src="{{ asset('/img/batch/'.$i.'.png')}}" width="30px">
              </label>
            </div>
          </div>
          @endfor
        </div>
       
      </div>
      
      

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="college_id" value="{{ $obj->college_id }}">
        <input type="hidden" name="slug" value="{{ $obj->slug }}">
        <input type="hidden" name="code" value="{{ $obj->code }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection