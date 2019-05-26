

@if(\auth::user())

@if(\auth::user()->checkRole(['tpo']))
<div class=" bg-info mb-3 text-white rounded"><div class="p-3 font-weight-bold">Campus Admin</div>
<div class="list-group mb-3">
	<a href="{{ route('campus.admin')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/admin*') ? 'active' : '' }}">
		<i class="fa fa-home"></i> Home
	</a>
	<a href="{{ route('campus.courses')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/courses*') ? 'active' : '' }}">
		<i class="fa fa-navicon"></i> Courses
	</a>
	<a href="{{ route('campus.tests')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/tests*') ? 'active' : '' }}">
		<i class="fa fa-share-square-o "></i> Tests
	</a>
	<a href="{{ route('batch.index')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/batches*') ? 'active' : '' }}">
		<i class="fa fa-th"></i> Batches
	</a>	
	<a href="{{ route('campus.students')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/students*') ? 'active' : '' }}">
		<i class="fa fa-users"></i> Students
	</a>
</div>
</div>
@endif


<!--

<div class=" bg-warning mb-3  rounded"><div class="p-3 font-weight-bold">Campus</div>
<div class="list-group">
	<a href="{{ route('campus.main')}}" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus') ? 'active' : '' }}">
		<i class="fa fa-home"></i> Home
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus/course*') ? 'active' : '' }}">
		<i class="fa fa-navicon"></i> Courses
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus/Leaderboard*') ? 'active' : '' }}">
		<i class="fa fa-trophy"></i> Leaderboard
	</a>
</div>
</div>
-->

@endif