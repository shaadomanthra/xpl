@extends('layouts.app')
@section('content')

<div  class="bg-white p-3 rounded ">

<div class="bg-light border p-4 mb-4">
  <form method="get" >
  <div class="form-group">
    <label for="exampleInputEmail1">Email </label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ request()->get('email')}}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@if($user)
<h3>User</h3>
<br>
  <table>
    <tr>
      <th>Name</th>
      <th>{{$user->name}}</th>
    </tr>
    <tr>
      <td>Email</td>
      <td>{{$user->email}}</td>
    </tr>
    <tr>
      <td>Phone</td>
      <td>{{$user->phone}}</td>
    </tr>
    <tr>
      <td>Current_city</td>
      <td>{{$user->current_city}}</td>
    </tr>
    <tr>
      <td>Hometown</td>
      <td>{{$user->hometown}}</td>
    </tr>
    @if(isset($user->college->name))
    <tr>
      <td>College</td>
      <td>{{$user->college->name}}</td>
    </tr>
    @endif

    @if(isset($user->branch->name))
    <tr>
      <td>Branch</td>
      <td>{{$user->branch->name}}</td>
    </tr>
    @endif
    <tr>
      <td>Year of passing</td>
      <td>{{$user->year_of_passing}}</td>
    </tr>
    <tr>
      <td>Graduation Percentage</td>
      <td>{{$user->bachelors}}</td>
    </tr>
    <tr>
      <td>Class 12 Percentage</td>
      <td>{{$user->twelveth}}</td>
    </tr>
    <tr>
      <td>Class 10 Percentage</td>
      <td>{{$user->tenth}}</td>
    </tr>
  </table>

@elseif(request()->get('email'))
 <h3>No user found</h3>
@endif

</div>
@endsection

