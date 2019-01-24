
@extends('layouts.app')
@section('title', 'Activation Successful  | PacketPrep')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-check-circle"></i> Product Activation - Success</h1>
<hr>

<p> Congratulations ! Your Services are active now. 
	<hr>
In case of any query contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

<a href="{{ route('dashboard') }}">
<button class="btn btn-outline-primary btn-lg"> Dashboard</button>
</a>

</div>
</div>
@endsection