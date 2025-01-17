
<div class="list-group">
	<a href="{{ route('exam.show',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug) ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-inbox"></i> Test Home 
	</a>

	<a href="{{ route('sections.index',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug.'/sections*') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-bars"></i> Sections ({{count($exam->sections)}})
	</a>
	<a href="{{ route('exam.questions',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug.'/question*') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-gg"></i> Questions ({{$exam->questionCount()}})
	</a>

	<a href="{{ route('test.accesscode',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('test/'.$exam->slug.'/accesscode*') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-bar-chart"></i> Reports ({{$exam->getUserCount()}})
	</a>
	
</div>