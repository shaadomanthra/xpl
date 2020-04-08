@extends('layouts.nowrap-product')

@section('title', 'Dashboard | Xplore')

@section('description', 'Know you xplore products and services here.')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')


<div class="container mt-4">

@if(\auth::user()->services->first())
@if(\auth::user()->services->first()->pivot->status==0)
  <div class="border p-4 mb-4">
    <div class="row">
      <div class="col-12 col-md-6">
        <h1>Activate your Paid Services</h1>
    <form method="post" action="{{route('product.activate')}}" >
      <p>Collect your Product Activation code from your college administrative office / Placement Office</p>
      <div class="form-group">
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter Activation Code" >
      </div>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" value="{{ auth::user()->id }}">

      <button type="submit" class="btn btn-primary">Submit</button>
      
    </form>
        
      </div>
      <div class="col-12 col-md-6">
        <div class="ml-3">
        <h1>For Queries Contact</h1>
        <dl class="row">
  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9"> founder@packetprep.com</dd>
  <dt class="col-sm-3">Phone</dt>
  <dd class="col-sm-9"> +91 95151 25110</dd>
</dl>
      </div>
        
      </div>
    </div>
    
  </div>
 @endif 
 @endif

<div class="row">
  <div class="col-12 ">

<div class="mb-4  p-3 pt-5 bg-white" style="border:1px solid #cae1ec;">

  <div class="row">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-3">
          <img class="img-thumbnail rounded-circle mb-3" src="@if(\auth::user()->image) {{ (\auth::user()->image)}}@else {{ Gravatar::src($user->email, 150) }}@endif">
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

@if(\auth::user()->checkRole(['administrator','hr-manager']))
<div class="rounded table-responsive bg-white mb-3 p-3 border">
<h3 class="mb-3">Create Custom tests </h3>
<a href="{{ route('exam.index')}}" class="btn btn-sm btn-primary">Tests Dashboard</a>
</div>
@endif

@if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com')


@if(count(\auth::user()->tests())!=0)
  <div class="rounded table-responsive ">
            <table class="table table-bordered bg-white">
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
                    {{$test->score}} / {{$test->max}}
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
  <br><br>
        @endif


@else
  @if(count(auth::user()->products)!=0)
  <div class="rounded table-responsive bg-white">
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
  <br><br>
        @endif
@endif

  </div>

  
</div>

</div>
@endsection           