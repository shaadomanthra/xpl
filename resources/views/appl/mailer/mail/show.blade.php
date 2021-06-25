@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route($app->module.'.index') }}">{{ ucfirst($app->module) }}</a></li>
    <li class="breadcrumb-item">{{ $obj->name }}</li>
  </ol>
</nav>

@include('flash::message')

 <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-th "></i> {{ $obj->name }} 

          @can('update',$obj)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->id) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{route('mail.show',$obj->id)}}?sendmail=1" class="btn btn-outline-secondary"  >
                <i class="fa fa-paper-plane"></i> Queue 
              </a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>
  <div class="row">

    <div class="col-12 col-md-8">
     

     
      <div class="card mb-4">
        <div class="card-body">
          <div class=""><b>Subject:</b> {{$obj->subject}}</div>
          <hr>
          <p>Hi <b>@if(isset($user['name'])){{$user['name']}} @else Candidate @endif</b>,</p>
                        <p>Greetings!</p>
          {!!$obj->message !!}

            <p>regards,<br>Xplore Team </p><br>
                       
                        <p >Join our Telegram group <a href="https://bit.ly/xplorejobstelegram">Xplore Jobs</a> for latest updates on job openings</p>
         

         

          

        </div>
      </div>

    </div>

    <div class="col-12 col-md-4">
      <div class="card mt-4 mt-md-0">
        <div class="card-body">
          <h3>Status</h3>
          <hr>
           <div class="row mb-2">
            <div class="col-6">Queued</div>
            @if(isset($logs[0]))
            <div class="col-6">{{ (count($logs[0]))}} / {{count($emails)}}</div>
            @else
            <div class="col-6"> 0 </div>
            @endif
          </div>
           

           <div class="row mb-2">
            <div class="col-6">Sent</div>
            @if(isset($logs[1]))
            <div class="col-6">{{ (count($logs[1]) + count($logs[2]))}} / {{count($emails)}}</div>
            @else
            <div class="col-6"> 0 </div>
            @endif
          </div>

           <div class="row mb-2">
            <div class="col-6">Delivered</div>
            @if(isset($logs[2]))
            <div class="col-6">{{ (count($logs[2]))}}</div>
            @else
            <div class="col-6"> 0 </div>
            @endif
          </div>

          <div class="row mb-2">
            <div class="col-6">Failed</div>
            @if(isset($logs[1]))
            <div class="col-6">{{ (count($logs[1]) - count($logs[2]))}}</div>
            @else
            <div class="col-6"> 0 </div>
            @endif
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header" ><h1>Emails ({{count($emails)}})</h1></div>
        <div class="card-body" style="height:300px;text;overflow: scroll;">
          @foreach($emails as $e)
          {{$e}}<br>
            @endforeach
          
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
        
        <form method="post" action="{{route($app->module.'.destroy',$obj->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection