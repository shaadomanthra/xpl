

@extends('layouts.app-border')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1><i class="fa fa-envelope"></i> &nbsp;Contact Us</h1>
<br>
<p>
	<h2> {{ subdomain_name() }}</h2><Br>
	{!! subdomain_contact() !!}
</p>


</div>		
</div>
@endsection           