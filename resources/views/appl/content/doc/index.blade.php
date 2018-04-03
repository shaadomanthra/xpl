@extends('layouts.app')
@section('content')

<div  class="row ">

  <div class="col">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Docs</li>
      </ol>
    </nav>
    @include('flash::message')  
    <div class="card">
      <div class="card-body pb-1">
        <nav class="navbar navbar-light bg-light justify-content-between p-3 border mb-3">
          <a class="navbar-brand"><i class="fa fa-book"></i> Documentation </a>

          <form class="form-inline" method="GET" action="{{ route('docs.index') }}">
            <a href="{{route('docs.create')}}">

              @can('create',$doc)
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3"><i class="fa fa-plus"></i> New</button>
              @endcan
            </a>
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" data-url="{{Request::url()}}" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

        <div id="search-items">
         @include('appl.content.doc.list')
       </div>

     </div>
   </div>
 </div>
</div>

@endsection


