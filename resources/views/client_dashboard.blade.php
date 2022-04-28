@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')
@section('content')



<div class="container mt-4">

@include('flash::message')  
@if(auth::user() && subdomain()=='packetprep')
     @if($user->status!=0)
<div class="rounded p-4 mb-4" style="background: #caf7dd; border:1px solid #39c072;">
  <a href="{{ route('activation')}}">
<button class="btn btn-success float-right mt-md-2">Validate Now</button>
</a>
  <h4 class="">Validate your account</h4>
<p class="mb-0">Your account has not been validated yet. You are only a few steps away from complete access to our platform.</p>

</div>
@endif
    @endif
<div class="row">
  <div class="col-12 ">
<div class="p-0 mb-4" @if(env('APP_NAME')=='Gradable') style="border:1px solid #8ec5d4;box-shadow: 2px 2px 2px 1px #e2e6e7" @else style="border:1px solid #eee;box-shadow: 2px 2px 2px 1px #e7e7e7" @endif>
  <div class="p-2 " @if(env('APP_NAME')=='Gradable')  style="background: #bee0e9;" @else style="background: #eee;"@endif> </div>
<div class="  p-3 pt-5 " @if(env('APP_NAME')=='Gradable')  style="background: #d6eef3;" @else style="background: white;" @endif>




  <div class="row ">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-3">

          
          <img class="img-thumbnail rounded-circle mb-3 d-none d-md-block" src="@if(\auth::user()->getImage()) {{ (\auth::user()->getImage())}}@else {{ Gravatar::src(\auth::user()->email, 150) }}@endif">
        </div>
        <div class="col-12 col-md-9">

          <h2>Hi, {{  \auth::user()->name}}</h2>
      <p> 
        @if(auth::user()->roll_number)
        <span class="badge badge-warning">{{auth::user()->roll_number}}</span><br>
        @endif
        @if(auth::user()->branch_id)
          @if(isset($data['branches'][auth::user()->branch_id])) <span class="badge badge-primary"> {{ $data['branches'][auth::user()->branch_id]->name}}</span>@else Welcome aboard @endif
        @else
          @if(auth::user()->info) <span class="badge badge-primary">Class {{auth::user()->info}}</span>@else Welcome aboard @endif
        @endif
      </p>
      

      <p class="lead">Develop a passion for learning. If you do, you will never cease to grow - 
            Anthony J Dangelo</p>


   
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>

            <br><br>

        
            

        </div>


      </div>


            
             
      
      @else

      @endif

    </div>
    
    <div class="col-12 col-md-3  @if(env('APP_NAME')=='Gradable')  d-none @endif ">
      <div class="float-right ">
                <img src="{{ asset('/img/student_front.png')}}" class="w-100 p-3 pt-0"/>
                
      </div>
    </div>
  </div>
</div>
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

@if(subdomain()!='xplore')
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

  
</div>

</div>
@endsection           