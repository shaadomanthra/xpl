@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item">Image Upload</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        
        <nav class="navbar navbar-light bg-light justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-image"></i> Image Upload </a>

        </nav>

        <div class="card mb-3">
      <div class="card-body">
      
         <div class="row">

            <div class="col-6">
              <form method="post" action="{{route('admin.image')}}" enctype="multipart/form-data">
            <input type="hidden" name="client_slug" value="{{ $client->slug}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input class="mb-3" type="file"
               id="avatar" name="input_img"
               accept="image/png, image/jpeg" /><br>
           <button type="submit" class="btn btn-info">Save</button>
         </form>
            </div>
            <div class="col-6">
              @if(file_exists(public_path().'/img/clients/'.$client->slug.'.png'))
              <img src="{{ asset('/img/clients/'.$client->slug.'.png')}}" class="float-right" />
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              
              @endif
            </div>
          </div>
  
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

