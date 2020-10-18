@extends('layouts.nowrap-white')
@section('title', 'Set Creator - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>

            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Set Creator </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">

        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-bars "></i> Set Creator
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">
  <div  class="  mb-4 mt-4">
    @if($data['level'] != 0 || $data['no_topic'] != 0)
     <div class="alert alert-important alert-warning">
       <h3><span class="badge badge-warning">Important !</span></h3>
       <div>To create question paper set, it is mandatory to assign question levels & topics </div>
       <hr>
       <p><b>Questions Count:</b> {{$data['qcount']}} &nbsp; &nbsp; &nbsp; <b>No Topics Count:</b> {{$data['no_topic']}} &nbsp; &nbsp; &nbsp; <b>No Level Count:</b> {{$data['level']}} </p>
     </div>
    @else
    <form method="post" action="{{route('test.sets',$exam->slug)}}" enctype="multipart/form-data">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Sections</th>
          <th scope="col">Paper Structure</th>
        </tr>
      </thead>
      <tbody>
        @foreach($exam->sections as $m=>$sec)

        <tr>
          <th scope="row">{{$m+1}}</th>
          <td>{{$sec->name}} [{{$sec->id}}]</td>
          <td>

            
             <label for="formGroupExampleInput ">Algorithm</label><textarea class="form-control summernote" name="{{$sec->id}}"  rows="5">@if($sec->instructions) {{json_encode(json_decode($sec->instructions), JSON_PRETTY_PRINT)}} @endif</textarea>
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-primary" type="submit">Save</button>
    <a href="{{route('test.sets',$exam->slug)}}?delete=1" class="btn btn-danger" >Delete</a>
    </form>


    @endif

    @if(count($paper_sets))
    <div class="bg-light p-3 border my-3">

       <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Set</th>
          <th scope="col">Count</th>
          <th scope="col">Question Ids</th>
        </tr>
      </thead>
      <tbody>
        @foreach($paper_sets as $i=>$set)

        <tr>
          <td scope="row">{{$i}}</td>
          <td scope="row">{{$paper_count[$i]}}</td>
          <td><pre><code class="text-light">  {{ json_encode($set,JSON_PRETTY_PRINT) }}</code></pre></td>
        </tr>
        @endforeach

      </tbody>
    </table>

    </div>
    @else
    <div class="bg-light p-3 border my-3">
        No question paper sets created.
    </div>

    @endif


  </div>
</div>


@endsection
