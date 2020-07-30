@extends('layouts.nowrap-white')
@section('title', $obj->title)
@section('content')

@include('appl.exam.exam.xp_css')


<div class="dblue" >
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">
        <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('post.index')}}">Job posts</a></li>
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-chevron-circle-right "></i> {{ $obj->title }}</p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Applicants</div>
          <div class="h2" ><a href="{{ route('job.applicants',$obj->slug)}}" >{{$obj->users->count()}}</a></div>
        </div>
      </div>
    </div>
  </div>

<div class='p-3 mb-3 ddblue' >
  <div class='container'>
    <a href="{{route('job.show',$obj->slug)}}" class="f20 text-white" > <i class="fa fa-external-link" ></i> {{route('job.show',$obj->slug)}}</a>&nbsp; @if($obj->status!=1)
                <span class="badge badge-secondary">Draft</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif
          @can('update',$obj)
            <span class="btn-group float-md-right btn-group-sm mt-2 mt-md-0" role="group" aria-label="Basic example">
              <a href="{{ route('post.edit',$obj->slug) }}" class="btn btn-outline-light" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i> edit</a>
              
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
              

              <div class="float-md-right mb-3">
              
              @if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.jpg'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.jpg') }} " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @elseif(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.png'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.png') }} " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @else
              <div class="text-center">
                <i class="fa fa-file-image-o fa-5x p-1 d-none d-md-block" aria-hidden="true"></i>
                <i class="fa fa-file-image-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
              </div>
              @endif
            </div>

            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Details </h4>
              {!! $obj->details !!}

              </div>


            
          <h4 class="mb-3"><i class="fa fa-angle-right"></i> Info </h4>
          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-map-marker"></i>&nbsp; Locations</div>
            <div class="col-6">{{str_replace(',',', ',$obj->location)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-university"></i>&nbsp; Education</div>
            <div class="col-6">{{str_replace(',',', ',$obj->education)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calendar"></i>&nbsp; Year of passing</div>
            <div class="col-6">{{str_replace(',',', ',$obj->yop)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-graduation-cap"></i>&nbsp; Academics</div>
            <div class="col-6">{{$obj->academic}} & above</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-flickr"></i>&nbsp; Salary</div>
            <div class="col-6">{{$obj->salary}} </div>
          </div>

          

          

            </div>
            </div>
        </div>
      </div>

        <div class="card mb-3">
    <div class="card-header">Banner Image</div>
        <div class="card-body">
      @if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.png'))
              <img src="{{ Storage::disk('s3')->url('post/job_b_'.$obj->slug.'.png') }}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('post.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @elseif(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.jpg'))
              <img src="{{ Storage::disk('s3')->url('post/job_b_'.$obj->slug.'.jpg') }}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('post.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm mt-3"> delete banner</a></div>
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              @endif
            </div>
  </div>

    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <a href="{{route('job.analytics',$obj->slug)}}"><div class="border p-3 rounded my-2 h4 lblue">
          <i class="fa fa-bar-chart"> Analytics</i>
        </div>
      </a>
         <div class="h4 mt-3 mb-4" ><i class="fa fa-angle-right"></i> Latest applicants <small><span class="text-secondary">({{$obj->users->count()}})</span></small><a href="{{ route('job.applicants',$obj->slug)}}" class="btn btn-outline-primary btn-sm float-md-right mt-3 mt-md-0">View all</a></div>

        
      @foreach($obj->users()->orderBy('pivot_created_at','desc')->get() as $k=>$u )
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
            <div class="d-inline pill" ><i class="fa fa-graduation-cap"></i> {{$u->bachelors}}%</div>
            @if($u->branch_id)
            <div class="d-inline pill" ><i class="fa fa-tablet"></i> {{$branches[$u->branch_id]->name}}</div>@endif
           
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


@endsection