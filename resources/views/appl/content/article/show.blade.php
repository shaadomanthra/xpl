@extends('layouts.app')
@section('title', $obj->name.' | Xplore')
@section('description', substr(strip_tags($obj->description),0,200))
@section('keywords', $obj->keywords)
@section('image', asset('/storage/company/'.$obj->slug.'_1200.jpg'))
@section('content')
<div class="p-3 p-md-4 p-lg-5 bg-white company">
          
          @include('flash::message')



          <h1 class=""> {{ $obj->name }}  

          @if(\auth::user())
          @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','blog-writer','editor']))
          @if((\auth::user()->id == $obj->user_id) || \Auth::user()->checkRole(['administrator','editor']))
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              

              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endif
            @endif
          @endif

          </h1>
          @if(isset($obj->labels))
          <div class="mb-3" >
            <a href="{{ route('article.index')}}"><span class="badge badge-secondary">jobs</span></a>
          @foreach($obj->labels as $k=>$label)
          <a href="{{ route('blog.label',$label->slug)}}"><span class="badge  badge-warning  ">{{$label->name }}</span></a>
          @endforeach
          </div>
          @endif
        
          <div class="row">
            <div class="col-12 col-md-8">
              <div class="mb-4" style="word-wrap: break-word;">
                <div class="float-left pr-4 pb-4 pt-2" style="max-width:350px">
      @if(Storage::disk('s3')->exists($obj->image))
      <img src="{{ Storage::disk('s3')->url($obj->image) }} " class=" card-img-top" alt="{{  $obj->name }}" style="width:100%">
      @endif
                </div>
              {!! $obj->description !!}
            </div>
              <div class="" style="word-wrap: break-word;">
              {!! $obj->details !!}
            </div>

             @include('appl.content.article.blocks.link')
            

            </div>
            <div class="col-12 col-md-4 ">
              <div class="sticky-top pt-3">
                
              @if(isset($obj->related1))
              @if(count($obj->related1)!=0)
              <div class=" border rounded bg-secondary text-white mb-4 d-none d-md-block">
                  <h4 class="mb-0 p-3">Related Jobs</h4>
                 <div class="list-group ">
                @foreach($obj->related1 as $item)
                  @if($item->slug != $obj->slug)
                    <a href="{{ route('page',$item->slug)}}" class="list-group-item list-group-item-action list-group-item-light ">
                  {{ ucfirst($item->name) }}
                  </a>
                  @endif
                @endforeach 
              
                  </div>
                </div>
              @endif
              @endif

              @include('snippets.adsense')
              </div>
            </div>
          </div>

          @if($questions)
          @if(count($questions)!=0)
          <div class="">
            @include('appl.content.article.questions')
          </div>
          @endif
          @endif

          <div class="row">

            @if(isset($obj->related1))
              @if(count($obj->related1)!=0 && count($obj->related1)!=1)
              <div class="col-12">
              <div class=" border rounded bg-secondary text-white mb-4 d-block d-md-none">
                  <h4 class="mb-0 p-3">Related Blogs</h4>
                 <div class="list-group ">
                @foreach($obj->related1 as $item)
                  @if($item->slug != $obj->slug)
                  @if($item->status==1)
                    <a href="{{ route('page',$item->slug)}}" class="list-group-item list-group-item-action list-group-item-light ">
                  {{ ucfirst($item->name) }}
                  </a>
                  @endif
                  @endif
                @endforeach 
              
                  </div>
                </div>
              </div>
              @endif
              @endif
      
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
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route($app->module.'.destroy',$obj->slug)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="modal" tabindex="-1" id="myModal2"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php
          session()->put( 'redirect.url',request()->url());
      ?>
      <div class="modal-body">
        <p>Kindly Login to proceed further.</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-primary">Login</button>
        </a>
        <a href="{{ route('register.type')}}">
        <button type="button" class="btn btn-warning">Register</button>
        </a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection