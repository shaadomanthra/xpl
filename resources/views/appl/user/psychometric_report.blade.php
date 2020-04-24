@if($user->getPsy())
<div class="my-3 ml-3">

	<h2 class="ml-3"><i class="fa fa-gg"></i> Psychometric Test Report</h2>
	<div class="card p-0 bg-light"  style="background: #FFF;border: 0px solid #EEE;">
		<div class="" >
			<div class="mt-2 mb-3">
				@foreach($user->getPsy()['d'] as $i=>$j)
				<div class="c c_{{$i}}">
					<div class="p p_{{$i}}" style="width:{{($j*2.5)}}%;"></div>
					<div class="content text-left">
						<h3>@if($i=='neuroicism') Emotional Stability @else {{ ucfirst($i)}}@endif <i class="fa fa-question-circle-o" data-toggle="tooltip" title="{{ $user->getPsy()['m'][$i] }}"></i>
							<p class="float-right text-secondary f18">{{($j*2.5)}}%</p>
						</h3>
						<p>@if($j<16){{ $user->getPsy()['c'][$i]['low']}} @elseif($j>15 && $j<27) {{ $user->getPsy()['c'][$i]['mid']}} @else {{ $user->getPsy()['c'][$i]['high']}} @endif</p>

					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

</div>
@endif