@extends('layouts.nowrap-white')
@section('title', $obj->name)
@section('content')

@include('appl.exam.exam.xp_css')


<div class="dblue" >
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">
        <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('training.index')}}">Trainings</a></li>
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-chevron-circle-right "></i> {{ $obj->name }}</p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Participants</div>
          <div class="h2" ><a href="{{ route('training.students',$obj->slug)}}" >{{$obj->users->count()}}</a></div>
        </div>
      </div>
    </div>
  </div>

<div class='p-3 mb-3 ddblue' >
  <div class='container'>
    <a href="{{route('trainingpage.show',$obj->slug)}}" class="f20 text-white" > <i class="fa fa-external-link" ></i> {{route('trainingpage.show',$obj->slug)}}</a>&nbsp; @if($obj->status!=1)
                <span class="badge badge-secondary">Draft</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif
          @can('update',$obj)
            <span class="btn-group float-md-right btn-group-sm mt-2 mt-md-0" role="group" aria-label="Basic example">
              <a href="{{ route('training.edit',$obj->slug) }}" class="btn btn-outline-light" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i> edit</a>
              <a href="#" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal2" data-tooltip="tooltip" data-placement="top" title="Add" ><i class="fa fa-user"></i> Add Participants</a>
              <a href="#" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i> delete</a>
            </span>
            @endcan
    </div>
  </div>
</div>


<div class="container ">
  @include('flash::message')
  <div class="row mt-4">
    <div class="col-12 col-md-6 col-lg-8">
      <div class="card mb-4 ">
        <div class="card-body">
            <div class="row mb-2">
            
            <div class="col-12 ">
              <div class="pt-2 f18 mb-4 lh15" >
              

              
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Details </h4>
              {!! $obj->details !!}

              </div>


            
          <h4 class="mb-3"><i class="fa fa-angle-right"></i> Info </h4>
          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-user"></i>&nbsp; Trainer</div>
            <div class="col-6"><a href="{{route('profile','@'.$obj->trainer->username)}}">{{$obj->trainer->name}}</a></div>
          </div>

          

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-flickr"></i>&nbsp; Status</div>
            <div class="col-6">@if($obj->status==0)
                    <span class="badge badge-secondary">Draft</span>
                  @elseif($obj->status==1)
                    <span class="badge badge-success">Active</span>
                  @endif </div>
          </div>

          

          

            </div>
            </div>
        </div>
      </div>

        <div class="card mb-3">
    <div class="card-header">Banner Image</div>
        <div class="card-body">
      @if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.png'))
              <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.png')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('training.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @elseif(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.jpg'))
              <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.jpg')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('training.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              @endif
            </div>
  </div>

    </div>

    <div class="col-12 col-md-6 col-lg-4">

      <div class="row mb-4">
        <div class="col-6 col-md-6">
          <a href="{{ route('schedule.index',$obj->slug)}}">
          <div class="cardbox p-4 p-md-1 p-lg-4 text-center mb-4 ">
            <img src="{{ asset('img/icons/schedule.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Schedule</h4>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-6">
          <a href="{{ route('resource.index',$obj->slug)}}">
          <div class="cardbox p-4 p-md-1 p-lg-4 text-center mb-4">
            <img src="{{ asset('img/icons/resources.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Resources</h4>
            </div>
          </a>
        </div>
        
      </div>

         <div class="h4 mt-3 mb-4" ><i class="fa fa-angle-right"></i> Participants <small><span class="text-secondary">({{$obj->users->count()}})</span></small><a href="{{ route('training.students',$obj->slug)}}" class="btn btn-outline-primary btn-sm float-md-right mt-3 mt-md-0">View all</a></div>

      @foreach($obj->users as $k=>$u )
      <div class='cardbox lblue p-3 mb-3'>
        <div class="row">
          <div class='col-3 col-md-3 col-lg-3'>
            <img src="@if($u->getImage()) {{ ($u->getImage())}}@else {{ Gravatar::src($u->email, 150) }}@endif" class="img-cirlce " />
          </div>
          <div class='col-9 col-md-9 col-lg-9'>
            <div class="f18 mb-0">
              <a href="{{ route('profile','@'.$u->username) }}"><b>{{$u->name}}</b></a>
            </div>
            <div class="d-inline pill" ><i class="fa fa-calendar"></i>  {{$u->year_of_passing}}</div>
            @if($u->branch)
            <div class="d-inline pill" ><i class="fa fa-tablet"></i> {{$u->branch->name}}</div>@endif
           
          </div>
        </div>
      </div>
      @if($k==5)
        @break
      @endif
      @endforeach
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
        
        <form method="post" action="{{route('post.destroy',$obj->slug)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{route('participant_import',$obj->slug)}}" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Participants</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput ">Excel File </label>
        <input type="file" class="form-control" name="users" id="formGroupExampleInput" placeholder="Enter the  path" 
          >
          <small class="text-secondary">Kindly use only .xlsx format</small>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="slug" value="{{ $obj->slug }}">
        <button type="submit" class="btn btn-primary">Upload Excel</button>
        
      </div>
      </form>
    </div>
  </div>
</div>



@endsection