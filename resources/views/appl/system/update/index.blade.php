@extends('layouts.app')
@section('content')


@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">

    @include('flash::message')  
    <div class="card mb-3">
      <div class="card-body ">
        <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bullhorn"></i> Updates </a>
          @can('create',$update)
            <a href="{{route('update.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 "><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </nav>

        <div id="search-items">
          @if($updates->total()!=0)
            @foreach($updates as $key=>$update)  
            <div class="row">
              <div class="col-3">
                <a href="{{ route('profile','@'.\auth::user()->getUsername($update->user_id))}}">{{ \auth::user()->getName($update->user_id)}}</a><br>
                <div>{{ \auth::user()->getDesignation($update->user_id)}}</div>
                <small>{{ $update->updated_at->diffForHumans() }}</small>
              </div>
              <div class="col-9">
                @if($update->type==2)
                <div class=" p-3" style="background:rgb(226, 243, 255);border-radius: 5px;">
                <div class="text-"><h2><i class="fa fa-trophy"></i> Milestone</h2></div>
                @endif
                {!! $update->content !!}


                @can('edit',$update)
                  <button class="btn btn-sm btn-outline-secondary" disabled>
                  @if($update->status==0)
                  Draft
                  @else
                  Published
                  @endif
                  </button>
                  <a href="{{ route('update.edit',$update->id) }}">
                  <button class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i> edit</button>
                  </a>
                 
                @endcan

                @if($update->type==2)
                </div>
                @endif
              </div>
            </div>
             @if($key != $updates->total()-1)
              <hr>
              @endif
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Updates listed
          </div>
          @endif
          <nav aria-label="Page navigation example">
            {{$updates->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>

      </div>
    </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>



@endsection


