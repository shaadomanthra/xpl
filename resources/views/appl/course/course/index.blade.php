@extends('layouts.nowrap-product')
@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-4 border-bottom">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-list-alt"></i> &nbsp;Courses
			@can('create',$course)
            <a href="{{route('course.create')}}">
              <button type="button" class="btn btn-outline-success btn-sm my-2 my-sm-2 mr-sm-3"><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
			</h1>

		</div>
		<div class="col-12 col-md-4">

			<form class="form" method="GET" action="{{ route('course.index') }}">
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
    @if($courses->total()!=0)  
   	
  	 <div >
  	 	<div id="search-items" class="row" >
         @include('appl.course.course.list')
         </div>
     </div>
	
	@else
	<div class="card card-body bg-light">
          No courses listed
	  </div>
	@endif

     </div>   
</div>

@endsection           