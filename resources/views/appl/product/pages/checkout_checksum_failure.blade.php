
@extends('layouts.corporate-body')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-danger"><i class="fa fa-check-circle"></i> Checksum Error</h1>
<hr>

<p>  There is a mismatch in checksum. Kindly contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

</div>
</div>
@endsection