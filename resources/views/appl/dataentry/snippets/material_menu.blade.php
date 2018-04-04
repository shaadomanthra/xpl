
<div class="list-group">
	<a href="{{ URL::to('material') }}" class="list-group-item list-group-item-action {{ request()->is('material') ? 'active' : 'bg-light'}}">
		<i class="fa fa-telegram"></i> Material Home 
	</a>
	<a href="{{ route('dataentry.index')}}" class="list-group-item list-group-item-action {{ request()->is('dataentry*') ? 'active' : ''}}">&nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i> Data Entry</a>
	<a href="{{ route('library.index')}}" class="list-group-item list-group-item-action {{ request()->is('library*') ? 'active' : ''}}">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-university"></i> Library</a>
	<a href="#" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-stack-exchange"></i> Courses</a>

</div>