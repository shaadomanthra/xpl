
<div class="list-group">
	<a href="{{ route('social')}}" class="list-group-item list-group-item-action {{  request()->is('recruit') ? 'active' : ''  }} ">
		 <i class="fa fa-reddit"></i> Recruit
	</a>
	<a href="{{ route('job.index')}}" class="list-group-item list-group-item-action {{  request()->is('job*') ? 'active' : ''  }} ">
		&nbsp;&nbsp; <i class="fa fa-arrow-circle-right"></i> Jobs
	</a>
	<a href="{{ route('form.index')}}" class="list-group-item list-group-item-action {{  request()->is('form*') ? 'active' : ''  }}" > &nbsp;&nbsp; <i class="fa fa-wpforms"></i> Forms</a>
</div>