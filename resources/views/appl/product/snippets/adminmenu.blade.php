
<div class="list-group">
	<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : ''}}">
		<i class="fa fa-dashboard"></i> Admin Home 
	</a>
	<a href="{{ route('admin.user')}}" class="list-group-item list-group-item-action {{ request()->is('admin/user*') ? 'active' : ''}}"><i class="fa fa-user"></i> User Accounts</a>
	<a href="{{ route('admin.image')}}" class="list-group-item list-group-item-action {{ request()->is('admin/image') ? 'active' : ''}}"><i class="fa fas fa-image"></i> Update Logo</a>
	<a href="{{ route('order.buy')}}" class="list-group-item list-group-item-action {{ request()->is('admin/buy') ? 'active' : ''}}"><i class="fa fa-rupee"></i> Buy Credits</a>
	<a href="{{ route('order.list')}}" class="list-group-item list-group-item-action {{ request()->is('admin/transactions') ? 'active' : ''}}"><i class="fa fas fa-shopping-cart"></i> Transactions</a>

	<a href="{{ route('admin.settings')}}" class="list-group-item list-group-item-action {{ request()->is('admin/settings') ? 'active' : ''}}"><i class="fa fa-gear"></i> Settings</a>

</div>