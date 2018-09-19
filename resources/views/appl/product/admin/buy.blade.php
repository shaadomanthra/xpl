@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item">Buy Credits</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        

        <div class="card mb-3">
      <div class="card-body">
      
        <h1> Buy Credits</h1>
                <form method="post" action="{{ route('payment.order')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="form-group mb-2">
                    <label for="exampleFormControlSelect1" class="mb-2">Credit Rate - <i class="fa fa-rupee"></i> <span class="credit_rate">{{ $client->getOfferRate()}}</span> / credit</label>
                    <input class="form-check-input" type="hidden" name="type" id="exampleRadios1" value="paytm" >
                    <br>
                    <input class="form-control credit_count" type="text" name="credit_count"  value="10"  >
                    
                    <input class="form-check-input" type="hidden" name="package" id="exampleRadios1" value="credit">
                    <input class="form-check-input" type="hidden" name="credit_rate"  value="{{$client->getPackageRate()}}">
                    <input class="form-check-input" type="hidden" name="txn_amount"  value="1">
                    <div class="mt-3 display-4"><i class="fa fa-rupee"></i><span class="price"> {{ ($client->getOfferRate()*10)}}</span></div>
                    <br>
                  <button class="btn btn-lg btn-outline-primary" type="submit">Buy Online</button> 
                 
                </div>

                </form>
        </div>
      </div>

       <div class="card">
      <div class="card-body bg-light">
<h1 class="text-secondary"> Credit Rates</h1>
<br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Slab</th>
      <th scope="col">Cost per Credit</th>
   
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>0 < Credit Points  < 200 </td>
      <td><i class="fa fa-rupee"></i> 200 </td>
     
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>200 < Credit Points  < 500</td>
      <td><i class="fa fa-rupee"></i> 175 </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>500 < Credit Points  < 1000</td>
      <td><i class="fa fa-rupee"></i> 150 </td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>1000 < Credit Points  </td>
      <td><i class="fa fa-rupee"></i> 125 </td>
    </tr>
  </tbody>
</table>
      </div>
    </div>
        

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection

