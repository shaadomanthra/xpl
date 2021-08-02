 @extends('layouts.nowrap-white')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@include('appl.exam.exam.xp_css')

 <style>.baseline{padding-top:3px;background:silver;border-radius: 5px;margin:5px 0px 15px;width:30%;}
.cardgreen{background-image: linear-gradient(to bottom right, #fff, white);border:2px solid #eee;margin-bottom: 15px;}
.dblue2{ background: #f2fff9;border-bottom:2px solid #beedd6; }</style>
<div class="dblue2">
<div class="container py-4 ">
  @include('appl.exam.assessment.blocks.breadcrumbs')
 <div class="row mb-4">
          @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg'))
          <div class="col-4 col-md-2">
            <img src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg')}}" class="w-100 rounded " />
          </div>
          @endif
          <div class="col-12 col-md">
            <h1 class="mb-0">{{$student->name}}</h1>
              <p><i class="fa fa-bars"></i> {{$exam->name}}</p>
            <div class="row mb-0">
              <div class="col-4"> Email:</div>
              <div class="col-8">{{$student->email}}</div>
            </div>
            <div class="row mb-0">
              <div class="col-4"> Phone:</div>
              <div class="col-8">{{$student->phone}}</div>
            </div>
            @if($student->college_id)
            <div class="row mb-0">
              <div class="col-4"> College:</div>
              <div class="col-8">{{$student->college->name}}</div>
            </div>
            @endif
            @if($student->branch_id)
            @if($student->branch)
            <div class="row mb-0">
              <div class="col-4"> Branch:</div>
              <div class="col-8">{{$student->branch->name}}</div>
            </div>
            @endif
            @endif
            @if($student->roll_number)
            <div class="row mb-0">
              <div class="col-4"> Roll Number:</div>
              <div class="col-8">{{$student->roll_number}}</div>
            </div>
            @endif
            <br>

            <div class="row mb-0 ">
              <div class="col-4"> Number of images uploaded:</div>
              <div class="col-8 h3">{{$images_count}}</div>
            </div>
            
          

           
          </div>
         

        </div>
</div>
</div>

<style>
.main-ct {
  width: 1000px;
  height:600px;
  border: 1px solid #000;
  position:relative;
}
.fixed-ct {
  position: sticky;
  width:100px;
  height:20px;
  background: red;
  top:10px;
}
.like-body {
  width: 100%;
  height:1300px;
}
.item {
  position: sticky;
}


.fixed {
  top: 0;
  background: white;
}
</style>

<div class="container my-4">
  <h3 class="mb-4"> Response Status</h3>
  <table class="table table-bordered bg-light">
  <thead>
    <tr>
      <th scope="col">Qno</th>
      <th scope="col">Type</th>
      <th scope="col">Response</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  @foreach($questions as $k=>$question)
  <tr>
      <th scope="row">{{$k+1}} </th>
        <td>@if($question->type=='urq') Images upload question @else{{$question->type}}@endif </td>
      <td>@if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
          <div class=""><div class="pt-1 d-inline "> {!!$resp[$question->id]['response'] !!}</div></div>
          @else
           @if(isset($images[$question->id]))
        images - {{count($images[$question->id])}}
          @else
          -
        @endif
          @endif
          @else
          -
          @endif

         

        </td>
        <td>
          @if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
            <span class="text-success"><i class="fa fa-check-circle"></i> Attempted</span>
          @else
           @if(isset($images[$question->id]))
           @if(count($images[$question->id]))
            <span class="text-success"><i class="fa fa-check-circle"></i> Attempted</span>
            @else
              <span class="text-danger">Not Attempted</span>
            @endif
          @else
           <span class="text-danger">Not Attempted</span>
        @endif
          @endif
          @else
            <span class="text-danger">Not Attempted</span>
          @endif
          
        </td>
      
    </tr>
  @endforeach
  </tbody>
  </table>

 
  <h3 class="mt-5 mb-4"> User Response Sheet</h3>
  @foreach($questions as $k=>$question)
  <div class="card my-2">
    <div class="card-body">

      <div class=" py-3">
        <div class=" p-1 px-3 mr-2 rounded text-center bg-light border d-inline ">{{($k+1)}}</div>
        <p class="d-inline {{ $t= $question}} mb-3">{!! $question->question !!}</p>
      </div> 
        @if($question->type=='mcq')
        
          <span class="badge badge-primary h4">MCQ</span>

          @if($question->a)
          <div class=""><span class="">(A)</span><div class="pt-1 d-inline "> {!! $question->a!!}</div></div>
          @endif

          @if($question->b)
          <div class=""><span class="">(B)</span><div class="pt-1 d-inline "> {!! $question->b!!}</div></div>
          @endif

          @if($question->c)
          <div class=""><span class="">(C)</span><div class="pt-1 d-inline "> {!! $question->c!!}</div></div>
          @endif

          @if($question->d)
          <div class=""><span class="">(D)</span><div class="pt-1 d-inline "> {!! $question->d!!}</div></div>
          @endif

          @if(trim($question->e)!='')
          <div class=""><span class="">(E)</span><div class="pt-1 d-inline "> {!! $question->e!!}</div></div>
          @endif

          <hr>
          <h3>User Response</h3>
          @if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
          <div class=""><div class="pt-1 d-inline "> {!!$resp[$question->id]['response'] !!}</div></div>
          @else
          - 
          @endif
          @else
          -
          @endif

        @elseif($question->type=='sq')
          <span class="badge badge-primary h4">SQ</span>

           <hr>
          <h3>User Response</h3>
          @if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
          <div class=""><div class="pt-1 d-inline "> {!!$resp[$question->id]['response'] !!}</div></div>
          @else
          - 
          @endif
          @else
          -
          @endif

        @elseif($question->type=='fillup')
          <span class="badge badge-primary h4">Fillup</span>

           <hr>
          <h3>User Response</h3>
          @if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
          <div class=""><div class="pt-1 d-inline "> {!!$resp[$question->id]['response'] !!}</div></div>
          @else
          - 
          @endif
          @else
          -
          @endif
        @elseif($question->type=='maq')
          <span class="badge badge-primary h4">Multi Answer</span>
          @if($question->a)
          <div class=""><span class="">(A)</span><div class="pt-1 d-inline "> {!! $question->a!!}</div></div>
          @endif

          @if($question->b)
          <div class=""><span class="">(B)</span><div class="pt-1 d-inline "> {!! $question->b!!}</div></div>
          @endif

          @if($question->c)
          <div class=""><span class="">(C)</span><div class="pt-1 d-inline "> {!! $question->c!!}</div></div>
          @endif

          @if($question->d)
          <div class=""><span class="">(D)</span><div class="pt-1 d-inline "> {!! $question->d!!}</div></div>
          @endif

          @if(trim($question->e)!='')
          <div class=""><span class="">(E)</span><div class="pt-1 d-inline "> {!! $question->e!!}</div></div>
          @endif

           <hr>
          <h3>User Response</h3>
          @if(isset($resp[$question->id]['response']))
          @if(trim($resp[$question->id]['response'])!='')
          <div class=""><div class="pt-1 d-inline "> {!!$resp[$question->id]['response']!!}</div></div>
          @else
          - 
          @endif
          @else
          - 
          @endif

        @elseif($question->type=='urq')
       
          <span class="badge badge-success h5">Image Upload Question</span>
          @if(isset($images[$question->id]))
          @if(count($images[$question->id]))
          <span class="badge badge-secondary h5">Images - {{count($images[$question->id])}} </span>
            @else
          <span class="badge badge-secondary h5">Images - {{count($images[$question->id])}} </span>
          @endif

          @endif
     
        @endif
       

          @if($question->type=='urq')
          <hr>
           <h3>User Response</h3>
          <div class="{{$w=0}}">

          @if(isset($images[$question->id]))
          @if(count($images[$question->id]))
            @foreach($images[$question->id] as $k=>$url)
            <div class=" {{$w=$w+1}}">
                <img src="{{$url}}" class="w-100 mb-4 border" />
            </div>
            @endforeach
          @else
            -
          @endif

          @else
          
          -
          @endif

         
          </div>
         @endif 
    </div>
  </div>
  @endforeach
</div>

@endsection