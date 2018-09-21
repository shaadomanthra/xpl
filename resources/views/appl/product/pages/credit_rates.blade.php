
@extends('layouts.corporate-body')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-success"><i class="fa fa-rupee"></i> Credit Rates</h1>
<br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Slab</th>
      <th scope="col">Cost per Credit</th>
   
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>0 < Credit Points  < 250 </td>
      <td><i class="fa fa-rupee"></i> 500 </td>
     
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>250 < Credit Points  < 500</td>
      <td><i class="fa fa-rupee"></i> 400 </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>500 < Credit Points  < 1000</td>
      <td><i class="fa fa-rupee"></i> 300 </td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>1000 < Credit Points   </td>
      <td><i class="fa fa-rupee"></i> 200 </td>
    </tr>
  </tbody>
</table>

</div>
</div>
@endsection