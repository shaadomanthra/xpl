@extends('layouts.app-plain')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} - Analysis  </li>
  </ol>
</nav>



<div class="mb-md-2">
	<div class="">
		<div class="p-3 border rounded bg-light mb-4">
		<div class="  display-4  mb-3"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
			
		</p>
	</div>

	<div class="card "  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
		<div class="card-body">
			Your responses are recorded for internal evaluation.
		</div>
	</div>

	

	</div>
</div>



@endsection           