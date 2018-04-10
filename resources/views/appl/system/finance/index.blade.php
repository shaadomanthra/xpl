@extends('layouts.app')
@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('system')}}">System</a></li>
    <li class="breadcrumb-item active" aria-current="page">Finance</li>
  </ol>
</nav>

<div  class="row ">
  <div class="col-md-9">

    @include('flash::message')  
    <div class="card mb-3">
      <div class="card-body bg-light">
        <h1 class="mb-1"><i class="fa fa-rupee"></i> Cash Flow
          <span class="float-right">
          @can('create',$finance)
            <a href="{{route('finance.create')}}">
              <button type="button" class="btn btn-outline-success "><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </span>
        </h1>

        <div class="">
           Financial Year : <span class="text-info">{{ (request()->year)? '20'.(request()->year).'-'.(request()->year+1) : '20'.($finances->curr_year).'-'.($finances->curr_year+1) }} </span>
             &nbsp;&nbsp;
             @if(!request()->month && request()->quater)
             Quater: 
             <span class="text-info">
             @if(!request()->quater)
              All
             @elseif(request()->quater==1)
             April-June
             @elseif(request()->quater==2)
             July-Sept
             @elseif(request()->quater==3)
             Oct-Dec
             @else
             Jan-Mar
             @endif
              </span>
              @endif
              &nbsp;&nbsp;
              @if(request()->month)
              Month:
              <span class="text-info">
             @if(!request()->month)
              All
             @elseif(request()->month==1)
             Jan
             @elseif(request()->month==2)
             Feb
             @elseif(request()->month==3)
             Mar
             @elseif(request()->month==4)
             April
             @elseif(request()->month==5)
             May
             @elseif(request()->month==6)
             June
             @elseif(request()->month==7)
             July
             @elseif(request()->month==8)
             Aug
             @elseif(request()->month==9)
             Sept
             @elseif(request()->month==10)
             Oct
             @elseif(request()->month==11)
             Nov
             @else
             Dec
             @endif
              </span>
              @endif
        </div>
        
      </div>
    </div>
    <div class="mb-3 ">
          <div class="">
            <div class="row mb-0 mt-2 no-gutters ">
              <div class="col-md-4">
                  <div class="card border text-secondary mb-3 mb-md-0 mr-md-3">
                      <div class="card-body">
                        <div class="card-title">Cash In</div>
                          <h1><i class="fa fa-rupee"></i>{{ $finances->cashin }}</h1>
                      </div>
                  </div>
              </div>
               <div class="col-md-4">
                  <div class="card border text-secondary mb-3 mb-md-0 mr-md-3">
                      <div class="card-body">
                        <div class="card-title">Cash Out</div>
                          <h1><i class="fa fa-rupee"></i>{{ $finances->cashout }}</h1>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="card border-secondary text-secondary">
                      <div class="card-body">
                        <div class="card-title">Balance</div>
                        @if($finances->cashin - $finances->cashout > -1)
                          <h1 class="text-success"><i class="fa fa-rupee"></i>{{ $finances->cashin - $finances->cashout   }}</h1>
                        @else
                          <h1 class="text-danger"> - <i class="fa fa-rupee"></i>{{ $finances->cashout - $finances->cashin   }}</h1>
                        @endif
                      </div>
                  </div>
              </div>

            </div>

          </div>
        </div>
    <div class="card mb-3">
      <div class="card-body ">
        
        <div id="search-items" class="p-3 pb-0">
          @if($finances->total()!=0)
            @foreach($finances as $key=>$finance)  
             @if($key != 0)
              <hr>
              @endif
            <div class="row">
              <div class="col-1">
                @if($finance->flow==0)
                   <i class="fa fa-2x fa-plus-square text-success"></i>
                @else 
                   <i class="fa fa-2x fa-minus-square text-danger"></i>
                @endif
                
              </div>
              <div class="col-6 col-lg-3">
                
                <h1 class="mb-0 @if($finance->flow==0)text-success @else text-danger @endif"> &nbsp;<i class="fa fa-rupee"></i>{{ $finance->amount }} 
                    @can('edit',$finance)  
                  <a href="{{ route('finance.edit',$finance->id) }}">
                  <i class="fa fa-edit"></i>
                  </a>
                  @endcan
                </h1> 

                <div class="mb-3"></div>
              </div>
              <div class="col-12 col-lg-5">
                {!! $finance->content !!}
              </div>
              <div class="col-12 col-lg-3">
                 <a href="{{ route('profile','@'.\auth::user()->getUsername($finance->user_id))}}">{{ \auth::user()->getName($finance->user_id)}}</a><br>
                <small >{{ \carbon\carbon::parse($finance->transaction_at)->format('d M Y') }}</small>
              </div>
            </div>
            
            @endforeach      
          @else
          <div class="card card-body bg-light ">
            No entry recorded
          </div>
          @endif
          <div class="">
          <nav aria-label="Page navigation example" class="card-nav @if($finances->total() > config('global.no_of_records'))mt-3 @endif">
            {{$finances->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>
        </div>

      </div>
    </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')

      <div class="card bg-light mt-3">
        <div class="card-body">
          <form method="get" action="{{route('finance.index')}}">
          <h3> Filters</h3>
          <div class="form-group">
          <label for="formGroupExampleInput ">Financial Year </label>
        <select class="form-control" name="year">
          @for($i= $finances->curr_year;$i > ($finances->curr_year-3);$i--)
          <option value="{{$i}}" @if(isset(request()->year)) @if(request()->year==$i) selected @endif @endif >20{{$i}}-{{$i+1}}</option>
          @endfor
        </select>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Quater</label>
        <select class="form-control" name="quater">
          <option value="0" @if(isset(request()->quater)) @if(request()->quater==0) selected @endif @endif >None</option>
          <option value="1" @if(isset(request()->quater)) @if(request()->quater==1) selected @endif @endif >April-June</option>
          <option value="2" @if(isset(request()->quater)) @if(request()->quater==2) selected @endif @endif >July-Sept</option>
          <option value="3" @if(isset(request()->quater)) @if(request()->quater==3) selected @endif @endif >Oct-Dec</option>
          <option value="4" @if(isset(request()->quater)) @if(request()->quater==4) selected @endif @endif >Jan-Mar</option>
        </select>
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">Month</label>
        <select class="form-control" name="month">
          <option value="0" @if(isset(request()->month)) @if(request()->month==0) selected @endif @endif >None</option>
          <option value="4" @if(isset(request()->month)) @if(request()->month==4) selected @endif @endif >Apr</option>
          <option value="5" @if(isset(request()->month)) @if(request()->month==5) selected @endif @endif >May</option>
          <option value="6" @if(isset(request()->month)) @if(request()->month==6) selected @endif @endif >Jun</option>
          <option value="7" @if(isset(request()->month)) @if(request()->month==7) selected @endif @endif >Jul</option>
          <option value="8" @if(isset(request()->month)) @if(request()->month==8) selected @endif @endif >Aug</option>
          <option value="9" @if(isset(request()->month)) @if(request()->month==9) selected @endif @endif >Sep</option>
          <option value="10" @if(isset(request()->month)) @if(request()->month==10) selected @endif @endif >Oct</option>
          <option value="11" @if(isset(request()->month)) @if(request()->month==11) selected @endif @endif >Nov</option>
          <option value="12" @if(isset(request()->month)) @if(request()->month==12) selected @endif @endif >Dec</option>
          <option value="1" @if(isset(request()->month)) @if(request()->month==1) selected @endif @endif >Jan</option>
          <option value="2" @if(isset(request()->month)) @if(request()->month==2) selected @endif @endif >Feb</option>
          <option value="3" @if(isset(request()->month)) @if(request()->month==3) selected @endif @endif >Mar</option>
        </select>
      </div>
        <button class="btn btn-sm btn-outline-secondary " type="submit" >Apply</button>
        </form>

        </div>
      </div>
    </div>
</div>



@endsection


