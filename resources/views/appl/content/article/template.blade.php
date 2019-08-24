@extends('layouts.app')
@section('title', 'PacketPrep')
@section('description', '')
@section('keywords', '')
@section('content')


@include('flash::message')

<style>
  .company p{ font-size: 30px; }

</style>

  <div class="row">

    <div class="col-md-12">
      <div class="bg-white p-5 company" style="font-size: 20px;">
      @include('appl.content.company.data')
    </div>
      </div>

    </div>



@endsection
