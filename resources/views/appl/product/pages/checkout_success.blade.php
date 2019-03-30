
@extends('layouts.app')
@section('title', 'Transaction Successful '.$order->order_id.' | PacketPrep')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-check-circle"></i> Success</h1>
<hr>

<p> Your transaction with Order Number <b>{{ $order->order_id }}</b> was successful. <br>Your Service Request will be active.  
	<hr>
In case of any query contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

<div class="bg-light p-3 border rounded mb-3"> For classroom training, you can take the print of the service activation from the below link and submit in the packetprep office.</div>
<a href="{{ route('productpage',$order->product->slug) }}">
<button class="btn btn-outline-primary btn-lg"> View Product/Service</button>
</a>

</div>
</div>
@endsection