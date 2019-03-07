@extends('layouts.app')
@section('title', 'Blog | PacketPrep')
@section('description', 'Get connected to packetprep updates through out blogs')
@section('keywords', 'college,packetprep,campus connect, blog')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Blog</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-12 col-md-9">
    @include('flash::message')  

    

        <div id="search-items" class=" ">
          @if($blogs->total()!=0)
            @foreach($blogs as $key=>$blog)  

            @if($blog->image !=' ')
            <a href="{{ route('blog.show',$blog->slug) }}">
            <img src="{{ route('root').'/'.$blog->image}}" width="100%">
            </a>
            @endif

            <div class="mb-3" style="background:white">
            <div class="card-body p-4">

            <div class="row">
              <div class="col-9">
                
                <div >
    
                <a href="{{ route('blog.show',$blog->slug) }}">
                <h1 class="text-primary">{{ $blog->title}}</h1>
              </a>
                {!! $blog->intro !!}
                
                <a href="{{ route('blog.show',$blog->slug) }}">
                <button class="btn btn-outline-primary">readmore </button>
                </a>
                </div>

              

              </div>
              <div class="col-3">
                      <a href="{{ route('profile','@'.$blog->getUsername($blog->user_id_writer))}}">{{ $blog->getName($blog->user_id_writer)}}</a><br>
                <small>{{ $blog->updated_at->diffForHumans() }}</small><br>
                @can('edit',$blog)  
                <a href="{{ route('blog.edit',$blog->id) }}">
                <i class="fa fa-edit"></i> edit
                </a>
                @endcan
              </div>
            </div>

             </div>
            </div>
             
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Items listed
          </div>
          @endif
          <div class="mt-4">
          <nav aria-label="Page navigation example">
            {{$blogs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>
        </div>

     

  </div>

  <div class="col-12 col-md-3">

    @if(\auth::user())
    @if(\auth::user()->isAdmin())
    <div class="card bg-light mb-3">
      <div class="card-body">
        <h1 class="mt-1"><i class="fa fas fa-align-justify"></i> Blog 
          @can('create',$blog)
            <a href="{{route('blog.create')}}" class="float-right">
              <button type="button" class="btn btn-sm btn-outline-success my-0 my-sm-0 mr-1"><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </h1>
        
      </div>
    </div>
    @endif
    @endif

    <a href="{{ route('ambassador')}}">
      <img src="{{ asset('/img/campus_ambassador.jpg')}}" class="w-100 mb-3"/> 
    </a> 
    <a href="{{ route('course.show','interview-skills') }}">
      <img src="{{ asset('/img/gd.jpg')}}" class="w-100 mb-3"/> 
    </a> 
    </div>
</div>
@endsection


