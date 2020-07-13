
@extends('layouts.app')

@section('content')


<div class="bg-white border">
<div class="card-body p-4 ">
<h1 class="text-danger"><i class="fa fa-check-circle"></i> Invalid checkout</h1>
<hr>

<p> This checkout amount cannot be less than Rs.10<bR> For futher details kindly contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact')}}">link</a></p>

</div>
</div>
@endsection