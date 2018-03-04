@extends('layouts.plain')

@section('content')

<div class="content">
    <div class="title m-b-md">
     <img class="img-fluid" alt="Responsive image" src="{{ asset('/img/packetprep-logo-small.png') }}" />
 </div>
<p>
	Dedication and hardwork leads to success.
</p>

<div class="links">
    <a href="{{url('/packetprep')}}">PacketPrep</a>
    <a href="https://laravel-news.com">Jobs</a>
    <a href="https://forge.laravel.com">Contact</a>
</div>
</div>
@endsection           