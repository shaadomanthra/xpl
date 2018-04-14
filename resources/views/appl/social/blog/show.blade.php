@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-12">
    @include('flash::message')  

            @if($blog->image !=' ')
            <img src="{{ route('root').'/'.$blog->image}}" width="100%">
            @endif

            <div class="mb-3" style="background:white">
            <div class="card-body p-4">

            <div class="row">
              <div class="col-9">
                
                <div >
    
                <h1 class="text-primary">{{ $blog->title}}</h1>
                {!! $blog->intro !!}

                {!! $blog->content !!}
                
                
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
                
          
  </div>

</div>
@endsection


