@extends('layouts.corporate-body')
@section('content')

@include('appl.product.snippets.breadcrumbs')
@include('flash::message')

  <div class="row">

    <div class="col-md-12">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $client->name }} 

          @can('update',$client)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('client.edit',$client->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('clientuser.index',$client->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Users"><i class="fa fa-user"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          @if($client->user_id_creator)
          <div class="row mb-2">
            <div class="col-md-4">
              <h1>Creator</h1>
            </div>
            <div class="col-md-8">
              <h1>
              <a href="{{ route('profile','@'.auth::user()->getUserName($client->user_id_creator)) }}">
              {{ auth::user()->getName($client->user_id_creator) }}
              </a>
            </h1>
            </div>
          </div>
          @endif
          @if($client->user_id_owner)
          <div class="row mb-2">
            <div class="col-md-4">
              <h3>Owner</h3>
            </div>
            <div class="col-md-8">
              <h3>
              <a href="{{ route('profile','@'.auth::user()->getUserName($client->user_id_owner)) }}">
              {{ auth::user()->getName($client->user_id_owner) }}
              </a>
            </h3>
            </div>
          </div>
          @endif

          @if($client->user_id_manager)
          <div class="row mb-2">
            <div class="col-md-4">
              <h3>Manager</h3>
            </div>
            <div class="col-md-8">
              <h3>
              <a href="{{ route('profile','@'.auth::user()->getUserName($client->user_id_manager)) }}">
              {{ auth::user()->getName($client->user_id_manager) }}
              </a>
            </h3>
            </div>
          </div>
          @endif

         



          <div class="row mb-0">
            <div class="col-md-4">Website Status</div>
            <div class="col-md-8">
              @if($client->status==0)
                <span class="badge badge-secondary">Unpublished</span>
              @elseif($client->status==1)
                <span class="badge badge-success">Published</span>
              @elseif($client->status==2)
                <span class="badge badge-warning">Request Hold</span>
              @else
                <span class="badge badge-danger">Terminated</span>
              @endif
            </div>
          </div>

          

          


         
        </div>
      </div>

      

      <div class="card mb-4">

        <div class="card-body">
          <div class="card-title"><h1 class="mb-4">Logo Upload</h1></div>
          <div class="row">

            <div class="col-6">
              <form method="post" action="{{route('client.image')}}" enctype="multipart/form-data">
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


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('client.destroy',$client->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection