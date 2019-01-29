
@extends('layouts.nowrap-product')
@section('title', 'User Statistics | PacketPrep')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-users"></i> &nbsp;User Statistics
			
			</h1>

		</div>
		<div class="col-12 col-md-4">

			

  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >  
    
     <div class="">
      <div class="mb-0">
        

        <div class="row no-gutters">
            <div class="col-12 col-md-4">
              <div class="card mb-3 mr-md-2">
                <div class="card-body">
                  <h3>Total Users</h3>
                    <div class="display-1">
                    	<div class="" style="font-size: 80px;"><img src="{{ asset('/img/friendship.png')}}" class=" p-3 pt-0" style="width:100px"/> <span class="mt-3">{{ $users->total }} </span></div>
                    </div>
                    <br>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Month</h3>
                    <div class="display-4 mb-4">{{ $users->this_month }}</div>
                  <h3 class="card-title">Last Month</h3>
                    <div class="display-4">{{ $users->last_month }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Year</h3>
                    <div class="display-4 mb-4">{{ $users->this_year }}</div>
                  <h3 class="card-title">Last Year</h3>
                    <div class="display-4">{{ $users->last_year }}</div>
                  
                </div>
              </div>
            </div>
            
        </div>

        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-bar-chart"></i> Metrics</a>

        </nav>

        <div class="row no-gutters">

          @foreach($metrics as $metric)
          <div class="col-12 col-md-4">
              <div class="card bg-light mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">{{ $metric->name }}</h3>
                    <div class="display-4 mb-4"><a href=" {{ route('admin.user') }}?metric={{$metric->name}} ">{{ $metric->users->count() }}</a></div>
                </div>
              </div>
            </div>
            @endforeach

        </div>

     </div>
   </div>

     </div>   
</div>

@endsection

        