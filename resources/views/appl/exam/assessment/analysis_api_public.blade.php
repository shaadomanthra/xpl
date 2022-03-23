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
			<a href="{{ url('/dashboard')}}" class="btn btn-success mt-3">back to dashboard</a>
		</p>
	</div>

	@if($exam->solutions!=0)
	<div class="card "  style="background: #ffceb8;border: 2px solid #e0a889;color: #b55422;">
		<div class="card-body">
			Your have scored {{$score}} @if($total) / {{$total}} @endif <br>
			
		</div>
	</div>
	@elseif($exam->solutions==0)
			{!!$analysisdata!!}
	@endif 
	</div>
</div>



@endsection           