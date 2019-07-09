@extends('layouts.app')
@section('title', 'Code Editor | PacketPrep')
@section('content')

<div class="bg-white">
  <div class="card-body p-4 ">
    <h1 class="display-3 mt-3 ">Editor </h1>
         <input type="hidden" name="_token" value="{{ csrf_token() }}">

@if(!$cpp)
<textarea id="code" class="form-control code" name="code"  rows="5">
#include <stdio.h>

int main (){
  printf("Hello World");
  
}
</textarea>
@else
<textarea id="code" class="form-control code" name="code"  rows="5">{{$cpp}}</textarea>
@endif
<button class="btn btn-primary mt-3 btn-run" type="button" id="run" data-in1="5" data-in2="7" data-in3="10" data-token="{{ csrf_token() }}">Compile</button>



<div class="card">
  <div class="card-header">
    Output
  </div>
  <div class="card-body">
<pre class="bg-light border p-3 mb-3"><code id="in1"></code></pre>
<pre class="bg-light border p-3 mb-3"><code id="in2"></code></pre>
<pre class="bg-light border p-3 mb-3"><code id="in3"></code></pre>
  </div>
</div>



  </div>
</div>

@endsection           