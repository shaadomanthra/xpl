@extends('layouts.app')
@section('title', $chapter->title.' | PacketPrep')

@section('description', $chapter->description )

@section('keywords', $chapter->keywords)

@section('content')

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('docs.index')}}">Tracks</a></li>
      <li class="breadcrumb-item "><a href="{{ route('docs.show',$doc->slug)}}">{{ $doc->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Order Chapters</li>
    </ol>
  </nav>
  @include('flash::message')

  <div class="row">
  
    <div class="col-12 col-md-9">
      <div class="card  mb-3">


      

      @can('update',$chapter)
      <div class="card">
        <div class="card-body">
          <h3>Siblings </h3>
          <div id="sortlist" data-value="">
            @if($list)
            {!!$list!!}
            @else
            <span class="text-muted"><i class="fa fa-exclamation-circle"></i> No Siblings </span> 
            @endif
          </div>
          
          
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              
              
               @if($list) 
              <a href="{{ route('chapter.move',$doc->slug).'?order=up' }}" class="btn btn-outline-info" data-tooltip="tooltip" data-placement="top" title="Move Up"
                ><i class="fa fa-arrow-up"></i></a>
              <a href="{{ route('chapter.move',$doc->slug).'?order=down' }}" class="btn btn-outline-info" data-tooltip="tooltip" data-placement="top" title="Move Down"><i class="fa fa-arrow-down"></i></a>
               @endif
             
            </span>
        </div>
      </div>
      @endcan

    </div>

  </div> 


@endsection