@extends('layouts.nowrap-product')
@section('title', 'Campus Connect | PacketPrep')
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
			<i class="fa fa-university"></i> &nbsp; Campus Connect
			</h1>


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
        <div class="col-12 col-md-4">
            <div class="card">
              <div class="card-body ">
                <div> My College</div>
                <h1 class="mb-3"><a href="{{ route('ambassador.college')}}">{{ $data['college']->name }}</a></h1>

                <a href="{{ route('ambassador.college')}}" class="btn btn-outline-primary mb-4 btn-lg ">View Details</a>

                <div class="rounded text-white p-3 mb-3" style="background:#74b9ff">
                  <h3>College Score</h3>
                  <div class="display-1">{{ $data['college_score'] }}</div>
                </div>

                <div class=" rounded text-white p-3" style="background: #e17055">
                  <h3>My Score</h3>
                  <div class="display-1">{{  $data['my_score']}} </div>
                  <a href="{{ route('referral')}}" class="btn btn-outline-light mb-4 btn-sm ">My Referrals</a>

                  <h3> My Level</h3>
                  <div class="">
                    @if($data['my_score'] > 49 && $data['my_score'] < 80)
                            <div class="bg-white p-2 border text-secondary  rounded display-3"><i class ="fa fa-shield"></i> Silver</div>
                            @elseif($data['my_score'] > 79 && $data['my_score'] < 100)
                            <div class="bg-white p-2 border text-success rounded display-3"><i class ="fa fa-graduation-cap"></i> Gold</div>

                            @elseif($data['my_score'] > 99 )
                            <div class="bg-white p-2 border text-primary rounded display-3"><i class ="fa fa-trophy"></i> Platinum</div>

                            @else
                            <div class="text-white display-1"> - </div>
                            <div class="text-light" style="opacity:0.5"> You have to reach a minimum score of 50 to enter silver level</div>
                            @endif
                  </div>

                </div>

                <p>
        <div class=" border p-3 "><h3>Referral Link</h3>
           <a href="{{ route('student.eregister') }}?code={{$data['username']}}">{{ route('student.eregister') }}?code={{$data['username']}}</a></div>
      </p>
              </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card mb-4">
              <div class="card-body " style="background: #f7f1e3; border:1px solid #fdcb6e;">
                <div> </div>
                <div class="">
                  <h3 class="mb-4">Top Colleges</h3>
                  <div class="table-responsive">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Name </th>
                        <th scope="col">Score </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $k }}">
                      @foreach($data['colleges'] as $college => $score)
                      <tr>
                        <td class="{{ $k++}}">{{ $college }}</td>
                        <td> {{ $score }}</td>
                      </tr>
                      @if($k==6)
                      @break
                      @endif
                      @endforeach    
                    </tbody>
                  </table>
                </div>
                </div>
              </div>
            </div>


            <div class="card">
              <div class="card-body " style="background:#dfe6e9; border:1px solid #b2bec3;">
                <div> </div>
                <div class="">
                  <h3 class="mb-4">Top Ambassadors &nbsp;
                    <a href="{{ route('ambassador.list') }}">
                      <button class="btn btn-outline-dark btn-sm">view all</button>
                    </a>
                  </h3>
                  <div class="table-responsive">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Name </th>
                        <th scope="col">College</th>
                        <th scope="col">Score </th>
                        <th scope="col">Level </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $j}}">
                      @foreach($data['users'] as $user => $score)
                      <tr>
                        <td class="{{ $j++}}">{{ $user }}</td>
                        <td> {{ $data['coll'][$user] }}</td>
                        <td> {{ $score }}</td>
                        <td> @if($score > 49 && $score < 80)
                            <div class="bg-white p-2 border rounded text-secondary"><i class ="fa fa-shield"></i> Silver</div>
                            @elseif($score > 79 && $score < 100)
                            <div class="bg-white p-2 border rounded text-success"><i class ="fa fa-graduation-cap"></i> Gold</div>

                            @elseif($score > 99 )
                            <div class="bg-white p-2 border rounded text-primary"><i class ="fa fa-trophy"></i> Platinum</div>

                            @else
                            <div class="text-secondary"> - </div>
                            @endif

                        </td>
                      </tr>
                      @if($j==6)
                      @break
                      @endif
                      @endforeach    
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