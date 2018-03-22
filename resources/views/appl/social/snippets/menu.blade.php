
<div class="list-group">
	<a href="{{ route('social')}}" class="list-group-item list-group-item-action {{  request()->is('social') ? 'active' : ''  }} ">
		 <i class="fa fa-gg-circle"></i> Social
	</a>
	<a href="{{ route('blog.index')}}" class="list-group-item list-group-item-action {{  request()->is('social/blog*') ? 'active' : ''  }} ">
		&nbsp;&nbsp; <i class="fa fa-reddit"></i> Blog
	</a>
	<a href="{{ route('media.index')}}" class="list-group-item list-group-item-action {{  request()->is('social/media*') ? 'active' : ''  }}" > &nbsp;&nbsp; <i class="fa fa-camera-retro"></i> Social Media</a>
</div>