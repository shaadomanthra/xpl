
@extends('layouts.app')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-danger"><i class="fa fa-check-circle"></i> Order Denial</h1>
<hr>

<p>  You have already purchased this package ({{$order->order_id}}) with us  {{ $order->created_at->diffForHumans()}}. <hr>Kindly contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

</div>
</div>
@endsection