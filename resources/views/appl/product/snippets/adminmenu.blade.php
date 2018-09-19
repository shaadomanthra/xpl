
<div class="list-group">
	<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : ''}}">
		<i class="fa fa-dashboard"></i> Admin Home 
	</a>
	<a href="{{ route('dataentry.index')}}" class="list-group-item list-group-item-action {{ request()->is('dataentry*') ? 'active' : ''}}"><i class="fa fa-user"></i> User Accounts</a>
	<a href="{{ route('library.index')}}" class="list-group-item list-group-item-action {{ request()->is('library*') ? 'active' : ''}}"><i class="fa fas fa-image"></i> Update Logo</a>
	<a href="{{ route('order.list')}}" class="list-group-item list-group-item-action {{ request()->is('library*') ? 'active' : ''}}"><i class="fa fas fa-shopping-cart"></i> Transactions</a>
	<a href="{{ route('admin.settings')}}" class="list-group-item list-group-item-action {{ request()->is('admin/settings') ? 'active' : ''}}"><i class="fa fa-gear"></i> Settings</a>

</div>