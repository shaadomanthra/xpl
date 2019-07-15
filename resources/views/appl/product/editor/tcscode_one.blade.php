@extends('layouts.app')
@section('title', 'Code Editor | PacketPrep')
@section('content')

<div class="bg-white rounded">
  <div class="card-body p-4 ">
    <h1 class="display-3 mt-3 mb-4">Coding Simulation - Even/Odd</h1>
    <div class="row">
      <div class="col-12 col-md-4">
       <div class="bg-light mb-4 p-3 border">
        <p class="">
          <b>Write a program to check if the given number is even or odd</b>

<p>If the given input is 4, the STDOUT has to 1 else it has to be 0</p>

</p>
  </div>

  <div class="bg-light mb-4 p-3 border">
        <p class="">
          <b>Notes</b>

<p><b class="text-primary">argc</b>(argument count) stores the number of the arguments passed to the main function</p>
<p><b class="text-primary">argv</b>(argument vector) stores the array of the one-dimensional array of strings.</p>
<p> argv[0] - the filename, argv[1] - first argument, argv[2] - second argument</p><hr>
<p> For example <br><b>./excutablefile 23 45 </b><br> argv[0] - ./excutablefile <br> argv[1] - 23<br> argv[2] - 45</p><hr>
<p><b class="text-primary">atoi(str) </b>converts the string argument str to an integer (type int)</p>

  </div>

  <div class="bg-light mb-4 p-3 border">
<p>For more details on command line programming watch the following video-<br>
<a href="https://youtu.be/9tSVxqJyjBo"><p><i class="fa fa-youtube-play"></i> Command Line Arguments for TCS NQT</p></a>
This video gives a run through of how to use command line arguments in programming to take input from terminal</p>

</p>
  </div>
      </div>

      <div class="col-12 col-md-8">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">


<textarea id="code" class="form-control code" name="code" mode="c-like" rows="10">
#include <stdio.h>
#include <stdlib.h>

int main (int argc, char *argv[]){
  int n,output;
  n = atoi(argv[1]);

  if(n % 2 == 0){
    output = 1;
  }else{
    output = 0;
  }
  printf("%d",output);
}

</textarea>

<button class="btn btn-primary mt-3 btn-run" type="button"  data-token="{{ csrf_token() }}" data-url="{{ route('tcs.testcase.one') }}">Compile & Run</button><img class="loading" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>



<div class="card mt-4">
  <div class="card-header">
    Output
  </div>
  <div class="card-body">

    <div class="bg-light border p-3 mb-3 codeerror">
    </div>

    <div class="d-none d-md-block">

    <div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Testcase</th>
      <th scope="col">Input</th>
      <th scope="col">Output</th>
      <th scope="col">Success</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Public</td>
      <td>14</td>
      <td><p class="in1">-</p></td>
      <td><p class="in1-message">-</p></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Private</td>
      <td class="text-muted">Hidden</td>
      <td class="text-muted">Hidden</td>
      <td><p class="in2-message">-</p></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Private</td>
      <td class="text-muted">Hidden</td>
      <td class="text-muted">Hidden</td>
      <td><p class="in3-message">-</p></td>
    </tr>
  </tbody>
</table>
</div>
</div>

<div class="d-block d-md-none">

    <div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Testcase</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>
          Public
          <br>Input - 14
        <div>
          Output : <span class="in1">-</span>
        </div>
        <div>
            <span class="in1-message">-</span>
        </div>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>
        Private
          <br>Input - <span class="text-muted">Hidden</span>
        <div>
          Output : <span  class="text-muted">hidden</span>
        </div>
        <div>
            <span class="in2-message">-</span>
        </div>

      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>
        
        Private
          <br>Input - <span class="text-muted">Hidden</span>
        <div>
          Output : <span  class="text-muted">hidden</span>
        </div>
        <div>
            <span class="in3-message">-</span>
        </div>
      </td>
    </tr>
  </tbody>
</table>
</div>

</div>
  </div>
</div>
      </div>

    </div>




  </div>
</div>

@endsection           