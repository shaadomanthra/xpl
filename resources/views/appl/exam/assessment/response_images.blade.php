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
  @foreach($questions as $k=>$question)
  <div class="card my-2">
    <div class="card-body">

      <div class=" py-3">
        <div class=" p-1 px-3 mr-2 rounded text-center bg-light border d-inline ">{{($k+1)}}</div>
        <p class="d-inline {{ $t= $question}} mb-3">{!! $question->question !!}</p>
      </div> 
        @if($question->type=='mcq')
        
          <span class="badge badge-primary h4">MCQ</span>
        @elseif($question->type=='fillup')
          <span class="badge badge-primary h4">Fillup</span>
        @elseif($question->type=='maq')
          <span class="badge badge-primary h4">Multi Answer</span>
        @elseif($question->type=='urq')
       
          <span class="badge badge-success h5">Image Upload Question</span>
     
        @endif
       

          @if($question->type=='urq')
          <div class="{{$w=0}}">

          @if(isset($images[$question->id]))
          @if(count($images[$question->id]))
            @foreach(array_reverse($images[$question->id]) as $k=>$url)
            <div class=" {{$w=$w+1}}">
                <img src="{{$url}}" class="w-100 mb-2" />
            </div>
            @endforeach
          @else
            
          @endif

          @else
          

          @endif

         
          </div>
         @endif 
    </div>
  </div>
  @endforeach
</div>

@endsection