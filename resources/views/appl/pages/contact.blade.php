@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact</li>
      </ol>
    </nav>

<div class="card">

	<div class="card-body">
		<nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Contact Us</a>
     	 </nav>
		<p class="card-text">
			
			sample info
		</div>
	</div>
	@endsection           