@extends('layouts.app')

@section('content')
<div class="jumbotron bg-white">
  <h1 class="display-4"><span class="text-success">Welcome</span> <span class="text-primary">on board !</span></h1>
  <p class="lead">
    <table>
        <tr>
          <th>SNO</th>
          <th>College Name</th>
          <th>Count</th>
        </tr>
    @foreach($college as $c)
      
        <tr>
          <td>{{$c->id}}</td>
          <td>{{$c->name}}</td>
           <td>{{$c->count}}</td>
        </tr>
      
    @endforeach
    </table>
  We are on a mission to make learning simple, interesting and comprehensive.<br> 
Our product will help thousands of students crack tough competitive exams. To make this noble effort fruitful, kindly pledge to work with atmost dedication.</p>
  <hr class="my-4">
  <p>The <code>@administrator</code> will be assign the work to you shortly! </p>
  <p class="lead">
  </p>
</div>
@endsection
