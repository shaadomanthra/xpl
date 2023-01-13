@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')
@section('content')



<div class="container mt-4">



@if(auth::user() && subdomain()=='packetprep')
     @if($user->status!=0)
<div class="rounded p-3 mb-3" style="background: #caf7dd; border:1px solid #39c072;">
  <a href="{{ route('activation')}}">
<button class="btn btn-success float-right mt-md-2">Validate Now</button>
</a>
  <h4 class="">Validate your account</h4>
<p class="mb-0">Your account has not been validated yet. You are only a few steps away from complete access to our platform.</p>

</div>
@endif
    @endif
<div class="row">
  <div class="col-12 col-md-9 ">
<div class="p-0 mb-3"  style="border:1px solid #8ec5d4;box-shadow: 2px 2px 2px 1px #e2e6e7"  >
  <div class="p-2 "   style="background: #bee0e9;"> </div>
<div class="  p-3  pt-4"  style="background: #d6eef3;" >




  <div class="row ">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-3">
        <div class="col-12 col-md-3">

          
          <img class="img-thumbnail rounded-circle mb-3 d-none d-md-block" src="@if(\auth::user()->getImage()) {{ (\auth::user()->getImage())}}@else {{ Gravatar::src(\auth::user()->email, 150) }}@endif">
        </div>
        <div class="col-12 col-md-9">

          <h2>Hi, {{  \auth::user()->name}}</h2>

          <a href="https://learn.packetprep.com/user/mydetails" class="btn btn-success my-3"> edit batch details</a>
           <a href="https://learn.packetprep.com/profile" class="btn btn-primary my-3"> update profile</a>
      <p> 
        
        @if(auth::user()->branch_id)
          @if(isset($data['branches'][auth::user()->branch_id])) <span class="badge badge-primary"> {{ $data['branches'][auth::user()->branch_id]->name}}</span>@else Welcome aboard @endif
        @else
          @if(auth::user()->info) <span class="badge badge-primary">Batch - {{auth::user()->info}}</span>@else Welcome aboard!@endif
        @endif
      </p>
      
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>

        </div>


      </div>

      @else

      @endif

    </div>
    
    
  </div>
</div>
</div>

<div class=" rounded p-3 my-3" style="border:1px solid red; background: pink;">
  <h3> Get <span class="badge badge-light">FREE</span> material worth Rs.7000  <img src="https://i.imgur.com/2z3tA1h.gif" style="width: 35px"/> </h3>
  <p> Refer 3 friends and get access to 300+ video lessons on aptitude, reasoning, and programming.</p>
  <a href="/sreferral" class="btn btn-danger"> Referral Program</a>
  </div>

@if(isset(request()->session()->get('client')->slug))
@if(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_banner.png'))
<img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_banner.png')}}" class=" w-100 mb-3" />
@elseif(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_banner.jpg'))
<img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_banner.jpg')}}" class=" w-100 mb-3" />
@endif
@endif

@if(request()->session()->get('settings'))
@if(request()->session()->get('settings')->message_d)
<div class="alert alert-warning alert-important mt-3  border border-warning">
  <div class=" h5 mt-2">{!! request()->session()->get('settings')->message_d !!}</div>
  @if(request()->session()->get('settings')->timer_d)
  <p id="d" class="my-2 text-danger blink countdown_timer" data-timer="{{request()->session()->get('settings')->timer_d}}"></p>
  @endif
</div>
@endif
@endif


@if(count(\auth::user()->newtests())!=0)
  <div class="row ">
              
                @foreach(\auth::user()->newtests() as $k=>$e)
                
                @if($e->examtype->name == 'General' || $e->examtype->name==auth::user()->info || auth::user()->authorizedEmail($e))
                @if($e->status!=0 && !$e->active)
                @if(!\auth::user()->attempted($e->id))
                       <div class="col-12 col-md-6">
        <div class="mb-4 cardbox">
          <div class="lblue " style="border-radius:5px;">
          <div class=" bg-white p-4  " style='border-radius: 5px;'>
          <div class="row">
            <div class='col-2 col-md-3'>
              @if(isset($e->image))
                @if(Storage::disk('s3')->exists($e->image))
                <div class=" text-center">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url($e->image) }} " class="d-print-none w-100" alt="{{  $e->name }}" style='max-width:80px;'>
                  </picture>
                </div>
                @endif
              @else
              <div class="text-center text-secondary">
                <i class="fa fa-newspaper-o fa-4x p-1 d-none d-md-block" aria-hidden="true"></i>
                <i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
              </div>
              @endif
            </div>
            <div class='col-8 col-md-6'>
              <h4 class="mb-1 mt-2 lh15">
                <a href=" {{ route('assessment.details',$e->slug) }} ">
                @if($e->status==0)
                <i class="fa fa-square-o"></i> 
                @elseif($e->status==1)
                  <i class="fa fa-globe"></i> 
                @else
                  <i class="fa fa-lock"></i> 
                @endif  
                  {{ $e->name }}
                </a>

              </h4>
              <div>
                  @if($e->active==1)
                <span class=" badge badge-secondary">Inactive</span>
                @else
                  <span class=" badge badge-success">Active</span>
                @endif
              </div>
              
            </div>
            <div class='col-2 col-md-3'>
              <div class="heading_one float-right f30">
                <a href="{{ route('assessment.details',$e->slug)}}" class='btn btn-outline-primary btn-sm'>
                  <i class="fa fa-paper-plane"></i>
                  Try Now
                </a>
              </div>
            </div>

          </div>
        </div>
        
        </div>
    </div>
              </div>
                @endif
                @endif
                @endif
                @endforeach
            </div>


