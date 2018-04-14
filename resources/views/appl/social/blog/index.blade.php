@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  

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

        <div id="search-items" class=" ">
          @if($blogs->total()!=0)
            @foreach($blogs as $key=>$blog)  

            @if($blog->image !=' ')
            <img src="{{ route('root').'/'.$blog->image}}" width="100%">
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

  <div class="col-md-3 pl-md-0">
      @include('appl.social.snippets.menu')
    </div>
</div>
@endsection


