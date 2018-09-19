
@extends('layouts.corporate-body')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-check-circle"></i> Success</h1>
<hr>

<p> Your transaction with Order Number {{ $order->order_id }} was successful. The Account Credits will be added to your account {{ \auth::user()->client_slug}}.onlinelibrary.co in few minutes. 
<br>In case of any query contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

</div>
</div>
@endsection