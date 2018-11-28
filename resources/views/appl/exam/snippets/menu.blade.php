
<div class="list-group">
	<a href="{{ route('exam.show',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug) ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-inbox"></i> Exam Home 
	</a>

	<a href="{{ route('sections.index',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug.'/sections*') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-bars"></i> Sections
	</a>
	<a href="{{ route('exam.questions',$exam->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('exam/'.$exam->slug.'/question*') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-bars"></i> Questions
	</a>
	
</div>