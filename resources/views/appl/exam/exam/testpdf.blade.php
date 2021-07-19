@extends('layouts.app-border')
@section('title', $exam->name.' view')
@section('description', substr(strip_tags($exam->description),0,200))
@section('content')

<div class="mb-md-5 mb-2 ">
	<div class=" border p-5 bg-white rounded" style="min-height:300px;">
		<div class="row">
			
			<div class="col-12 ">
				<h1 class="">
					
					{{ $exam->name }} @if($exam->status ==2)
					<span class="badge badge-warning ">
					<i class="fa fa-lock" aria-hidden="true"></i>  PRIVATE
				</span>
					@else
					<span class="badge badge-warning ">
					<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> OPEN
				</span>
					@endif</h1>

				<p class="mb-3">
				{!! $exam->description  !!}
				</p>

				
				<div class="row mt-5">
					<div class="col-12 col-md-4">
							<a href="{{ route('assessment.show',$exam->slug)}}" class="btn btn-primary btn-lg btn-block" target="_blank">Attempt Test</a>
					</div>
					<div class="col-12 col-md-4">
						<a href="{{ route('test.pdfupload',$exam->slug)}}" class="btn btn-success btn-lg btn-block mt-2 mt-md-0" target="_blank">Upload Answersheet PDF</a>
					</div>
				</div>
	</div>
</div>
@endsection           