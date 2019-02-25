@extends('layouts.nowrap-product')
@section('title', 'Interns Connect | PacketPrep')
@section('description', 'This page is about interns connect')
@section('keywords', 'college,packetprep,campus connect,internship')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-university"></i> &nbsp; Interns Connect
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
          

                <h1> Intern Generalist</h1>
                <div class=" rounded text-white p-3" style="background: #e17055">
                  <h3>Coins</h3>
                  <div class="display-1">{{  $data['my_score']}} </div>
                  

                  <h3> My Level</h3>
                  <div class="">
                    @if($data['my_score'] > 0 && $data['my_score'] < 300)
                            <div class="bg-white p-2 border text-secondary  rounded display-3"> D </div>
                            <div class="text-light mt-2" style="opacity:0.5"> another {{(300-$data['my_score'])}} coins to reach level C</div>
                            @elseif($data['my_score'] > 299 && $data['my_score'] < 600)
                            <div class="bg-white p-2 border text-success rounded display-3"> C</div>

                            <div class="text-light mt-2" style="opacity:0.5">another {{(600-$data['my_score'])}} coins to reach level B</div>
                            @elseif($data['my_score'] > 599 && $data['my_score'] < 1000)
                            <div class="bg-white p-2 border text-success rounded display-3"> B</div>

                            <div class="text-light mt-2" style="opacity:0.5">another {{(1000-$data['my_score'])}} coins to reach level A</div>
                            @elseif($data['my_score'] > 1000 )
                            <div class="bg-white p-2 border text-primary rounded display-3"> A </div>

                            <div class="text-light mt-2" style="opacity:0.5">You are shortlisted for Interns Specialist Poistion</div>
                            @endif
                  </div>

                </div>

             
              </div>
            </div>
            <div class=" mt-4 border p-3 mb-3"><h3>Instructions</h3>
           <a class="btn btn-outline-primary btn-sm" href="{{ route('intern.generalist') }}">Intern Generalist</a></div>
        </div>
        <div class="col-12 col-md-8">
            


            <div class="card mb-4" style="background:#dfe6e9; border:1px solid #b2bec3;">
              <div class="card-body " >
                <div> </div>
                <div class="">
                  <h3 class="mb-4">Your Ambassadors &nbsp;
                    <a href="{{ route('ambassador.list') }}">
                      <button class="btn btn-outline-dark btn-sm">view all</button>
                    </a>
                  </h3>
                  @if(count($data['users']))
                  <div class="table-responsive">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Name </th>
                        <th scope="col">College</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Score </th>
                        <th scope="col">Level </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $j}}">
                      @foreach($data['users'] as $user => $score)
                      <tr>
                        <td class="{{ $j++}}">{{ $user }}</td>
                        <td> {{ $data['coll'][$user] }} </td>
                        <td>{{ $data['branch'][$user] }}</td>
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
                      @endforeach    
                    </tbody>
                  </table>
                </div>
                @else
                  <p>- No data -</p>
                @endif
                </div>
              </div>
            </div>


            <div class="card mb-4">
              <div class="card-body " style="background: #f7f1e3; border:1px solid #fdcb6e;">
                <div> </div>
                <div class="">
                  <h3 class="mb-4">Intern Generalists</h3>
                  <div class="table-responsive">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Name </th>
                        <th scope="col">College</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Coins </th>
                        <th scope="col">Level </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $j}}">
                      @foreach($data['intern_generalist'] as $user => $score)
                      <tr>
                        <td class="{{ $j++}}">{{ $user }}</td>
                        <td> {{ $data['colls'][$user] }}</td>
                        <td>{{ $data['branches'][$user] }}</td>
                        <td> {{ $score }}</td>
                        <td> 
                        @if($score > 0 && $score < 300)
                            <div class="text-secondary"> D </div>
                        @elseif($score > 299 && $score < 600)
                            <div class="text-secondary"> C </div>
                        @elseif($score > 599 && $score < 1000)
                           <div class="text-secondary"> B </div>
                        @elseif($score > 1000 )
                            <div class="text-secondary"> A </div>
                        @endif
                        </td>
                      </tr>
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