@endif


@if(count(\auth::user()->tests())!=0)
  <div class="rounded table-responsive ">
            <table class="table table-bordered {{$i=0}}">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">My Tests </th>
                  <th scope="col">Score</th>
                  <th scope="col">Attempted</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach(\auth::user()->tests() as $k=>$test)
                 <tr>
                  <th scope="row">{{ $i=$i+1}}</th>
                  <td>
                    <a href="{{ route('assessment.analysis',$test->slug) }}">{{$test->name}}</a>
                  </td>

                  <td>

                    @if(!$test->attempt_status)
                      @if($test->solutions==2 || $test->solutions==4 )
                      <span class="badge badge-secondary">private</span>
                      @elseif($test->slug!='psychometric-test')
                      {{$test->score}} @if(env('APP_NAME')!='Gradable')/ {{$test->max}} @endif
                      @else
                      -
                      @endif
                    @else
                     -
                    @endif
                  </td>
                  <td>{{date('d M Y', strtotime($test->attempt_at))}}</td>
                  <td> 
                      @if(!$test->attempt_status)
                      <span class="badge badge-success">Completed</span>
                      @else
                      <span class="badge badge-warning">Under Review</span>
                      @endif
                    
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
  
        @endif




 @if(count(auth::user()->myproducts())!=0)
  <div class="rounded table-responsive ">
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Products</th>
                  <th scope="col">Type</th>
                  <th scope="col">Valid till</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach(auth::user()->myproducts() as $k=>$product)
                 <tr>
                  <th scope="row">{{ $k+1}}</th>
                  <td>
                    <a href="{{ route('productpage',$product->slug) }}">{{$product->name}}</a><br>
                    @foreach($product->courses as $c)
                         <i class="fa fa-angle-right"></i>  <a href="{{ route('course.show',$c->slug)}}">{{$c->name}}</a> <span class="badge badge-primary">course</span><br>
                    @endforeach
                    @foreach($product->exams as $e)
                         <i class="fa fa-angle-right"></i> <a href="{{ route('assessment.details',$e->slug)}}">{{$e->name}}</a> 
                          @if($t=$mytests->where('test_id',$e->id)->first())
                          
                          @endif <br>
                    @endforeach
                  </td>
                  <td>
                    @if($product->price==0)
                      <span class="badge badge-warning">Free</span>
                      @else
                      <span class="badge badge-info">Premium</span>
                      @endif
                  </td>
                  <td>{{date('d M Y', strtotime($product->pivot->valid_till))}}</td>
                  <td> 
                    @if(strtotime($product->pivot->valid_till) > strtotime(date('Y-m-d')))
                      @if($product->pivot->status==1)
                      <span class="badge badge-success">Active</span>
                      @else
                      <span class="badge badge-secondary">Disabled</span>
                      @endif
                    @else
                        <span class="badge badge-danger">Expired</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>

        @endif

  


  </div>

  <div class="col-12 col-md-3">

    <div class="rounded p-3 mb-2" style="background: #f7eaca; border:1px solid #e2ca8f;">
 
  <h3 class="">Java Fullstack Course</h3>
<p class="mb-1"> <a href="https://learn.packetprep.com/course/java-programming" class="btn btn-warning mt-3 mb-0"><b>View Course</b> </a>  </p>

</div>

<div class="rounded p-3 mb-2" style="background: #f7dcca; border:1px solid #e7c5af;">
 
  <h3 class="">Aptitude & Reasoning Material</h3>
<p class="mb-1"><a href="https://learn.packetprep.com/productpage/grandmaster" class="btn btn-primary mt-2 mb-0"><b>View Product</b> </a>  </p>

</div>

    <a href="https://packetprep.com/contact?utm_source=packetprep_learn&utm_medium=website"><img src="/img/pp2.png" class="mt-2 mt-md-0 w-100 rounded" /></a>

     <div class="bg-white  p-3 p-md-4 mb-3 mb-md-4 mt-3" style="background-image:url(https://packetprep.com/img/corner-4.png);background-position: right;background-repeat: no-repeat; border-radius:8px;box-shadow: 2px 2px 2px 2px #eee;background-size: auto;">
      <div class="heading mb-4">
        <a href="https://www.youtube.com/packetprep">
        <h3 class="jost  text-danger" > <i class="fa fa-youtube-play"></i> Youtube </h3></a>

      </div>
      <p>Subscribe to our <b> youtube channel</b> to access free learning content.</p>
      <a href="https://www.youtube.com/packetprep">
      <p class="mb-0 btn btn-danger"><b>Subscribe Now</b></p>
    </a>

    </div>
  </div>

  
</div>

</div>
@endsection           