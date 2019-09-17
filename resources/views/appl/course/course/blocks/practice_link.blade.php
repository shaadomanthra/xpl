@auth
<a href="{{ route('course.question',[$course->slug,$c->slug,''])}}">
@else
<a href="#" data-toggle="modal" data-target="#myModal2">
@endauth
	<span class="badge badge-warning">Practice {{($categories->$cid->correct + $categories->$cid->incorrect) }} / {{$categories->$cid->total }}</span>
</a>