@extends('layouts.app')
@section('title', $blog->title.'| PacketPrep')
@section('description', strip_tags($blog->intro).'')
@section('keywords', $blog->keywords )
@section('content')
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item "><a href="{{ url('/blog')}}">Blog</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $blog->title}}</li>
  </ol>
</nav>

<div  class="row ">
  <div class="col-md-9">

   
    @include('flash::message')  

            @if($blog->image !=' ')
            <img src="{{ $blog->image }}" width="100%">
            @endif

            <div class="mb-3" style="background:white">
            <div class="card-body p-4 ">

            <div class="row">
              <div class="col-12">
                
                <div >
    
                <h1 class="text-primary">{{ $blog->title}}</h1>
                {!! $blog->intro !!}

                {!! $blog->content !!}
                
                
                </div>

                <hr>
                <div class="">
                      <a href="{{ route('profile','@'.\auth::user()->getUsername($blog->user_id_writer))}}">{{ \auth::user()->getName($blog->user_id_writer)}}</a><br>
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
            </div>
            <div class=" mt-3 border p-4 rounded mb-3">
        @include('appl.pages.disqus')
      </div>
                
          
  </div>

  <div class="col-12 col-md-3">
    <a href="{{ route('ambassador')}}">
      <img src="{{ asset('/img/campus_ambassador.jpg')}}" class="w-100 mb-3"/> 
    </a> 
    <a href="{{ route('course.show','interview-skills') }}">
      <img src="{{ asset('/img/gd.jpg')}}" class="w-100 mb-3"/> 
    </a> 
    </div>

</div>
@endsection


