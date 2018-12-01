@extends('layouts.nowrap-product')
@section('content')
<div class=" p-4  bg-white mb-4 border-bottom">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="mt-2 mb-4 mb-md-2">
      <i class="fa fa-gg"></i> &nbsp;Online Tests
      </h1>
    </div>
    <div class="col-12 col-md-4">

      <form class="form" method="GET" action="{{ route('assessment.index') }}">

            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control form-control-lg" id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>

      </div>
  </div>
  </div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >  
    
      <div class="row">
        <div class="col-3">


<div class="list-group">

  <a href="{{ route('assessment.index')}}" class="list-group-item list-group-item-action  {{  (request()->has('filter')) ? '' : 'active'  }} ">
     All Tests
  </a>
  @foreach($examtypes as $et)
  <a href="{{ route('assessment.index')}}?filter={{$et->slug}}" class="list-group-item list-group-item-action  {{  (request()->get('filter')==$et->slug) ? 'active' : ''  }} ">
     {{ $et->name }} ({{ count($et->exams)}})
  </a>
  @endforeach

  
  
</div>

        </div>

        <div class="col-9">
          <div id="search-items">
            @include('appl.exam.assessment.list')
          </div>
        </div>
      </div>


      

     </div>   
</div>

@endsection           
