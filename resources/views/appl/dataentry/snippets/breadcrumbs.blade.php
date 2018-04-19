<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      @if(request()->is('material'))
      <li class="breadcrumb-item " >Material</li>
      @elseif(request()->is('dataentry*'))
	    <li class="breadcrumb-item">
	      <a href="{{ route('material') }}">Material</a>
	    </li>
      	@if(request()->is('dataentry'))
	      <li class="breadcrumb-item">Dataentry</li>
	    @else
	    <li class="breadcrumb-item">
	      <a href="{{ route('dataentry.index') }}">Dataentry</a>
	    </li>
	      @if(request()->is('dataentry/*'))
	      	@if(request()->is('dataentry/create'))
	      	<li class="breadcrumb-item" >Create</li>
	      	@elseif(request()->is('dataentry/'.$project->slug.'/edit'))
	      	<li class="breadcrumb-item" ><a href="{{ route('dataentry.show',[$project->slug]) }}">{{ $project->name }}</a></li>
	      	<li class="breadcrumb-item" >Edit</li>
	      	@elseif(request()->is('dataentry/*/category*'))
	      	<li class="breadcrumb-item" ><a href="{{ route('dataentry.show',[$project->slug]) }}">{{ $project->name }}</a></li>
	      		@if(request()->is('dataentry/*/category/create'))
	      		<li class="breadcrumb-item" ><a href="{{ route('category.index',[$project->slug]) }}">Categories</a></li>
	      		<li class="breadcrumb-item" >Create</li>
	      		@elseif(request()->is('dataentry/*/category/*'))
	      		<li class="breadcrumb-item" ><a href="{{ route('category.index',[$project->slug]) }}">Categories</a></li>
	      			@if(request()->is('dataentry/*/category/*/edit'))
	      			<li class="breadcrumb-item" ><a href="{{ route('category.show',[$project->slug,$category->slug]) }}">{{ $category->name }}</a></li>
	      			<li class="breadcrumb-item" >Edit</li>
	      			@elseif(request()->is('dataentry/*/category/*/question*'))
	      			<li class="breadcrumb-item" ><a href="{{ route('category.show',[$project->slug,$category->slug]) }}">{{ $category->name }}</a></li>
	      			<li class="breadcrumb-item" >{{ $question->reference }}</li>
	      			@else
	      			<li class="breadcrumb-item" >{{ $category->name }}</li>
	      			@endif
	      		@else
	      			<li class="breadcrumb-item" >Categories</li>	
	      		@endif
	      	@elseif(request()->is('dataentry/*/tag*'))
	      	<li class="breadcrumb-item" ><a href="{{ route('dataentry.show',[$project->slug]) }}">{{ $project->name }}</a></li>
	      		@if(request()->is('dataentry/*/tag/create'))
	      		<li class="breadcrumb-item" ><a href="{{ route('tag.index',[$project->slug]) }}">Tags</a></li>
	      		<li class="breadcrumb-item" >Create</li>
	      		@elseif(request()->is('dataentry/*/tag/*'))
	      		<li class="breadcrumb-item" ><a href="{{ route('tag.index',[$project->slug]) }}">Tags</a></li>
	      			@if(request()->is('dataentry/*/tag/*/edit'))
	      			<li class="breadcrumb-item" ><a href="{{ route('tag.show',[$project->slug,$tag->id]) }}">{{ $tag->value }}</a></li>
	      			<li class="breadcrumb-item" >Edit</li>
	      			@elseif(request()->is('dataentry/*/tag/*/question*'))
	      			<li class="breadcrumb-item" ><a href="{{ route('tag.show',[$project->slug,$tag->id]) }}">{{ $tag->value }}</a></li>
	      			<li class="breadcrumb-item" >{{ $question->reference }}</li>
	      			@else
	      			<li class="breadcrumb-item" >{{ $tag->value }}</li>
	      			@endif
	      		@else
	      			<li class="breadcrumb-item" >Tags</li>	
	      		@endif	
	      	@elseif(request()->is('dataentry/*/passage*'))
	      	<li class="breadcrumb-item" ><a href="{{ route('dataentry.show',[$project->slug]) }}">{{ $project->name }}</a></li>
	      		@if(request()->is('dataentry/*/tag/create'))
	      		<li class="breadcrumb-item" ><a href="{{ route('passage.index',[$project->slug]) }}">Passages</a></li>
	      		<li class="breadcrumb-item" >Create</li>
	      		@elseif(request()->is('dataentry/*/passage/*'))
	      		<li class="breadcrumb-item" ><a href="{{ route('passage.index',[$project->slug]) }}">Passages</a></li>
	      			@if(request()->is('dataentry/*/passage/*/edit'))
	      			<li class="breadcrumb-item" ><a href="{{ route('passage.show',[$project->slug,$passage->id]) }}">{{ $passage->name }}</a></li>
	      			<li class="breadcrumb-item" >Edit</li>
	      			@else
	      			@if(isset($passage->name))
	      			<li class="breadcrumb-item" >{{ $passage->name }}</li>
	      			@else
	      			<li class="breadcrumb-item" >Create</li>
	      			@endif
	      			@endif
	      		@else
	      			<li class="breadcrumb-item" >Passages</li>	
	      		@endif	
	      	@elseif(request()->is('dataentry/*/question*'))
	      	<li class="breadcrumb-item" ><a href="{{ route('dataentry.show',[$project->slug]) }}">{{ $project->name }}</a></li>
	      		@if(request()->is('dataentry/*/question/create'))
	      		<li class="breadcrumb-item" ><a href="{{ route('question.index',[$project->slug]) }}">Questions</a></li>
	      		<li class="breadcrumb-item" >Create</li>
	      		@elseif(request()->is('dataentry/*/question/*'))
	      		<li class="breadcrumb-item" ><a href="{{ route('question.index',[$project->slug]) }}">Questions</a></li>
	      			@if(request()->is('dataentry/*/question/*/edit'))
	      			<li class="breadcrumb-item" ><a href="{{ route('question.show',[$project->slug,$question->id]) }}">{{ $question->reference }}</a></li>
	      			<li class="breadcrumb-item" >Edit</li>
	      			@else
	      			<li class="breadcrumb-item" >{{ $question->reference }}</li>
	      			@endif
	      		@else
	      			<li class="breadcrumb-item" >Questions</li>	
	      		@endif			
	      	@else
	      	<li class="breadcrumb-item" >{{ $project->name }}</li>
	      	@endif
	      @else

	      @endif
      	@endif
      @endif
    </ol>
  </nav>