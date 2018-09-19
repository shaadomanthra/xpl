@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-gear"></i> Settings </a>

        </nav>

        <div class="card">
    <div class="card-body">
      
      
      @if($stub=='Create')
      <form method="post" action="{{route('admin.settings')}}" >
      @else
      <form method="post" action="{{route('admin.settings')}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the College Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $client->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Unique URL</label>
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
        <label for="formGroupExampleInput"><b>Courses Published</b></label>
         <div class=" card p-3">
          @foreach($courses as $course)
          
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="course[]" value="{{$course->id}}" id="defaultCheck1" @if($course->getVisibility($client->id,$course->id)==1) checked @endif>
            <label class="form-check-label" for="defaultCheck1">
              {{ $course->name }}
            </label>
          </div>
          @endforeach
         </div>
      </div>

      


      <button type="submit" class="btn btn-lg btn-success">Save</button>
    </form>
    </div>
  </div>
        

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection

