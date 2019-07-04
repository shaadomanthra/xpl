@extends('layouts.app')
@section('title', 'Code Editor | PacketPrep')
@section('content')

<div class="bg-white">
	<div class="card-body p-4 ">
		<h1 class="display-3 mt-3 ">Editor </h1>
		  <form action="{{ route('editor') }}" method="post" class=" mb-3">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">

<textarea id="code" class="form-control code" name="code"  rows="5">
#include <stdio.h>

int main (){
  printf("Hello World");
  
}
</textarea>
<button class="btn btn-primary mt-3" type="submit">Compile</button>
</form>

@if($data)
<div class="card">
  <div class="card-header">
    Output
  </div>
  <div class="card-body">
    {{ $data }}
  </div>
</div>
@endif


	</div>
</div>

@endsection           