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

      <div class="form-group">
        <label for="formGroupExampleInput ">Image</label>
        <input type="text" class="form-control" name="image" id="formGroupExampleInput" placeholder="Enter the Image URL" 
            @if($stub=='Create')
            value="{{ (old('image')) ? old('image') : '' }}"
            @else
            value = "{{ $obj->image }}"
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

      @if(isset($zones))
      <div class="form-group">
        <label for="formGroupExampleInput ">Zone</label>
        <select class="form-control" name="zone_id">
          @foreach($zones as $z)
          <option value="{{$z->id}}" @if($obj->zones()->first()) @if($z->id == $obj->zones->first()->id ) selected @endif @endif >{{ $z->name }}</option>
          @endforeach         
        </select>
      </div>
      @endif

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

      <div class="form-group">
        <label for="formGroupExampleInput ">Courses</label>
        <div class="border p-2">
          <div class="row">
        @foreach($courses as $a=>$course)
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="courses[]" value="{{$course->id}}"
              @if($stub=='Create')
                @if(old('course'))
                  @if(in_array($course->id,old('course')))
                  checked
                  @endif
                @endif
              @else
                @if($obj->courses)
                  @if(in_array($course->id,$obj->courses->pluck('id')->toArray()))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$course->name }}
          </div>
        @endforeach
        </div>
        </div>
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

      <div class="form-group">
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Code</label>
        <input type="text" class="form-control" name="college_code" id="formGroupExampleInput" placeholder="Enter the college_code" 
            @if($stub=='Create')
            value="{{ (old('college_code')) ? old('college_code') : '' }}"
            @else
            value = "{{ $obj->college_code }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Principal Name</label>
        <input type="text" class="form-control" name="principal_name" id="formGroupExampleInput" placeholder="Enter the Principal Name" 
            @if($stub=='Create')
            value="{{ (old('principal_name')) ? old('principal_name') : '' }}"
            @else
            value = "{{ $obj->principal_name }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">obj Phone</label>
        <input type="text" class="form-control" name="college_phone" id="formGroupExampleInput" placeholder="Enter the obj Phone" 
            @if($stub=='Create')
            value="{{ (old('college_phone')) ? old('college_phone') : '' }}"
            @else
            value = "{{ $obj->college_phone }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">obj Email</label>
        <input type="text" class="form-control" name="college_email" id="formGroupExampleInput" placeholder="Enter the obj Email" 
            @if($stub=='Create')
            value="{{ (old('college_email')) ? old('college_email') : '' }}"
            @else
            value = "{{ $obj->college_email }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">obj Website</label>
        <input type="text" class="form-control" name="college_website" id="formGroupExampleInput" placeholder="Enter the obj Website" 
            @if($stub=='Create')
            value="{{ (old('college_website')) ? old('college_website') : '' }}"
            @else
            value = "{{ $obj->college_website }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">TPO Name</label>
        <input type="text" class="form-control" name="tpo_name" id="formGroupExampleInput" placeholder="Enter the TPO Name" 
            @if($stub=='Create')
            value="{{ (old('tpo_name')) ? old('tpo_name') : '' }}"
            @else
            value = "{{ $obj->tpo_name }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">TPO Email</label>
        <input type="text" class="form-control" name="tpo_email" id="formGroupExampleInput" placeholder="Enter the TPO Email" 
            @if($stub=='Create')
            value="{{ (old('tpo_email')) ? old('tpo_email') : '' }}"
            @else
            value = "{{ $obj->tpo_email }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">TPO Email 2</label>
        <input type="text" class="form-control" name="tpo_email_2" id="formGroupExampleInput" placeholder="Enter the TPO Second Email " 
            @if($stub=='Create')
            value="{{ (old('tpo_email_2')) ? old('tpo_email_2') : '' }}"
            @else
            value = "{{ $obj->tpo_email_2 }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">TPO Phone</label>
        <input type="text" class="form-control" name="tpo_phone" id="formGroupExampleInput" placeholder="Enter the TPO Phone " 
            @if($stub=='Create')
            value="{{ (old('tpo_phone')) ? old('tpo_phone') : '' }}"
            @else
            value = "{{ $obj->tpo_phone }}"
            @endif
          >
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