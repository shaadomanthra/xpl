

@extends('layouts.app-border')
@section('title', 'Contact Us')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
	<div class="float-md-right mt-2">
<a href="{{ url('/')}}">
<i class="fa fa-angle-left"></i> back to homepage</a>
</div>
<h1><i class="fa fa-envelope"></i> &nbsp;Contact Us</h1>

<hr>

<br>
<p>
	<h2> {{ request()->session()->get('client')->name }}</h2><Br>
	{!! html_entity_decode(request()->session()->get('client')->contact) !!}
</p>


</div>		
</div>
@endsection           