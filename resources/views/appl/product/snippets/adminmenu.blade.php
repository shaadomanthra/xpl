
<div class="list-group">
	<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : ''}}">
		<i class="fa fa-dashboard"></i> Admin Home 
	</a>
	<a href="{{ route('admin.user')}}" class="list-group-item list-group-item-action {{ request()->is('admin/user*') ? 'active' : ''}}"><i class="fa fa-user"></i> Users</a>
	@if(\Auth::user()->checkRole(['administrator']))
	<a href="{{ route('product.index')}}" class="list-group-item list-group-item-action {{ request()->is('product*') ? 'active' : ''}}"><i class="fa fa-inbox"></i> Products</a>
	
	<a href="{{ route('order.list')}}" class="list-group-item list-group-item-action {{ request()->is('admin/transactions*') ? 'active' : ''}}"><i class="fa fa-list"></i> Transactions</a>

	<a href="{{ route('coupon.index')}}" class="list-group-item list-group-item-action {{ request()->is('coupon') ? 'active' : ''}}"><i class="fa fa-bars"></i> Coupons</a>
	
	@endif
	
	<a href="{{ route('material')}}" class="list-group-item list-group-item-action {{ request()->is('material') ? 'active' : ''}}"><i class="fa fa-telegram"></i> Material</a>
	
	<a href="{{ route('exam.index')}}" class="list-group-item list-group-item-action {{ request()->is('exam') ? 'active' : ''}}"><i class="fa fa-th"></i> Exams</a>
	
	<a href="{{ route('college.index')}}" class="list-group-item list-group-item-action {{ request()->is('college') ? 'active' : ''}}"><i class="fa fa-bars"></i> Colleges</a>
	<a href="{{ route('branch.index')}}" class="list-group-item list-group-item-action {{ request()->is('branch') ? 'active' : ''}}"><i class="fa fa-bars"></i> Branch</a>
	<a href="{{ route('zone.index')}}" class="list-group-item list-group-item-action {{ request()->is('zone') ? 'active' : ''}}"><i class="fa fa-bars"></i> Zone</a>
	<a href="{{ route('metric.index')}}" class="list-group-item list-group-item-action {{ request()->is('metric') ? 'active' : ''}}"><i class="fa fa-bars"></i> Metric</a>


</div>