
<div class="list-group">
	<a href="{{ route('library.show',$repo->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('library/'.$repo->slug) ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-inbox"></i> Repository Home 
	</a>
	<a href="{{ route('structure.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/category*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fa-tasks"></i> Structures</a>
</div>