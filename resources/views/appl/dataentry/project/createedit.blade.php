@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1>
        @if($stub=='Create')
          Create Project
        @else
          Update Project
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('dataentry.store')}}" >
      @else
      <form method="post" action="{{route('dataentry.update',$project->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Project Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Project Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $project->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Project Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $project->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id_data_manager" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Data Lead</label>
        <select class="form-control" name="user_id_data_lead">
          <option value=""  >None</option>
          @if(isset($users['data_lead']))
          @foreach($users['data_lead'] as $user)
          <option value="{{ $user->id }}" @if(isset($project)) @if($project->user_id_data_lead== $user->id) selected @endif @endif >{{ $user->name }}</option>
          @endforeach
          @endif
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Feeder</label>
        <select class="form-control" name="user_id_feeder">
          <option value=""  >None</option>
          @if(isset($users['feeder']))
          @foreach($users['feeder'] as $user)
          <option value="{{ $user->id }}" @if(isset($project)) @if($project->user_id_feeder== $user->id) selected @endif @endif >{{ $user->name }}</option>
          @endforeach
          @endif
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Proof Reader</label>
        <select class="form-control" name="user_id_proof_reader">
          <option value=""  >None</option>
          @if(isset($users['proof_reader']))
          @foreach($users['proof_reader'] as $user)
          <option value="{{ $user->id }}" @if(isset($project)) @if($project->user_id_proof_reader== $user->id) selected @endif @endif >{{ $user->name }}</option>
          @endforeach
          @endif
        </select>
      </div>

      

      <div class="form-group">
        <label for="formGroupExampleInput ">Target</label>
      <input type="text" class="form-control" name="target"   value="{{isset($project->target)? \carbon\carbon::parse($project->target)->format('Y-m-d'):''}}" id="datepicker">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($project)) @if($project->status==0) selected @endif @endif >In Progress</option>
          <option value="1" @if(isset($project)) @if($project->status==1) selected @endif @endif >Completed</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection