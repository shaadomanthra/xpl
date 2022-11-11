@extends('layouts.app')
@section('title',' Colleges Edit')
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

      <div class="row">
        <div class="col-12 col-md-6">
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
          <div class="form-group">
        <label for="formGroupExampleInput ">College Zone</label>
        <input type="text" class="form-control" name="college_website" id="formGroupExampleInput" placeholder="Enter the college Zone" 
            @if($stub=='Create')
            value="{{ (old('college_website')) ? old('college_website') : '' }}"
            @else
            value = "{{ $obj->college_website }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">Type</label>
        <select class="form-control" name="type">
          <option value="degree" @if(isset($obj)) @if($obj->type=='degree') selected @endif @endif >Degree</option>
          <option value="degreepg" @if(isset($obj)) @if($obj->type=='degreepg') selected @endif @endif >Degree and PG</option>
          <option value="pg" @if(isset($obj)) @if($obj->type=='pg') selected @endif @endif >PG</option>
          <option value="btech" @if($stub=='Create') selected @endif @if(isset($obj)) @if($obj->type=='btech') selected @endif @endif >Btech</option>
          <option value="btechmtech" @if(isset($obj)) @if($obj->type=='btechmtech') selected @endif @endif >Btech and Mtech</option>

        </select>
      </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">College Code</label>
        <input type="text" class="form-control" name="college_code" id="formGroupExampleInput" placeholder="Enter the college_code" 
            @if($stub=='Create')
            value="{{ (old('college_code')) ? old('college_code') : '' }}"
            @else
            value = "{{ $obj->college_code }}"
            @endif
          >
      </div>
           <div class="form-group">
        <label for="formGroupExampleInput ">Location</label>
        <input type="text" class="form-control" name="location" id="formGroupExampleInput" placeholder="Enter the location" 
            @if($stub=='Create')
            value="{{ (old('location')) ? old('location') : '' }}"
            @else
            value = "{{ $obj->location }}"
            @endif
          >
      </div>
        </div>
      </div> 
      
      @if(isset($branches))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Branches</label><br>
        @foreach($branches as $branch)
        <input  type="checkbox" name="branches[]" value="{{$branch->id}}" 
              @if($stub!='Create')
                  @if(in_array($branch->id, $obj->branches()->pluck('id')->toArray()))
                  checked
                  @endif
              @else
                  @if(in_array($branch->id, [9,10,11,12,13,14,15]))
                  checked
                  @endif 
              @endif
            > {{ $branch->name }} &nbsp;&nbsp;
        @endforeach

      </div>
      @endif

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <button type="submit" class="btn btn-lg btn-primary">Save</button>
    </form>
    </div>
  </div>
@endsection