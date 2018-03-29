<div class="card mt-3 mb-3">
	<div class="card-body">
		@if(isset($question))
		@if($question->passage_id)
			<div class="bg-light border mb-3 p-3">
			<b>Passage</b>&nbsp;<span class="btn badge badge-danger btn-dettach ">Dettach</span>
			</div>
			<div class="passage">
			{!! $passage->passage !!}
			</div>
		@else
		<div class="passage">
			No passage attached
		</div>
		@endif
		@else
		<div class="passage">
			No passage attached
		</div>
		@endif
	</div>
</div>

<div class="mb-3">
<form class="form-inline " method="GET" action="{{ route('dataentry.index') }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" data-url="{{ route('passage.index',['project_slug'=>$project->slug,'api'=>'true']) }}"
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
</div>
<div id="search-items">
   @include('appl.dataentry.passage.list_attach')
</div>

<div class="form-group">
	<input type="hidden" class="form-control" name="passage_id" 
	@if($stub=='Create')
	value="{{ (old('passage_id')) ? old('passage_id') : '' }}"
	@else
	value = "{{ $question->passage_id }}"
	@endif
	>
</div>