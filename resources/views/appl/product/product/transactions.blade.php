@extends('layouts.app')
@section('title', 'Transactions ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Transactions </li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-12">
 
        <nav class="navbar bg-white justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-shopping-cart"></i> Transactions </a>

         

        </nav>

         <div class="row my-3">
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-body">
                  <h3>Total</h3>
                  <div class="display-3">{{$status['total']}}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-body">
                  <h3>Completed</h3>
                  <div class="display-3">{{$status['complete']}}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-body">
                  <h3>Pending</h3>
                  <div class="display-3">{{$status['incomplete']}}</div>
                </div>
              </div>
            </div>
          </div>

        <div id="search-items">
         @if($orders->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered bg-white mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$orders->total()}})</th>
                <th scope="col">Order ID </th>
                <th scope="col">User</th>
                <th scope="col">Product</th>
                <th scope="col">Status</th>
                <th scope="col">Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $key=>$order)  
              <tr>
                <th scope="row">{{ $orders->currentpage() ? ($orders->currentpage()-1) * $orders->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  {{ $order->order_id }}
                 
                </td>
                 <td>
                  @if(isset($order->user->name))
                    {{$order->user->name}} <br> {{$order->user->phone}} <br> {{$order->user->email}}
                  @endif</td>
                <td>{{ $product->name }}</td>
                <td>
                  @if($order->status==0)
                    <span class="badge badge-warning">Pending</span>
                  @elseif($order->status ==1)
                    <span class="badge badge-success">Success</span>
                  @else
                    <span class="badge badge-danger">Failure</span>
                  @endif
                </td>
                <td>{{ ($order->created_at) ? $order->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No transactions listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($orders->total() > config('global.no_of_records'))mt-3 @endif">
        {{$orders->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

       </div>

 </div>
</div>

@endsection


