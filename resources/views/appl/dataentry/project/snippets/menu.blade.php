
<div class="list-group">
	<a href="{{ route('dataentry.show',$project->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('dataentry/'.$project->slug) ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-inbox"></i> Project Home 
	</a>
	<a href="{{ route('category.index',$project->slug)}}" class="list-group-item list-group-item-action {{  request()->is('dataentry/*/category*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fa-tasks"></i> Categories</a>
	<a href="#" class="list-group-item list-group-item-action ">&nbsp;&nbsp;&nbsp;<i class="fa fa-tags"></i> Tags</a>
	<a href="#" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-clipboard"></i> Passages</a>
	<a href="#" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-comments"></i> Questions</a>
	
	
</div>