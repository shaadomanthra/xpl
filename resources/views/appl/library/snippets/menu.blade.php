
<div class="list-group">
	<a href="{{ route('library.show',$repo->slug)}}" class="list-group-item list-group-item-action  {{  request()->is('library/'.$repo->slug) ? 'active' : 'bg-light'  }} ">
		<i class="fa fa-inbox"></i> Repository Home 
	</a>
	<a href="{{ route('structure.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/structure*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fa-tasks"></i> Structures</a>
	<a href="{{ route('ltag.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/ltag*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fa-tags"></i> Tags</a>
	<a href="{{ route('lpassage.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/lpassage*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-clipboard"></i> Passages</a>
	<a href="{{ route('lquestion.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/lquestion*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-comments"></i> Questions</a>
	<a href="{{ route('version.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/version*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-file-text"></i> Versions</a>
	<a href="{{ route('video.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/video*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fa-youtube-play"></i> Videos</a>
	<a href="{{ route('document.index',$repo->slug)}}" class="list-group-item list-group-item-action {{  request()->is('library/*/document*') ? 'active' : ''  }}">&nbsp;&nbsp;&nbsp;<i class="fa fas fa-file-pdf-o"></i> Documents</a>
</div>