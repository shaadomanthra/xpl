@extends('layouts.app')
@section('content')

@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  

    <div class="card bg-light mb-3">
      <div class="card-body">
        <h1 class="mt-1"><i class="fa fas fa-camera-retro"></i> Social Media ({{$socials->total()}})
          @can('create',$social)
            <a href="{{route('media.create')}}" class="float-right">
              <button type="button" class="btn btn-sm btn-outline-success my-0 my-sm-0 mr-1"><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </h1>
        
      </div>
    </div>

        @if($socials->total()!=0)
        <div class="table-responsive ">
          <table class="table table-bordered bg-white">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Schedule</th>
                <th scope="col">Content</th>
                
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($socials as $key=>$social)  
              <tr>
                <th scope="row">{{ $socials->currentpage() ? ($socials->currentpage()-1) * $socials->perpage() + ( $key + 1) : $key+1 }}</th>
                 <td>
                  {{ \carbon\carbon::parse($social->schedule)->format('M d Y') }}
                </td>
                <td>
                   @if($social->network==1)
                    <b>Facebook</b>
                  @elseif($social->network == 2)
                    <b>Instagram</b>
                  @else
                    <b>Twitter  </b>
                  @endif

                  <a href=" {{ route('media.edit',$social->id) }} ">
                  <i class="fa fa-pencil"></i></a><br>
                    @if(trim($social->image)!= '&nbsp;')
                  <img src="{{ route('root').'/'.$social->image }}" width="100px"/>  
                  
                  @endif 
                  {!! $social->content !!}
                  
                </td>
                
                 
                <td>
                  @if($social->status==0)
                    Draft
                  @elseif($social->status ==1)
                    Preview
                  @elseif($social->status ==2)
                    Final
                  @elseif($social->status ==3)
                    Published
                   @endif     
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body  mb-3">
          No Items listed
        </div>
        @endif
        <nav aria-label="Page navigation example">
        {{$socials->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>


     

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.social.snippets.menu')
    </div>
</div>
@endsection


