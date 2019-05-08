

@if(\auth::user())

@if(\auth::user()->checkRole(['tpo']))
<div class=" bg-info mb-3 text-white rounded"><div class="p-3 font-weight-bold">Admin</div>
<div class="list-group mb-3">
	<a href="{{ route('campus.admin')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/admin*') ? 'active' : '' }}">
		<i class="fa fa-home"></i> Home
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-info @if(request()->is('/campus/programs*')) active @endif">
		<i class="fa fa-navicon"></i> Courses
	</a>
	<a href="{{ route('batch.index')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/batches*') ? 'active' : '' }}">
		<i class="fa fa-th"></i> Batches
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/schedule*') ? 'active' : '' }}">
		<i class="fa fa-calendar"></i> Schedule
	</a>
	
	<a href="{{ route('campus.students')}}" class="list-group-item list-group-item-action list-group-item-info {{ request()->is('campus/students*') ? 'active' : '' }}">
		<i class="fa fa-users"></i> Students
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-info">
		<i class="fa fa-gear"></i> Settings
	</a>
</div>
</div>
@endif



<div class=" bg-warning mb-3  rounded"><div class="p-3 font-weight-bold">Campus</div>
<div class="list-group">
	<a href="{{ route('campus.main')}}" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus') ? 'active' : '' }}">
		<i class="fa fa-home"></i> Home
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus/course*') ? 'active' : '' }}">
		<i class="fa fa-navicon"></i> Courses
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus/schedule*') ? 'active' : '' }}">
		<i class="fa fa-calendar"></i> Schedule
	</a>
	<a href="" class="list-group-item list-group-item-action list-group-item-warning {{ request()->is('campus/Leaderboard*') ? 'active' : '' }}">
		<i class="fa fa-trophy"></i> Leaderboard
	</a>
</div>
</div>

@endif