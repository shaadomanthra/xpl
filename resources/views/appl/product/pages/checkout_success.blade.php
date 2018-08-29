
@extends('layouts.corporate-body')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-check-circle"></i> Success</h1>
<hr>

@if(request()->get('MID'))
	{{ dd(request()->all())}}
@endif
<p> Your transaction with reference number XXXX was successful. The login details will be mailed to you shortly.
<br>In case of any query contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

</div>
</div>
@endsection