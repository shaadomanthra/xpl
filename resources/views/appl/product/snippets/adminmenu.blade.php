
<div class="list-group">
	<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : ''}}">
		<i class="fa fa-dashboard"></i> Admin Home 
	</a>
	<a href="{{ route('admin.user')}}" class="list-group-item list-group-item-action {{ request()->is('admin/user*') ? 'active' : ''}}"><i class="fa fa-user"></i> Users</a>
	@if(\Auth::user()->checkRole(['administrator']))
	<a href="{{ route('product.index')}}" class="list-group-item list-group-item-action {{ request()->is('product*') ? 'active' : ''}}"><i class="fa fa-inbox"></i> Products</a>
	<a href="{{ route('job.index')}}" class="list-group-item list-group-item-action {{ request()->is('job*') ? 'active' : ''}}"><i class="fa fa-list"></i> Jobs</a>
	<a href="{{ route('order.list')}}" class="list-group-item list-group-item-action {{ request()->is('admin/transactions*') ? 'active' : ''}}"><i class="fa fa-list"></i> Transactions</a>
	<a href="{{ route('admin.analytics')}}" class="list-group-item list-group-item-action {{ request()->is('admin/analytics*') ? 'active' : ''}}"><i class="fa fa-bar-chart"></i> Analytics</a>
	<a href="{{ route('material')}}" class="list-group-item list-group-item-action {{ request()->is('material') ? 'active' : ''}}"><i class="fa fa-telegram"></i> Material</a>
	<a href="{{ route('exam.index')}}" class="list-group-item list-group-item-action {{ request()->is('exam') ? 'active' : ''}}"><i class="fa fa-th"></i> Exams</a>
	<a href="{{ route('coupon.index')}}" class="list-group-item list-group-item-action {{ request()->is('coupon') ? 'active' : ''}}"><i class="fa fa-bars"></i> Coupons</a>
	@endif
	<a href="{{ route('ambassador.list2')}}" class="list-group-item list-group-item-action {{ request()->is('admin/ambassador*') ? 'active' : ''}}"><i class="fa fa-bars"></i> Ambassadors</a>
	
	<a href="{{ route('form.index')}}" class="list-group-item list-group-item-action {{ request()->is('form*') ? 'active' : ''}}"><i class="fa fa-list"></i> Applicants</a>
	<a href="{{ route('referral.list')}}" class="list-group-item list-group-item-action {{ request()->is('referral*') ? 'active' : ''}}"><i class="fa fa-list"></i> Referrals </a>
	<a href="{{ route('college.index')}}" class="list-group-item list-group-item-action {{ request()->is('college') ? 'active' : ''}}"><i class="fa fa-bars"></i> Colleges</a>
	<a href="{{ route('branch.index')}}" class="list-group-item list-group-item-action {{ request()->is('branch') ? 'active' : ''}}"><i class="fa fa-bars"></i> Branch</a>
	<a href="{{ route('zone.index')}}" class="list-group-item list-group-item-action {{ request()->is('zone') ? 'active' : ''}}"><i class="fa fa-bars"></i> Zone</a>
	<a href="{{ route('metric.index')}}" class="list-group-item list-group-item-action {{ request()->is('metric') ? 'active' : ''}}"><i class="fa fa-bars"></i> Metric</a>
	<a href="{{ route('service.index')}}" class="list-group-item list-group-item-action {{ request()->is('service') ? 'active' : ''}}"><i class="fa fa-bars"></i> Service</a>
	<a href="{{ route('word')}}" class="list-group-item list-group-item-action {{ request()->is('word') ? 'active' : ''}}"><i class="fa fa-bars"></i> Words</a>
	<a href="{{ route('blog.index')}}" class="list-group-item list-group-item-action {{ request()->is('blog') ? 'active' : ''}}"><i class="fa fa-bars"></i> Blog</a>

</div>