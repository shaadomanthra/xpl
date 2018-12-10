
<div class="list-group">
	<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : ''}}">
		<i class="fa fa-dashboard"></i> Admin Home 
	</a>
	<a href="{{ route('admin.user')}}" class="list-group-item list-group-item-action {{ request()->is('admin/user*') ? 'active' : ''}}"><i class="fa fa-user"></i> Users</a>
	<a href="{{ route('product.index')}}" class="list-group-item list-group-item-action {{ request()->is('product*') ? 'active' : ''}}"><i class="fa fa-inbox"></i> Products</a>
	<a href="{{ route('material')}}" class="list-group-item list-group-item-action {{ request()->is('material') ? 'active' : ''}}"><i class="fa fa-telegram"></i> Material</a>
	<a href="{{ route('exam.index')}}" class="list-group-item list-group-item-action {{ request()->is('exam') ? 'active' : ''}}"><i class="fa fa-th"></i> Exams</a>
	

</div>