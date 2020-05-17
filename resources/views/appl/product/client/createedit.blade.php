@extends('layouts.app')
@section('content')

@include('appl.product.snippets.breadcrumbs')
@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        @if($stub=='Create')
          Create Client
        @else
          Update Client
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('client.store')}}" >
      @else
      <form method="post" action="{{route('client.update',$client->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Client Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the College Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $client->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Client Slug</label>
        @if($stub=='Create')
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $client->slug }}"
            @endif
          >
        @else
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $client->slug }}"
            @endif 
          disabled="true">
        <input type="hidden" class="form-control" name="slug"  value = "{{ $client->slug }}">

        @endif  

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id_creator" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput">Contact Details</label>
         <textarea  class="form-control summernote2" name="contact"  rows="5">
            @if($stub=='Create')
            {{ (old('contact')) ? old('contact') : '' }}
            @else
            {{ $client->contact }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput">Courses</label>
         <div class=" card p-3">
          @foreach($courses as $course)
          @if($course->status==1)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="course[]" value="{{$course->id}}" id="defaultCheck1" @if($client->courses->contains($course->id))) checked @endif>
            <label class="form-check-label" for="defaultCheck1">
              {{ $course->name }}
            </label>
          </div>
          @endif
          @endforeach
         </div>
      </div>



      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($client)) @if($client->status==0) selected @endif @endif >Unpublished</option>
          <option value="1" @if(isset($client)) @if($client->status==1) selected @endif @endif >Published</option>
          <option value="2" @if(isset($client)) @if($client->status==2) selected @endif @endif >Request Hold</option>
          <option value="3" @if(isset($client)) @if($client->status==3) selected @endif @endif >Terminated</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection