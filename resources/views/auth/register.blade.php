@extends('layouts.app-plain')

@section('title', 'Register ')
@section('content')

@include('flash::message')
@if(subdomain())
    @if(file_exists(base_path().'/resources/views/auth/pages/'.subdomain().'.blade.php'))
        @include('auth.pages.'.subdomain())
    @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
    	@include('auth.pages.register')
    @else 
        @include('auth.pages.corporate')
    @endif
@else
	@include('auth.pages.register')
@endif
@endsection
