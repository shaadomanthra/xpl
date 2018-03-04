
<div class="list-group">
	<a href="{{ route('data.dataentry.show',$project->slug)}}" class="list-group-item list-group-item-action {{  request()->is('dataentry/'.$project->slug) ? 'active' : ''  }} ">
		Project Home 
	</a>
	<a href="{{ route('project.category.index',$project->slug)}}" class="list-group-item list-group-item-action {{  request()->is('dataentry/*/category*') ? 'active' : ''  }}">Categories</a>
	<a href="#" class="list-group-item list-group-item-action">Questions</a>
	<a href="#" class="list-group-item list-group-item-action">Passages</a>
	<a href="#" class="list-group-item list-group-item-action disabled">Tags</a>
</div>