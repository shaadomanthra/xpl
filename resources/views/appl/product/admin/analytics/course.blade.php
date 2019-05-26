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
			<i class="fa fa-university"></i> &nbsp; Analytics <span class="badge badge-warning">{{ ($data['course']) ? $data['course']->name : '-NA-' }} </span>
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
      <div class="col-12 col-md-12 ">
        <div class="bg-white rounded p-4 border mb-4">
            <h3 class="mb-4"> Questions Practiced </h3>
            <hr>
            <div class="display-1 mb-4">{{ $data['practice_score']}}</div>
            
            @if(count($data['practice_top']))
            <div class="table table-responsive">
              <table class="table">
                <thead>
                  <tr class="border">
                    <th scope="col" class="border border-dark">#</th>
                    <th scope="col" class="border border-dark">Top Student</th>
                    <th scope="col" class="border border-dark">College</th>
                    <th scope="col" class="border border-dark">Solved</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['practice_top'] as $k=>$p) 
                  <tr>
                    <td scope="row">{{ ($k+1) }}</td>
                    <td> {{ $p->user->name }}</td>
                    <td>@if($p->user()->first()->colleges()->first())
                      <a href="{{ route('campus.admin')}}?college={{ $p->user()->first()->colleges()->first()->id }}">{{ $p->user()->first()->colleges()->first()->name }}</a>
                        @endif - 
                        @if($p->user()->first()->branches()->first())
                        {{$p->user()->first()->branches()->first()->name}}
                        @endif</td>
                    <td>{{ $p->attempted }}</td>
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
            @else
              <div class=" border p-3">No data to show</div>
            @endif
        </div>

        <div class="bg-white rounded p-4 border ">
            <h3 class="mb-4"> Test Questions Solved</h3>
            <hr>
            <div class="display-1 mb-4">{{ $data['tests_score']}}</div>
            
            @if($data['tests_top'])
            <div class="table table-responsive">
              <table class="table">
                <thead>
                  <tr class="border">
                    <th scope="col" class="border border-dark">#</th>
                    <th scope="col" class="border border-dark">Top Student</th>
                    <th scope="col" class="border border-dark">College</th>
                    <th scope="col" class="border border-dark">Correct</th>
                    <th scope="col" class="border border-dark">Solved</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach($data['tests_top'] as $k=>$t) 
                  <tr>
                    <td scope="row">{{ ($k+1) }}</td>
                    <td>{{ $t->user->name }}</td>
                    <td>@if($t->user->colleges()->first())
                        <a href="{{ route('campus.admin')}}?college={{ $t->user->colleges()->first()->id }}">{{ $t->user->colleges()->first()->name }}</a>
                        @endif - 
                        @if($t->user->branches()->first())
                        {{$t->user->branches()->first()->name}}
                        @endif</td>
                    <td>{{ $t->correct }}</td>
                    <td>{{ $t->sum }}</td>
                  </tr>
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