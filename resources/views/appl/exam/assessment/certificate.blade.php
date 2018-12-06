@extends('layouts.plain')

@section('content')
<div style="background: #f8f8f8; height:100%">
	<div class="p-3">
		<div class="bg-white border">
			<div class="ml-1 ml-md-5 pb-5">
			<img src="{{ asset('/img/packetprep-logo-small.png')}}" class="ml-5"/>

			<div class="mt-5 p-5 ">
				<div class="display-4">This is to certify that </div><br>
				<div class="display-2 "><i>{{ $user->name }} </i></div><br>
				<div class="display-4 mb-2">has attempted the PACKETPREP PROFICIENCY TEST</div>
				<div class="display-4 mb-3">conducted on <span class="text-secondary">{{\carbon\Carbon::parse($date)->format('jS M Y')}}</span></div>
				<p><b>Performance report :  <a href="{{ route('report',[$exam->slug,$user->username]) }}"><i>{{ route('report',[$exam->slug,$user->username]) }}</i></a></b></p>

			</div>

			<div class="ml-5 m-5">
				<div class="">
					<img src="{{ asset('/img/teja_sig.png')}}" style="width:120px"/>
				<div class="">Founder</div>
				<div class="">PACKETPREP</div>
				</div>
			</div>

			</div>
		</div>
	</div>
</div>
@endsection           