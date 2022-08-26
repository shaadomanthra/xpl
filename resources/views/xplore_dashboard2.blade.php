@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')
@section('content')


<div class="container mt-4">












@if(\auth::user()->tests())

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
                    <a href="{{ route('assessment.analysis',$test->slug) }}">{{$test->name}}</a>
                  </td>

                  <td>
                    @if(!$test->attempt_status)
                      @if($test->solutions==2 || $test->solutions==4 )
                      <span class="badge badge-secondary">private</span>
                      @elseif($test->slug!='psychometric-test')
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
                         - <a href="{{ route('course.show',$c->slug)}}">{{$c->name}}</a> <span class="badge badge-primary">course</span><br>
                    @endforeach
                    @foreach($product->exams as $e)
                         - <a href="{{ route('assessment.details',$e->slug)}}">{{$e->name}}</a> <span class="badge badge-secondary">Test</span><br>
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