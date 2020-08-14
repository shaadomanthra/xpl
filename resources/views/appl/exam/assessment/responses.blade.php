@extends('layouts.nowrap-white')
@section('title', 'Responses - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">



    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">

      	    @if(auth::user()->checkRole(['hr-manager','admin']))
<nav class="mb-0">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}?student={{request()->get('student')}}">{{$student->name}} - Report </a></li>
    <li class="breadcrumb-item">Responses </li>
  </ol>
</nav>
@elseif($exam->slug != 'proficiency-test')
<nav class="mb-0">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Report </li>
  </ol>
</nav>
@else
<nav class="mb-0">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proficiency_test') }}">Proficiency Test</a></li>
    <li class="breadcrumb-item">Analysis  </li>
  </ol>
</nav>
@endif
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> {{$student->name}}


          </p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Total Score</div>
          <div class="score_main" >
          	@if(!$test_overall->status)
			<div class="">{{ $test_overall->score }} </div>
			@else
			<div class="badge badge-primary under_review_main" >Under <br>Review</div>
			@endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>
<div class="p-3 text-center bg-light sticky-top" id="item" style="margin-top:-2px;">

  @foreach($tests as $i=>$t)
<span class="border rounded p-1 px-2 @if($t->status!=2)qgreen @else qyellow @endif cursor qno_{{$t->question_id}}" href="#item{{($i+1)}}">{{($i+1)}}</span>
@endforeach
</div>




<div class="container my-3" id="wrapper">
@foreach($tests as $k=>$t)
<div class="row" id="item{{($k+1)}}">
	<div class="col-1 col-md-1">
		<div class=" p-2 rounded text-center bg-light border">{{($k+1)}}</div>
	</div>
	<div class="col-11 col-md-8">
		<div class="card mb-3">
			<div class="card-body">
				{!! $questions[$t->question_id]->question !!}
				<hr>
				<p><b>Response:</b></p>
					@if($questions[$t->question_id]->type=='urq')
          <div class="{{$w=0}}">

          @if(isset($questions[$t->question_id]->images))

          @if(count($questions[$t->question_id]->images))
          @foreach(array_reverse($questions[$t->question_id]->images) as $k=>$url)

             <div class="border border-secondary {{$w=$w+1}}">
              <a href="#" id="{{$k}}" class="@if(auth::user()->checkRole(['hr-manager','administrator'])) correct_image @endif" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}" data-id="{{$t->question_id}}_{{$w}}"><img src="{{$url }}"  class=" p-1  my-1 w-100 img_{{$t->question_id}}_{{$w}}" data-name="{{$k}}" />
              </a>
              @if(auth::user()->checkRole(['hr-manager','administrator']))
              <a href="#" class="btn btn-outline-primary my-2 mr-1 ml-1 rotate_save" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=90&name={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}" >left <i class="fa fa-rotate-left"></i></a>

              <a href="#" class="btn btn-outline-primary my-2 mr-1 ml-1 rotate_save" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=-90&name={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}">right <i class="fa fa-rotate-right"></i></a>

               <div class="d-flex align-items-center float-right p-3" >
  <div class="spinner-border spinner-border-sm   img_loading_{{$t->question_id}}_{{$w}}"  style="display:none" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

              <a href="#" class="btn btn-outline-success my-2 correct_image  correct_image_{{$t->question_id}}_{{$w}} ml-1" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-id="{{$t->question_id}}_{{$w}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}"> <i class="fa fa-pencil"></i> pen</a>
              @endif
          </div>

          @endforeach
          @else
            -
          @endif

          @else
          -

          @endif

          
          </div>
       
      	@else

          @if(trim(strip_tags($t->response)))
        	{!! $t->response !!} 
          @else
          -
          @endif
      	@if($t->accuracy)
      		@if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')

	      		@if(!$t->mark)
	      		<i class="fa fa-times-circle text-danger"></i>
	      		@else
	      		<i class="fa fa-check-circle text-success"></i>
	      		@endif
      		@else
      		<i class="fa fa-check-circle text-success"></i>
      		@endif
      	@else

      		@if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')
      		<i class="fa fa-times-circle text-danger"></i>
      		@else
      			@if($t->mark==0 && $questions[$t->question_id]->type!='urq' && $questions[$t->question_id]->type!='sq')

	      		<i class="fa fa-times-circle text-danger"></i>
	      		@endif
      		@endif
      	@endif
      	@endif
			</div>
		</div>
	</div>

	<div class="col-12 col-md-3">
    <div class="mt-3">
		<div class=" rounded @if($t->status!=2)qgreen @else qyellow @endif mb-3 mt-3 box_{{$t->question_id}}">
			<div class="card-body ">

				<p>Status: @if($t->status==2)<span class="badge badge-warning review_{{$t->question_id}}">under review</span>
				@else
				<span class="badge badge-success">evaluated</span>
				@endif</p>
				<hr>
				<b>Score</b><br>
				@if($t->status==2)
	<div class="mb-3 score_entry_{{$t->question_id}}">
      @foreach(range(0,$questions[$t->question_id]->mark,0.5) as $r)
        <div class="form-check form-check-inline">
        <input class="form-check-input score_{{$t->question_id}}" type="radio" name="score_{{$t->question_id}}" id="" value="{{$r}}" @if($t->mark==$r)checked @endif>
        <label class="form-check-label" for="inlineRadio1">{{$r}}</label>
      </div>
      @endforeach
      <div class="my-2"><b>Feedback</b></div>
      <textarea class="form-control comment_{{$t->question_id}}" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
  <div class="d-flex align-items-center float-right">
  <div class="spinner-border spinner-border-sm  float-right loading_{{$t->question_id}}"  style="display:none" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>
      <button class="btn btn-primary btn-sm score_save score_save_{{$t->question_id}}" data-id="{{$t->question_id}}" data-slug="{{$exam->slug}}"  data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?ajax=1" data-student="{{request()->get('student')}}" data-token="{{csrf_token()}}">save</button>
     @else
     {{$t->mark}}

     @if($t->comment)
     <div class="my-2"><b>Feedback</b></div>
     <p>{{$t->comment}}</p>
     @endif
     @endif

			</div>
		</div>
  </div>
	</div>
</div>
@endforeach



    
	

</div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Correct Paper</h1>
        <button type="button" class="btn btn-danger clear_image float-right d-inline">clear</button>
        <button type="button" class="btn btn-primary save_image float-right d-inline" data-url="{{ route('assessment.solutions.q.post',[$exam->slug,11])}}?student={{request()->get('student')}}" data-name="" data-imgurl="" data-student="{{request()->get('student')}}" data-token="{{ csrf_token() }}" data-user_id="{{ $student->id }}" data-slug="{{$exam->slug}}"  data-qid="11" data-id="" data-width="1100" data-height="">
          Save
        </button>
      </div>
      <div class="modal-body">
        <div class="canvas_message"></div>
        <div class="canvas">
        
      </div>
        <img id="image_display" style="display: none">
      </div>
    </div>
  </div>
</div>



@endsection           