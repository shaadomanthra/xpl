@extends('layouts.nowrap-product')
@section('title', 'Leaderboard - Campus Connect | PacketPrep')
@section('description', 'This page is about campus connect')
@section('keywords', 'college,packetprep,campus connect')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-university"></i> &nbsp; Leaderboard - Campus Ambassadors
			</h1>
      <a href="{{ route('ambassador.connect')}}"><button class="btn btn-sm btn-success">view connect page</button></a>


		</div>
		<div class="col-12 col-md-4">
      
  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
  <div class="container pb-5" >  
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="bg-white p-3 border">
          <div class="display-3 mb-4">Top Ambassadors - Weekly</div>

          <div class="p-2 bg-light border rounded mb-3">20th to 28th May 2019</div>
            <table class="table">
  <thead>
    <tr class="border">
      <th scope="col" class="border border-dark">#</th>
      <th scope="col" class="border border-dark">Name</th>
      <th scope="col" class="border border-dark">College</th>
      <th scope="col" class="border border-dark">Score</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>chandra sekhar</td>
      <td>Maturi Venkata Subba Rao Engineering College - CSE</td>
      <td>310</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>M v s s s r sahith</td>
      <td>Maturi Venkata Subba Rao Engineering College - CSE</td>
      <td>300</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>JUVERIA KHATOON</td>
      <td>Muffakham Jah College of Engineering and Technology - CSE</td>
      <td>238</td>
    </tr>
  </tbody>
</table>

<div class="p-2 bg-light border rounded mb-3">29th May to 11th June 2019</div>
            <table class="table">
  <thead>
    <tr class="border">
      <th scope="col" class="border border-dark">#</th>
      <th scope="col" class="border border-dark">Name</th>
      <th scope="col" class="border border-dark">College</th>
      <th scope="col" class="border border-dark">Score</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>J.suryaprakash Reddy</td>
      <td>Mahatma Gandhi Institute Of Technology - EEE</td>
      <td>2077</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>P. Laxmi Chandana</td>
      <td>Anurag Group of institutions - IT</td>
      <td>1523</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>M v s s s r sahith</td>
      <td>Maturi Venkata Subba Rao Engineering College - CSE</td>
      <td>1092</td>
    </tr>
  </tbody>
</table>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="bg-white p-3 border">
          <div class="display-3 mb-4">Top 5 Ambassadors - Over all</div>
          <div class="bg-light border rounded p-2 mb-3"> Updated on : <i>{{ $data_amb->now }}</i>
              <div><small>Data will be refreshed for every 24 hours</small></div>
            </div>
         @if($data_amb)
            <div class="table table-responsive">
              <table class="table">
                <thead>
                  <tr class="border">
                    <th scope="col" class="border border-dark">#</th>
                    <th scope="col" class="border border-dark">Top Ambassador</th>
                    <th scope="col" class="border border-dark">College</th>
                    <th scope="col" class="border border-dark {{$m=0}}">Score</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach($data_amb->amb_scores as $k=>$t) 
                  <tr>
                    <td scope="row">{{ (++$m) }}</td>
                    <td>{{ $data_amb->amb_user->$k->name }}</td>
                    <td>{{ $data_amb->amb_user->$k->college}} - {{$data_amb->amb_user->$k->branch}} </td>
                    <td>{{ $t }}</td>
                  </tr>
                  @if($m==5)
                  @break
                  @endif
                  @endforeach
                  
                 
                </tbody>
              </table>
            </div>
            @else
              <div class=" border p-3">No data to show</div>
            @endif
          </div>
      </div>
    </div>
  </div>
</div>

@endsection           