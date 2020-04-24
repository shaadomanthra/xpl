@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')
@section('content')


<div class="container mt-4">


<div class="row">
  <div class="col-12 ">
<div class="p-0 mb-4" style="border:1px solid #eee;box-shadow: 2px 2px 2px 1px #e7e7e7">
  <div class="p-2 bg-light"> </div>
<div class="  p-3 pt-5 bg-white" >


  <div class="row ">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-3">


          <img class="img-thumbnail rounded-circle mb-3" src="@if(\auth::user()->image) {{ (\auth::user()->image)}}@else {{ Gravatar::src(\auth::user()->email, 150) }}@endif">
        </div>
        <div class="col-12 col-md-9">

          <h2>Hi, {{  \auth::user()->name}}</h2>
      <p> Welcome aboard</p>

      <p class="lead">Develop a passion for learning. If you do, you will never cease to grow - 
            Anthony J Dangelo</p>



    <a href="{{ route('profile','@'.\auth::user()->username)}}" class="btn btn-primary">Profile</a>
      <a class="btn border border-success text-success " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>

            <br><br>

        
            

        </div>


      </div>


            
             
      
      @else

      @endif

    </div>
    
    <div class="col-12 col-md-3  ">
      <div class="float-right ">
                <img src="{{ asset('/img/student_front.png')}}" class="w-100 p-3 pt-0"/>
                
      </div>
    </div>
  </div>
</div>
</div>

@if(count(\auth::user()->newtests())!=0)
  <div class="row ">
            
                @foreach(\auth::user()->newtests() as $k=>$e)
                @if(!\auth::user()->attempted($e->id))
                       <div class="col-12 col-md-6">
        <div class="mb-4 cardbox">
          <div class="lblue " style="border-radius:5px;">
          <div class=" bg-white p-4  " style='border-radius: 5px;'>
          <div class="row">
            <div class='col-2 col-md-3'>
              @if(isset($e->image))
                @if(Storage::disk('public')->exists($e->image))
                <div class=" text-center">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/'.$e->image) }} " class="d-print-none w-100" alt="{{  $e->name }}" style='max-width:80px;'>
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
                <a href=" {{ route('exam.show',$e->slug) }} ">
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
                @endforeach
            </div>


@endif


@if(count(\auth::user()->tests())!=0)
  <div class="rounded table-responsive ">
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">My Tests</th>
                  <th scope="col">Score</th>
                  <th scope="col">Attempted</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach(\auth::user()->tests() as $k=>$test)
                 <tr>
                  <th scope="row">{{ $k+1}}</th>
                  <td>
                    <a href="{{ route('assessment.details',$test->slug) }}">{{$test->name}}</a>
                  </td>
                  <td>
                    @if(!$test->attempt_status)
                    @if($test->slug!='psychometric-test')
                    {{$test->score}} / {{$test->max}}
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
                      <span class="badge badge-success">Active</span>
                      @else
                      <span class="badge badge-warning">Processing</span>
                      @endif
                    
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
  
        @endif



  @if(count(auth::user()->products)!=0)
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
                @foreach(auth::user()->products as $k=>$product)
                 <tr>
                  <th scope="row">{{ $k+1}}</th>
                  <td>
                    <a href="{{ route('productpage',$product->slug) }}">{{$product->name}}</a>
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