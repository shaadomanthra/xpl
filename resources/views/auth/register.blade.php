@extends('layouts.app-plain')

@section('title', 'Register ')
@section('content')

@include('flash::message')
    @if(file_exists(base_path().'/resources/views/auth/pages/'.subdomain().'.blade.php'))
        @include('auth.pages.'.subdomain())
    @else 
        @include('auth.pages.corporate')
    @endif
@endsection
