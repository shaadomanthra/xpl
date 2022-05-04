@extends('layouts.none')

@section('content')
<div class="jumbotron bg-white">
  <h1 class="display-4"><span class="text-success">College</span> <span class="text-primary">Data !</span></h1>
  <p class="lead">
    <table>
        <tr>
          <th>SNO ({{count($college)}})</th>
          <th>College Name</th>
          <th>Location</th>
          <th>Count</th>
        </tr>
    @foreach($college as $c)
      
        <tr>
          <td>{{$c->id}}</td>
          <td>{{$c->name}}</td>
          <td>{{$c->location}}</td>
           <td>{{$c->count}}</td>
        </tr>
      
    @endforeach
    </table>
    <hr>
    <h5>Data count - {{$counter}}</h5>
    <hr>

</div>
@endsection
