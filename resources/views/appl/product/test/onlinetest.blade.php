@extends('layouts.app')

@section('content')

<div class="p-2 pb-4 text-center">
	<div class="titlea"> Online Tests</div>
</div>


<div class="mb-md-5">
	<div class="container">
		<div class="p-3 pb-4 display-3 border rounded bg-light mb-4">Quantitative Aptitude</div>
	<div class="row">
		<div class="col-12 col-md-4 mb-4">
			<div class="card text-white  mb-3" style="background: #e66767">
				<div class="card-body"> 
					<div class="display-4">Practice Test <span class="float-right badge badge-light">#1</span></div>
					<div class="mb-4">30 Questions | 30 minutes</div>
					@if(!$tests['test1'])
					<a href="{{ route('onlinetest.instructions','test1') }}" >
					<button class="btn btn-lg btn-outline-light">Try now</button>
					</a>
					@else
					<a href="{{ route('onlinetest.analysis','test1') }}" >
					<button class="btn btn-lg btn-outline-light"><i class="fa fas fa-bar-chart"></i> Analysis</button>
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mb-4">
			<div class="card text-white  mb-3" style="background: #54a0ff">
				<div class="card-body"> 
					<div class="display-4">Practice Test <span class="float-right badge badge-light">#2</span></div>
					<div class="mb-4">30 Questions | 30 minutes</div>
					@if(!$tests['test2'])
					<a href="{{ route('onlinetest.instructions','test2') }}" >
					<button class="btn btn-lg btn-outline-light">Try now</button>
					</a>
					@else
					<a href="{{ route('onlinetest.analysis','test2') }}" >
					<button class="btn btn-lg btn-outline-light"><i class="fa fas fa-bar-chart"></i> Analysis</button>
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mb-4">
			<div class="card text-white  mb-3" style="background: #8395a7">
				<div class="card-body"> 
					<div class="display-4">Practice Test <span class="float-right badge badge-light">#3</span></div>
					<div class="mb-4">30 Questions | 30 minutes</div>
					@if(!$tests['test3'])
					<a href="{{ route('onlinetest.instructions','test3') }}" >
					<button class="btn btn-lg btn-outline-light">Try now</button>
					</a>
					@else
					<a href="{{ route('onlinetest.analysis','test3') }}" >
					<button class="btn btn-lg btn-outline-light"><i class="fa fas fa-bar-chart"></i> Analysis</button>
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mb-4">
			<div class="card text-white  mb-3" style="background: #63cdda">
				<div class="card-body"> 
					<div class="display-4">Practice Test <span class="float-right badge badge-light">#4</span></div>
					<div class="mb-4">30 Questions | 30 minutes</div>
					@if(!$tests['test4'])
					<a href="{{ route('onlinetest.instructions','test4') }}" >
					<button class="btn btn-lg btn-outline-light">Try now</button>
					</a>
					@else
					<a href="{{ route('onlinetest.analysis','test4') }}" >
					<button class="btn btn-lg btn-outline-light"><i class="fa fas fa-bar-chart"></i> Analysis</button>
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mb-4">
			<div class="card text-white  mb-3" style="background: #786fa6">
				<div class="card-body"> 
					<div class="display-4">Practice Test <span class="float-right badge badge-light">#5</span></div>
					<div class="mb-4">30 Questions | 30 minutes</div>
					@if(!$tests['test5'])
					<a href="{{ route('onlinetest.instructions','test5') }}" >
					<button class="btn btn-lg btn-outline-light">Try now</button>
					</a>
					@else
					<a href="{{ route('onlinetest.analysis','test5') }}" >
					<button class="btn btn-lg btn-outline-light"><i class="fa fas fa-bar-chart"></i> Analysis</button>
					</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection           