@extends('layouts.app')
@section('content')

<div class="d-none d-md-block">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.index')}}">Courses</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.show',$project->slug)}}">{{ $details['course']->name }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.category.video',[$project->slug,$category->slug])}}">{{ $category->name }}</a></li>
      <li class="breadcrumb-item">Q{{ $details['qno'] }}</li>
    </ol>
  </nav>
</div>
<div class="d-block d-md-none mb-3">
  <div class="bg-light border rounded p-2 pl-3">
    <a href="{{ route('course.show',$project->slug)}}#{{$category->slug}}"><i class="fa fa-angle-double-left"></i> {{ $details['course']->name }}</a>
    
  </div>
</div>

<div class="d-block d-md-none mb-3">
  <div class="bg-light border rounded p-3">
    <div class="row ">
      <div class="col-3">
        @if($details['prev'])
        <a href="{{ $details['prev'] }}">
        <div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
        </a>
        @endif
      </div>
      <div class="col-6"> <div class="mt-1 text-center">Q({{$details['qno']}}/{{ count($questions) }})</div></div>
      <div class="col-3"> 
        @if($details['next'])
        <a href="{{ $details['next'] }}">
        <div class=" w100 p-1 text-center mr-3"><i class="fa fa-angle-double-right"></i></div>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@include('flash::message')

<form method="post" action="{{route('course.question',[$project->slug,$category->slug,$question->id])}}" >
  <div class="row">

    <div class="col-md-9">

      @if($passage)
      <div class="card mb-3">
        <div class="card-body">
          <b>Passage</b> <span class="btn view badge badge-warning" data-item="passage">view</span><br>
          <div class="passage" style="display: none;">
          {!! $passage->passage !!}
          </div>
        </div>
      </div>
      @endif
      <div class="card  mb-3">
        <div class="card-body ">
          
        <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 " >
        			<div class="text-center p-1 rounded  w100 @if(!$details['response']) qyellow @else @if($details['response']->accuracy ==1) qgreen @else qred @endif @endif "  style="">
        				{{ $details['qno'] }}
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div>

          

        </div>
        </div>

        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100  {{ $question->color($details['response'],'A')}}" >
                @if(!$details['response']) 
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="A"> @endif A </div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 a">{!! $question->a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 {{ $question->color($details['response'],'B')}}" >
                @if(!$details['response'])
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="B"> @endif B</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 {{ $question->color($details['response'],'C')}}" >
                @if(!$details['response'])
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="C"> @endif C</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">{!! $question->c!!}</div></div>
        </div>
        @endif
        
        @if($question->d)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 {{ $question->color($details['response'],'D')}}" >
                @if(!$details['response'])
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="D">
                @endif D</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 d">{!! $question->d!!}</div></div>
        </div>
        @endif

        @if($question->e)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3" >
        	<div class="text-center p-1 rounded bg-light w100 {{ $question->color($details['response'],'E')}}" > 
                @if(!$details['response'])
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="E">@endif 
                E
              </div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->e!!}</div></div>
        </div>
        @endif
         
        </div>
      </div>

      <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="course_id" value="{{ $details['course']->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
    @if(!$details['response'])
    <div class="card mb-3">
          <div class="card-body">
        <button type="submit" class="btn btn-lg btn-success ">
          Submit 
      </button>
    </div>
    </div>
    @endif

      @if($question->answer && $details['response'])
      <div class="card mb-3 ">
      	<div class="card-body">
      		<h3>Answer</h3>
      		<div class="answer">{!! $question->answer !!}</div>
      	</div>
      </div>
      @endif

      @if($question->explanation && $details['response'])
      <div class="card mb-3 mb-md-0">
      	<div class="card-body">
      		<h3>Explanation</h3>
      		<div class="explanation">{!! $question->explanation !!}</div>
      	</div>
      </div>
      @endif

      @if( $details['response'])
      <div class=" mt-3 border p-4 rounded mb-3">
        @include('appl.pages.disqus')
      </div>
      @endif

    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.qset-course')
    </div>

  </div> 


</form>


@endsection