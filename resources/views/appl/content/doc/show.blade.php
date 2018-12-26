@extends('layouts.app')
@section('title', $doc->name.' | PacketPrep')

@section('description', 'Packetpreps '.$doc->name.' will help you prepare for campus placements with ease' )

@section('keywords', $keywords)

@section('content')

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('docs.index')}}">Tracks</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $doc->name }}</li>
    </ol>
  </nav>
  @include('flash::message')

  <div class="row">

    <div class="col-12 col-md-3">



     <div class="bg-white border mb-3 rounded">
              <div class="">
                @if($doc->image)
                <div class="bg-white ">
                  <img src="{{ $doc->image }}" class="w-100"/>
                </div>
                @endif
                <div class=" p-3" style="background: #fff">
                  <h1>{{ $doc->name }}</h1>

              </div>
              </div>
          </div>

   

    </div>
    <div class="col-12 col-md-9">
      <div class="card  mb-3">


        <div class="card-body ">
  
        <nav class="navbar navbar-light bg-light justify-content-between p-3 border mb-3">
          <a class="navbar-brand"> {{ $doc->name }}</a>
          <span class="btn-group float-right" role="group" aria-label="Basic example">
             @can('create',$doc)
              <a href="{{ route('chapter.create',$doc->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Add"><i class="fa fa-plus"></i> Chapter</a>
              <a href="{{ route('docs.edit',$doc->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              @endcan
            </span>
        </nav>

        @if($chapters)
        <div class="dd">
        {!! $chapters !!}
        </div>
        @else
        No Chapters defined !
        @endif
        </div>
      </div>

      <div class=" border p-4 rounded mb-3">
        @include('appl.pages.disqus')
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
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        
        This following action will delete the node as well as all the child nodes to it and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('docs.destroy',$doc->slug)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection