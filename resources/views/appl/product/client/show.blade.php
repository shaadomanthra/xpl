@extends('layouts.app')
@section('title', $client->name)
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
              
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          
          

          
          <div class="row mb-2">
            <div class="col-md-4">
              <h3>Site Admin</h3>
            </div>
            <div class="col-md-8">
              <h3>
              @if($client->site_admin())
              <a href="{{ route('admin.user.view',$client->site_admin()->username) }}">
              {{ $client->site_admin()->name }}
              </a>
              @else
                - Not Assigned -
              @endif
            </h3>
            </div>
          </div>
         

         

           <div class="row mb-2">
            <div class="col-md-4">Website URL</div>
            <div class="col-md-8">
              <a href="http://{{$client->slug}}.xplore.co.in"><span class="badge badge-warning">{{$client->slug}}.xplore.co.in</span></a>
            </div>
          </div>


          <div class="row mb-2">
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
          <!--
          <div class="row mb-0">
            <div class="col-md-4">Courses </div>
            <div class="col-md-8">
              @if(count($client->courses))
              @foreach($client->courses as $course)
              <div class="">{{$course->name}}</div>
              @endforeach
              @else
              <span> --</span>
              @endif
              
            </div>
          </div>

          <div class="row mb-0">
            <div class="col-md-4">Package</div>
            <div class="col-md-8">
              
            </div>
          </div>
          <div class="row mb-0">
            <div class="col-md-4">Credits Usage</div>
            <div class="col-md-8">
              
            </div>
          </div>
        -->

          

          


         
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12 col-md-6">
          <div class="card">
            <div class='card-header'>Users</div>
             <div class='card-body '>
              <div class="row">
                <div class="col-12 col-md-4"><h5>Total</h5><div class="display-3">{{$users['users_all']}}</div></div>
                <div class="col-12 col-md-4"><h5>This month</h5><div class="display-3">{{$users['users_thismonth']}}</div></div>
                <div class="col-12 col-md-4"><h5>Last month</h5><div class="display-3">{{$users['users_lastmonth']}}</div></div>
              </div>

            </div>
          </div>
        </div>
         <div class="col ">
          <div class="card">
            <div class='card-header'>Tests Attempted</div>
             <div class='card-body '>
               <div class="row">
                <div class="col-12 col-md-4"><h5>Total</h5><div class="display-3">{{$attempts['attempts_all']}}</div></div>
                <div class="col-12 col-md-4"><h5>This month</h5><div class="display-3">{{$attempts['attempts_thismonth']}}</div></div>
                <div class="col-12 col-md-4"><h5>Last month</h5><div class="display-3">{{$attempts['attempts_lastmonth']}}</div></div>
              </div>
             </div>
          </div>
        </div>
       
      </div>
      

<div class="row">

  <div class="col-12 col-md-4">
      <div class="card mb-4">
        <div class="card-header">Logo Upload</div>
        <div class="card-body">
          
          <div class="row">

            
            <div class="col-12">
              @if(Storage::disk('s3')->exists('companies/'.$client->slug.'.png'))
              <img src="{{ Storage::disk('s3')->url('companies/'.$client->slug.'.png')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('client.show',$client->slug)}}?delete=logo" class="btn btn-danger btn-sm mt-3"> delete logo</a></div>
              @elseif(Storage::disk('s3')->exists('companies/'.$client->slug.'.jpg'))
              <img src="{{ Storage::disk('s3')->url('companies/'.$client->slug.'.jpg')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('client.show',$client->slug)}}?delete=logo" class="btn btn-danger btn-sm mt-3"> delete logo</a></div>
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              @endif
            </div>
            <div class="col-12">
              <div class="bg-light p-3 rounded border mt-3">
              <form method="post" action="{{route('client.image')}}" enctype="multipart/form-data">
            <input type="hidden" name="client_slug" value="{{ $client->slug}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input class="mb-3" type="file"
               id="avatar" name="input_img"
               accept="image/png, image/jpeg" /><br>
           <button type="submit" class="btn btn-outline-info btn-sm ">Save</button>
         </form>
       </div>
            </div>
          </div>
          
        </div>
      </div>
</div>
<div class="col-12 col-md-4">
      <div class="card mb-4">
        <div class="card-header">Login Page Banner</div>
        <div class="card-body">
      @if(Storage::disk('s3')->exists('companies/'.$client->slug.'_header.png'))
              <img src="{{Storage::disk('s3')->url('companies/'.$client->slug.'_header.png')}}?time={{microtime()}}" class=" w-100 mb-3" />
              <div><a href="{{ route('client.show',$client->slug)}}?delete=header" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @elseif(Storage::disk('s3')->exists('companies/'.$client->slug.'_header.jpg'))
              <img src="{{ Storage::disk('s3')->url('companies/'.$client->slug.'_header.jpg')}}?time={{microtime()}}" class=" w-100" />
              <div><a href="{{ route('client.show',$client->slug)}}?delete=header" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              @endif
            </div>
        </div>
</div>
<div class="Col-12 col-md-4">
        <div class="card mb-4">
        <div class="card-header">Dashboard Banner Image</div>
        <div class="card-body">
      @if(Storage::disk('s3')->exists('companies/'.$client->slug.'_banner.png'))
              <img src="{{ Storage::disk('s3')->url('companies/'.$client->slug.'_banner.png')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('client.show',$client->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @elseif(Storage::disk('s3')->exists('companies/'.$client->slug.'_banner.jpg'))
              <img src="{{ Storage::disk('s3')->url('companies/'.$client->slug.'_banner.jpg')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('client.show',$client->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
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