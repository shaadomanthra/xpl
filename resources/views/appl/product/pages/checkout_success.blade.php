
@extends('layouts.app')
@section('title', 'Transaction Successful '.$order->order_id.' | PacketPrep')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-check-circle"></i> Success</h1>
<hr>

<p> Your transaction with Order Number <b>{{ $order->order_id }}</b> was successful. <br>The access to the premium content under this package is granted.  
	<hr>
In case of any query contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

</div>
</div>
@endsection