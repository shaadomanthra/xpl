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
      <form method="post" action="{{route('client.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('client.update',$client->id)}}" enctype="multipart/form-data">
      @endif  

      <div class="row">
        <div class="col-12 col-md-6">

        </div>
        <div class="col-12 col-md-6">

        </div>
      </div>
       <div class="row">
        <div class="col-12 col-md-6">
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

        </div>
        <div class="col-12 col-md-6">
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

        </div>
      </div>
      
     

      <div class="form-group">
        <label for="formGroupExampleInput">Contact Details</label>
         <textarea  class="form-control summernote" name="contact"  rows="5">
            @if($stub=='Create')
            {{ (old('contact')) ? old('contact') : '' }}
            @else
            {{ $client->contact }}
            @endif
        </textarea>
      </div>

      @if($stub=='Create')
      <div class="bg-light border p-3 rounded my-3">
        <h4>Admin User (Optional)</h4>
        <hr>
        <div class="row">
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="formGroupExampleInput ">Name</label>
              <input type="text" class="form-control" name="admin_name" id="formGroupExampleInput" placeholder="Enter Name" 
                @if($stub=='Create')
                value="{{ (old('admin_name')) ? old('admin_name') : '' }}"
                @endif
              >
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="formGroupExampleInput ">Email</label>
              <input type="text" class="form-control" name="admin_email" id="formGroupExampleInput" placeholder="Enter email" 
                @if($stub=='Create')
                value="{{ (old('admin_email')) ? old('admin_email') : '' }}"
                @endif
              >
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="formGroupExampleInput ">Phone</label>
              <input type="text" class="form-control" name="admin_phone" id="formGroupExampleInput" placeholder="Enter phone" 
                @if($stub=='Create')
                value="{{ (old('admin_phone')) ? old('admin_phone') : '' }}"
                @endif
              >
            </div>
          </div>
        </div>
        <hr>
        <span class="badge badge-warning">Note</span> A demo user with email demo500@gmail and password demo500 is auto generated for the above client.
      </div>

      

      @endif

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Loginpage Image</label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
      </div>

        </div>
        <div class="col-12 col-md-6">
           <div class="form-group">
        <label for="formGroupExampleInput ">Dashboard Banner Image</label>
        <input type="file" class="form-control" name="file2_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
      </div>

        </div>
      </div>

      <div class="border p-3 bg-light">
        <h3><i class="fa fa-th"></i> Settings</h3>
        <hr>
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Register Button</label>
            <select class="form-control" name="register">
              <option value="0" @if(isset($client)) @if($client->settings->register==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->register==1) selected @endif @endif >Enabled</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Change Password</label>
            <select class="form-control" name="change_password">
              <option value="0" @if(isset($client)) @if($client->settings->change_password==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->change_password==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Add Users</label>
            <select class="form-control" name="add_users">
              <option value="0" @if(isset($client)) @if($client->settings->add_users==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->add_users==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Add Tests</label>
            <select class="form-control" name="add_tests">
              <option value="0" @if(isset($client)) @if($client->settings->add_tests==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->add_tests==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-3">
           <div class="form-group">
            <label for="formGroupExampleInput ">Camera</label>
            <select class="form-control" name="camera">
              <option value="0" @if(isset($client)) @if($client->settings->camera==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->camera==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
        <div class="col-12 col-md-3">
           <div class="form-group">
            <label for="formGroupExampleInput ">Face Detection</label>
            <select class="form-control" name="face_detection">
              <option value="0" @if(isset($client)) @if($client->settings->face_detection==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->face_detection==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
            <label for="formGroupExampleInput ">Proctoring</label>
            <select class="form-control" name="proctoring">
              <option value="0" @if(isset($client)) @if($client->settings->proctoring==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->proctoring==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
        <div class="col-12 col-md-3">
           <div class="form-group">
            <label for="formGroupExampleInput ">Set Creator</label>
            <select class="form-control" name="set_creator">
              <option value="0" @if(isset($client)) @if($client->settings->set_creator==0) selected @endif @endif >Disabled</option>
              <option value="1" @if(isset($client)) @if($client->settings->set_creator==1) selected @endif @endif >Enabled</option>
            </select>
          </div>

        </div>
      </div>

        <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput">Message in Dashboard</label>
             <textarea  class="form-control summernote" name="message_d"  rows="5">
                @if($stub=='Create')
                {{ (old('message_d')) ? old('message_d') : '' }}
                @else
                {{ $client->settings->message_d }}
                @endif
            </textarea>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput ">Dashboard Countdown timer</label>
            <input id="datetimepicker" class="form-control" type="text" value="{{isset($client->settings->timer_d)? $client->settings->timer_d:''}}"  name="timer_d"></input>
          </div>

            <div class="form-group">
            <label for="formGroupExampleInput ">Instamojo Key</label>
            <input class="form-control" type="text" value="{{isset($client->settings->key)? $client->settings->key:''}}"  name="key"></input>
          </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput">Message in Loginpage</label>
             <textarea  class="form-control summernote" name="message_l"  rows="5">
                @if($stub=='Create')
                {{ (old('message_l')) ? old('message_l') : '' }}
                @else
                {{ $client->settings->message_l }}
                @endif
            </textarea>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput ">Loginpage Countdown timer</label>
            <input id="datetimepicker2" class="form-control" type="text" value="{{isset($client->settings->timer_l)? $client->settings->timer_l:''}}"  name="timer_l"></input>
          </div>

            <div class="form-group">
            <label for="formGroupExampleInput ">Instamojo Token</label>
            <input class="form-control" type="text" value="{{isset($client->settings->token)? $client->settings->token:''}}"  name="token"></input>
          </div>


        </div>


    </div>
    <div class="row">
          <div class="col-12">
          <div class="form-group">
            <label for="formGroupExampleInput ">Exams slugs (for consolidated performance reports)</label>
            <input id="datetimepicker2" class="form-control" type="text" value="{{isset($client->settings->exams)? $client->settings->exams:''}}"  name="exams"></input>
          </div>
        </div>
        </div>
      
    </div>

  

      

      
      <div class="form-group mt-4">
        <label for="formGroupExampleInput">Products</label>
         <div class=" card p-3">
          <div class="row">
          @foreach($products as $product)
          @if($product->status==1)
          <div class="col-12 col-md-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="product[]" value="{{$product->id}}" id="defaultCheck1" @if($client->products->contains($product->id))) checked @endif>
            <label class="form-check-label" for="defaultCheck1">
              {{ $product->name }}
            </label>
          </div>
        </div>
          @endif
          @endforeach
          </div>
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