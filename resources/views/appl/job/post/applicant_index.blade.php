@extends('layouts.nowrap-white')
@section('title', 'Applicants - '.$obj->title)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Job post</a></li>
            <li class="breadcrumb-item"><a href="{{ route('post.show',$obj->slug) }}">{{$obj->title}}</a></li>
            <li class="breadcrumb-item">Applicants </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> Applicants ({{$app->total}})
            <a href="#" data-toggle="modal" class="btn btn-info" data-target="#upload"  >
          Upload
        </a>
          </p>

        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
        
        
        <div class="dropdown float-right">
  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Download
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="{{ route('job.applicants',$obj->slug)}}?export=1">Data</a><hr>
    <a class="dropdown-item" href="{{ route('job.applicants',$obj->slug)}}?export=1&resume=1">Data + Resume Link <br>(more processing time) </a>
  </div>
</div>
        

          <form class="form-inline mr-3 " method="GET" action="{{ route('job.applicants',$obj->slug) }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
          

         
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>



@include('flash::message')
<div class="container">
    <div class="alert alert-important alert-info mt-3">
      Data is cached for faster access. Refresh Cache to load the updated data. 
      <a href="{{request()->url()}}?refresh=1">
      <span class="float-right"><i class="fa fa-retweet"></i> Refresh Now</span>
      </a>
    </div>
    <div class="row my-3">
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class=" p-3 rounded" style="background: #fff;border:1px solid #d7d1e8">
          <h5>Open Applicants</h5>
          <div class="display-3"><a href="{{ route('job.applicants',$obj->slug)}}">{{$app->none}}</a></div>
           
        </div>
      </div>
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="p-3 rounded" style="background: #f6fff7;border:1px solid #c9e2cc">
          <h5 class="text-success"><i class="fa fa-check-circle"></i> Shortlisted (YES)</h5>
          <div class="display-3"><a href="{{ route('job.applicants',$obj->slug)}}?filter=1&shortlisted=YES">{{$app->yes}}</a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3 ">
        <div class=" p-3 rounded " style="background: #fffdf6;border:1px solid #ece8d5">
          <h5 class="text-warning"><i class="fa fa-ban"></i> Shortlisted (MAYBE)</h5>
          <div class="display-3"><a href="{{ route('job.applicants',$obj->slug)}}?filter=1&shortlisted=MAYBE">{{$app->maybe}}</a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3 ">
        <div class=" p-3 rounded" style="background: #fff6f6;border:1px solid #efd7d7" >
          <h5 class="text-danger"><i class="fa fa-times-circle"></i> Shortlisted (NO)</h5>
          <div class="display-3"><a href="{{ route('job.applicants',$obj->slug)}}?filter=1&shortlisted=NO">{{$app->no}}</a>
          </div>
        </div>
      </div>
  </div>

@if(count($conditions))
  <div class="p-3 rounded border bg-light">

    <div class="float-right" style="margin-top:-7px;">

    @foreach($conditions as $c=>$v)
      <a href="{{ route('job.applicants',$obj->slug)}}?profile={{$c}}" class="btn btn-outline-primary">{{ ucwords(str_replace('_',' ',$c))}} <span class="badge badge-primary">{{ $v['count']}}</span></a>

    @endforeach
  </div>
  <div class=""><b>AI Profile Filters:</b> {{$filter}}</div>

  </div>
@endif
  <div  class="row  mb-4 mt-4">
    <div class="col-12 ">
    <div id="search-items">
    @include('appl.job.post.applicant_list')
    </div>
  </div>

  </div>
</div>
@endsection


<div class="modal fade bd-example-modal-lg" id="upload"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog ">
    <form action="{{ route('job.applicants',$obj->slug) }}" method="post" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header h4">
        Upload CSV File
      </div>
      <div class="modal-body">
        <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="upload" value="1">
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
       
          <button type="submit" class="btn btn-primary">Upload</button>
     
      </div>
    </div>
    </form>
  </div>
</div>


<div class="modal fade " id="exampleModalO1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        sample body
      </div>  

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade " id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="" id="">
        <div class="p-3 loading">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>  
        </div> Loading...
        
        </div>
        <div id="user_data">
      </div>

      <div id="user_tools" class="user_tools p-3" style="background: #fff3d7;border-top:1px solid #f5e6c4;display:none">
        <h5>Recruiter Tools</h5>
        <hr>
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Add Profile Score</label>
              <input type="text" class="form-control" id="score" placeholder="Enter the score">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Shortlisted</label>
              <select  class="form-control" id="shortlisted">
              <option value=""> - </option>
              <option value="YES">YES</option>
              <option value="NO">NO</option>
              <option value ="MAY BE">MAY BE</option>
            </select>
            </div>
          </div>
          <small>The following changes will be reflected in the excel download</small>
        </form>

        <button type="button" class="btn btn-success mt-3 tools_save" data-user_id="" data-token="{{ csrf_token() }}" data-post_id="{{$obj->id}}" data-url="{{ route('update.applicant')}}">Save</button>
        <div class="spinner-border2" role="status" style="display:none">
          <span class="sr-only">Loading...</span>  
        </div> 


      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

