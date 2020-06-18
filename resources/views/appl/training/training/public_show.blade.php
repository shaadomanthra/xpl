@extends('layouts.nowrap-white')
@section('title', $obj->name)
@section('content')

@include('appl.exam.exam.xp_css')

<script src="{{ asset('js/pdf.js')}}"></script>

<style>
.pdfobject-container { height: 30rem; border: 1px solid rgba(0,0,0,.2); }
</style>
<div class="banner">
  @if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.png'))
  <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.png')}}?time={{microtime()}}" class=" w-100" />
  @elseif(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.jpg'))
  <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.jpg')}}?time={{microtime()}}" class=" w-100" />
  @else
  <div class="p-5" style="background: #8ec6f9"></div>

  @endif
</div>
<div class="bg-light">
<div class="container ">
  <div class="row">
    <div class="col-12 col-md-9">
      <div class="bg-white mb-2 mb-md-5 p-4 p-md-5" style="margin-top:-50px">
        <div class="float-right pb-4 pl-4">
          @if(Storage::disk('public')->exists('articles/job_'.$obj->slug.'.jpg'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/job_'.$obj->slug.'.jpg') }} " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @elseif(Storage::disk('public')->exists('articles/job_'.$obj->slug.'.png'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/job_'.$obj->slug.'.png') }} " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @endif
            </div>
        <h1 class="mb-4">{{$obj->name}}</h1>
        @include('flash::message')
        <div class="">
          
        {!!$obj->details !!}

        </div>
      </div>


      @foreach($obj->schedules as $s)
      <div class="row mb-4">
        <div class="col-2">
          <div class="alert alert-warning alert-important text-center " role="alert"><span class="h5">{{\carbon\carbon::parse($s->day)->format('M')}}</span>
            <div class="display-3 d-inline">{{\carbon\carbon::parse($s->day)->format('d')}}</div></div>
        </div>
        <div class="col-10">
          <div class="bg-white rounded" style="box-shadow: 1px 1px 1px 1px #eee;">
            <div class="card-body pt-4">
              
              <h4 class="mb-0">{{$s->name}}</h4>
              <p>{!! $s->details !!}</p>
              
            </div>
            <div class="p-3" style="background: #f8f8f8;border-radius:0px 5px 5px 0px;">
            @foreach($s->resources as $r)
                      <span class="block_item mb-0 " data-id="{{$r->id}}" style="cursor: pointer">
  @if($r->type=='youtube_video_link')
    <i class="fa fa-file-video-o"></i> 
  @elseif($r->type=='ppt_link')
    <i class="fa fa-file-powerpoint-o"></i> 
  @elseif($r->type=='audio_link')
    <i class="fa fa-file-audio-o"></i> 
  @elseif($r->type=='test_link')
    <i class="fa fa-file-code-o"></i> 
  @else
    <i class="fa fa-file-pdf-o"></i> 
  @endif

  {{$r->name}}</span>
  
                      @include('appl.training.schedule.embed')
                    @endforeach

          </div>
          </div>
          
        </div>

      </div>
      @endforeach

    </div>
    <div class="col-12 col-md-3">
      <div class="mt-4">
      <div class="alert alert-success alert-important" role="alert">
        <h5>Trainer </h5>
        <div class="display-5 h3">{{$obj->trainer->name}}</div>
      </div>
    
    <div class="alert alert-info alert-important" role="alert">
      <h5 class="">College Representative </h5>
      <div class="display-5 h3">Suresh Kumar</div>
    </div>

    </div>

    <div class="mt-4 mb-5" style="word-wrap: break-word;">
      <h3 class="mb-3">Participants({{$obj->users->count()}})</h3>
      <div class="row mb-2 no-gutters">
        @foreach($obj->users as $k=>$u)
            <div class="col-3"><img src="@if($u->getImage()) {{ ($u->getImage())}}@else {{ Gravatar::src($u->email, 150) }}@endif" class="img-cirlce border w-100 mb-2" data-toggle="tooltip" title="{{$u->name}}"/></div>
        @if($k>18)
          @break
        @endif
        @endforeach
      </div>

         
    </div>
    </div>
  </div>

</div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      {{
          request()->session()->put('redirect.url',url()->current())
      }}
      
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-success">Login</button>
      </a>
      <a href="{{ route('student.eregister')}}">
        <button type="button" class="btn btn-primary">Register</button>
      </a>
      </div>
    </div>
  </div>
</div>
@endsection