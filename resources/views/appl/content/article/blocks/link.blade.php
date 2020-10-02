
@if(isset($obj->link))
 @if(strip_tags(trim($obj->link)))
	@auth
	<a href="{{ $obj->link}}" target="_blank">
	    <button class="btn btn-lg btn-success">Click Here</button>
	</a>
	@else
		<a href="#" data-toggle="modal" data-target="#myModal2">
			<button class="btn btn-primary btn-lg " type="button" > Click Here</button>
		</a>
	@endauth
@endif
@endif