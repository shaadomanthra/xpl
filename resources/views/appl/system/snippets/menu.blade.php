
<div class="list-group mb-3">
	<a href="{{ route('system')}}" class="list-group-item list-group-item-action  {{  request()->is('system') ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-chrome"></i> System
	</a>
	<a href="{{ route('update.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/update*') ? 'active' : ''  }} ">
		&nbsp;&nbsp; <i class="fa fa-bullhorn"></i> Updates
	</a>
	<a href="{{ route('goal.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/goal*') ? 'active' : ''  }} ">&nbsp;&nbsp; <i class="fa fas fa-flag"></i> Goals</a>
	@if(\Auth::user()->checkRole(['administrator','investor','patron','employee']))
	<a href="{{ route('finance.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/finance*') ? 'active' : ''  }}" >&nbsp;&nbsp; <i class="fa fas fa-rupee"></i> Cash Flow</a>
	<a href="{{ route('report.week')}}" class="list-group-item list-group-item-action {{  request()->is('system/report*') ? 'active' : ''  }} ">&nbsp;&nbsp; <i class="fa fas fa-align-right"></i> Reports</a>
	@endif
</div>