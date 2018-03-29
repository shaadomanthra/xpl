<div class="card">
	<div class="card-header">{{ strtoupper($question->reference) }} <span class="btn view badge badge-warning" data-item="details">view</span>
		<span class="float-right">
			<a href="">
			<i class="fa fa-paper-plane" data-tooltip="tooltip" data-placement="top" title="Publish"></i>
			</a> &nbsp;
			<a href="{{ route('question.edit',['project'=>$project->slug,'question'=>$question->id]) }}">
			<i class="fa fa-pencil-square" data-tooltip="tooltip" data-placement="top" title="Edit"></i> 
			</a>&nbsp;
			<a href="#" data-toggle="modal" data-target="#exampleModal">
			<i class="fa fa-trash" data-tooltip="tooltip" data-placement="top" title="Delete"></i>
			</a>
		</span>
	</div>
	<div class="card-body details" style="display:none;">
		<div class="bg-light p-1 rounded border mb-2">Details</div>
		<div class="row">
			<div class="col-5">Ref</div>
			<div class="col-7 mb-2"><span class=" text-primary">{{ strtoupper($question->reference) }}</span></div>
		</div>
		<div class="row">
			<div class="col-5">Slug</div>
			<div class="col-7 mb-2"><span class="badge badge-warning">{{ $question->slug }}</span></div>
		</div>
		<div class="row">
			<div class="col-5">Type</div>
			<div class="col-7 mb-2">
				@if($question->type==1)
				Multiple Choice Question
				@elseif($question->type==2)
				Multi Answer Question
				@elseif($question->type==3)
				Numerical Answer Question
				@else
				Explanation Question
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-5">Stage</div>
			<div class="col-7 mb-2">
				@if($question->stage==1)
				<div class="badge badge-secondary">Feeding</div>
				@elseif($question->stage==2)
				<div class="badge badge-secondary">Proof Reading</div>
				@elseif($question->stage==3)
				<div class="badge badge-secondary">Renovation</div>
				@elseif($question->stage==4)
				<div class="badge badge-secondary">Validation</div>
				@else
				<div class="badge badge-success">Live</div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-5">Status</div>
			<div class="col-7">
				@if($question->status==0)
				<div class="text-info"><i class="fa fa-minus-square"></i> Draft</div>
				@else
				<div class="text-success s15"><i class="fa fa-check-square"></i> Published</div>
				@endif
			</div>
		</div>

		@if(count($question->categories)!=0)
		<div class="bg-light p-1 rounded border mb-2 mt-3">Categories</div>
		<div class="">
			@foreach($question->categories as $category)
				{{ $category->name }}<br>
			@endforeach
		</div>
		@endif

		@if(count($question->tags)!=0)
		<div class="bg-light p-1 rounded border mb-2 mt-3">Tags</div>
		<div class="">
			@foreach($question->tags as $tag)
			<div class="row">
			<div class="col-6">{{ $tag->name }}</div>
			<div class="col-6">
				{{ $tag->value }}
			</div>
			</div>
			@endforeach
		</div>
		@endif

		@if($question->dynamic)
		<div class="bg-light p-1 rounded border mb-2 mt-3">Dynamic</div>
		<form method="get" action="{{route('question.show',[$project->slug,$question->id])}}" >
		<input type="number" class="form-control" name="number" id="formGroupExampleInput" placeholder="number" 
              value="{{ (request()->get('number')) ? request()->get('number') : '' }}"
            >
         <button class="btn btn-sm btn-outline-primary mt-2" type="submit">Submit</button>    
     	</form>
     	@endif

	</div>
</div>