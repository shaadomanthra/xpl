@extends('layouts.app')
@section('title', 'Code Editor | PacketPrep')
@section('content')

<div class="bg-white rounded">
  <div class="card-body p-4 ">
    <h1 class="display-3 mt-3 mb-4">TCS NQT - Coding Simulation </h1>
    <div class="row">
      <div class="col-12 col-md-4">
       <div class="bg-light mb-4 p-3 border">
        <p class="">
          <b>Consider the below series:</b>

<p>1, 2, 1, 3, 2, 5, 3, 7, 5, 11, 8, 13, 13, 17, …</p>

<p>This series is a mixture of 2 series – all the odd terms in this series form a Fibonacci series and all the even terms are the prime numbers in ascending order.</p> 

<p>Write a program to find the Nth term in this series. </p>

<p>The value N is a Positive integer that should be read from STDIN. The Nth term that is calculated by the program should be written to STDOUT. Other than the value of Nth term, no other characters/strings or message should be written to STDOUT. </p>

<p>For example, when N = 14, the 14th term in the series is 17. So only the value 17 should be printed to STDOUT.</p></p>
  </div>
      </div>

      <div class="col-12 col-md-8">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">


<textarea id="code" class="form-control code" name="code" mode="c-like" rows="10">
#include <stdio.h>
#include <stdlib.h>
int prime(int position);
int fibonacci(int position);

int main (int argc, char *argv[]){
  int n,number,position,i;
 
  if(argc>1)
    n = atoi(argv[1]);
  else
    n = 1;

  if(n % 2 == 0){
    position = n/2;
    number = prime(position);
  }else{
    position = n/2+1;
    number = fibonacci(position);
  }

  printf("%d",number);
  
}

int prime(int position){
    int i=2,count=0,j;
    while(1){
        int factors =0;

        for(j=2;j<=i;j++){
            if(i%j==0)
                factors++;
        }
        if(factors==1)
            count++;
        if(count == position)
            break;
        i++;
    }
    return j-1;
}

int fibonacci(int position){
    int i, first = 1 ,second = 1, third;

    if(position == 1 || position ==2)
        return 1;

    // Fibonacci logic
    for(i=3; i<= position;i++){
        third = first + second;
        first = second;
        second = third;
    } 
    return third;
}
</textarea>

<button class="btn btn-primary mt-3 btn-run" type="button"  data-token="{{ csrf_token() }}" data-url="{{ route('tcs.testcase') }}">Compile & Run</button><img class="loading" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>



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