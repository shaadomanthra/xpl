@auth
<a href="{{ route('course.question',[$course->slug,$c->slug,''])}}">
@else
<a href="#" data-toggle="modal" data-target="#myModal2">
@endauth
	<span class="badge badge-warning">
		@if(isset($categories->$cid))
		Practice {{($categories->$cid->correct + $categories->$cid->incorrect) }} / {{$categories->$cid->total }}
		@elseif(isset($categories[$cid]))
		Practice {{($categories[$cid]['correct'] + $categories[$cid]['incorrect']) }} / {{$categories[$cid]['total'] }}
		@endif
	</span>
</a>

@if(\auth::user())
   @if(\auth::user()->isSiteAdmin() )
       @if($bno)
			<a href="{{ route('course.analytics',$course->slug)}}?topic={{$c->slug}}&batch={{$bno}}" class="mx-2"> <i class="fa fas fa-bar-chart" ></i> All</a>
		@else
			<a href="{{ route('course.analytics',$course->slug)}}?topic={{$c->slug}}" class="mx-2"> <i class="fa fas fa-bar-chart" ></i> All </a>
		@endif
	@endif
@endif