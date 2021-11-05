<div class="card mb-3 d-none d-md-block blogd" style="background:#ca2428">
	<div class="card-body">
		<div class="text-bold " style="color:#da737f">Exam</div>
		<a class="white-link" href="{{ route('exam.show',$exam->slug)}}">
		<h2>
		{{ $exam->name }}
		</h2>
		</a>
		<br>

		<div class="p-2 mb-2 rounded text-white" style="border:2px solid #bb061c">
		<div class="row ">
			<div class="col-3">
				@if($details['prev'])
				<a class="white-link" href="{{ $details['prev'] }}">
				<div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
				</a>
				@endif
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
			<div class="col-3"> 
				@if($details['next'])
				<a class="white-link" href="{{ $details['next'] }}">
				<div class=" w100 p-1 text-center mr-3"><i class="fa fa-angle-double-right"></i></div>
				</a>
				@endif
			</div>
		</div>
		</div>
		<div class="qset" style="height: 380px;overflow-y: auto;">
		<div class="{{ $i=1}}">

			
			@foreach($exam->sections as $section)
				<div class="mb-1 pb-2 " style="background:#b91427; color:white;border: 1px solid #ab0014;padding:3px;border-radius:4px;"><div class="p-1 ">{{$section->name}}  &nbsp;&nbsp;
@can('update',$question)
<div class="btn-group float-right " role="group" aria-label="Button group with nested dropdown float-right">

  <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-danger float-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Add
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=mcq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Multi Choice Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=maq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Multi Answer Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=fillup&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Fillup Question</a>

      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=mbfq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Multiblank Fillup Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=mbdq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Multiblank Dropdown Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=sq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Subjective Question</a>
      	<a class="dropdown-item" href="{{ route('question.create','default')}}?type=csq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Code Submission Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=urq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">User Response Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=vq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Video Question</a>
      <a class="dropdown-item" href="{{ route('question.create','default')}}?type=aq&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Audio Question</a>
      @if(\auth::user()->checkRole(['administrator']))
       <a class="dropdown-item" href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Code Question</a>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 || \auth::user()->role ==13 )
       <a class="dropdown-item" href="{{ route('question.create','default')}}?type=code&default=1&exam={{$exam->id}}&section={{$section->id}}&url={{url()->current()}}">Code Question</a>
        @else
        @endif
    </div>
  </div>
</div>
@endcan
</div>

</div>

				<div class="row no-gutters">

				@foreach($section->questions as $k=> $q)
				<div class="col-3 mb-1">
				<a class="white-link" href="{{ route('exam.question',[$exam->slug,$q->id]) }}">
				<div class="pr-1">
				<div class="w100 p-1 text-center rounded @if($q->id==$question->id) active @endif 
					 qborder  " id="q{{ ($q->id )}}"
				    >{{ ($i++ ) }}</div>
				</div>
				</a>
			</div>
				@endforeach
				</div>
			@endforeach
		</div>
		</div>



	</div>
</div>

<div class="p-3 border rounded bg-white">
		<a href="{{ route('test.questionlist',$exam->slug)}}"><h4 class="mb-0"><i class="fa fa-bars"></i> Question list</h4></a>
		</div>

