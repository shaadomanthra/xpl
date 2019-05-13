@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('order.list') }}">Transactions</a> </li>
    <li class="breadcrumb-item">{{ $order->order_id }} </li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> {{ $order->order_id}} </a>

          
        </nav>

        <div id="search-items">
         <dl class="row">
          <dt class="col-sm-3">Transaction ID</dt>
          <dd class="col-sm-9">{{ ($order->txn_id)?$order->txn_id:'-'}}</dd>

          <dt class="col-sm-3">Package</dt>
          <dd class="col-sm-9">
           {{ $order->package}}
          </dd>

          <dt class="col-sm-3">Name</dt>
          <dd class="col-sm-9">
           {{ $user->name}}
          </dd>

          <dt class="col-sm-3">Phone</dt>
          <dd class="col-sm-9">
           {{ ($user->details()->first())?$user->details()->first()->phone : '' }}
          </dd>

          <dt class="col-sm-3">College</dt>
          <dd class="col-sm-9">
           {{ ($user->colleges()->first())?$user->colleges()->first()->name : '' }}
          </dd>

          <dt class="col-sm-3">Branch</dt>
          <dd class="col-sm-9">
           {{ ($user->branches()->first())?$user->branches()->first()->name : '' }}
          </dd>


          <dt class="col-sm-3">Payment Mode</dt>
          <dd class="col-sm-9">{{ ($order->payment_mode)?$order->payment_mode:'-' }}</dd>

          <dt class="col-sm-3 text-truncate">Credit Count</dt>
          <dd class="col-sm-9">{{ $order->credit_count }}</dd>

          <dt class="col-sm-3">Credit Rate</dt>
          <dd class="col-sm-9">{{ $order->credit_rate }}</dd>

          <dt class="col-sm-3">Transaction Amount</dt>
          <dd class="col-sm-9"><i class="fa fa-rupee"></i> {{ $order->txn_amount }}</dd>

          <dt class="col-sm-3">Product</dt>
          <dd class="col-sm-9">{{ $order->product->name }}</dd>

          <dt class="col-sm-3">Status</dt>
          <dd class="col-sm-9"> @if($order->status==0)
                    <span class="badge badge-warning">Pending</span>
                  @elseif($order->status ==1)
                    <span class="badge badge-success">Success</span>
                  @else
                    <span class="badge badge-danger">Failure</span>
                  @endif</dd>

          <dt class="col-sm-3">Created at</dt>
          <dd class="col-sm-9">{{ ($order->created_at) ? $order->created_at->diffForHumans() : '' }}</dd>

        </dl>
       </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


