
<div class="list-group">
	<a href="{{ route('system')}}" class="list-group-item list-group-item-action {{  request()->is('system') ? 'active' : ''  }} ">
		<i class="fa fa-chrome"></i> System
	</a>
	<a href="{{ route('update.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/update*') ? 'active' : ''  }} ">
		<i class="fa fa-bullhorn"></i> Updates
	</a>
	<a href="{{ route('finance.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/finance*') ? 'active' : ''  }}" ><i class="fa fas fa-rupee"></i> Cash Flow</a>
	<a href="{{ route('goal.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/goal*') ? 'active' : ''  }} "><i class="fa fas fa-flag"></i> Goals</a>
	<a href="{{ route('report.index')}}" class="list-group-item list-group-item-action {{  request()->is('system/report*') ? 'active' : ''  }} "><i class="fa fas fa-align-right"></i> Reports</a>
</div>