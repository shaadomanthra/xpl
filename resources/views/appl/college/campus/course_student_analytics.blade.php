
	 <!-- Course Analytics--> 
	 <div class="row mt-4 no-gutters">
	 	<div class="col-12 @if($test['item']['count']) col-md-7 @else col-md-12 @endif" >
	 		<div class="" style="background: rgba(229, 80, 57, 0.12);min-height: 342px" >
	 			<div class="p-3 display-4 text-white" style="background: #e55039"> Practice</div>

	 			<div class="row">
	 				<div class="col-6">
	 					<div class="p-2"></div>
	 					<div class="p-4 " >
			 				<div class="display-5 mb-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Completion <span class="float-right"><b>{{$practice['item']['completion']}}%</b></span></div>
			 				<div class="progress bg-white" style="height: 8px;">
							  <div class="progress-bar" role="progressbar" style="width: {{$practice['item']['completion']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
			 			</div>
			 			<div class="p-4 " >
			 				<div class="display-5 mb-3"> <i class="fa fa-th"></i> Ques Solved </div>
			 				<div class="display-4">{{$practice['item']['solved']}}/{{$practice['item']['total']}}</div>
			 			</div>
			 			<div class="p-2"></div>
	 				</div>
	 				<div class="col-6">

	 					<div class="p-4 " style="background: rgba(229, 80, 57, 0.12);">
	 						<div class="p-2"></div>
			 				<div class="display-5 mb-3"><i class="fa fa-check-square-o" aria-hidden="true"></i>  Accuracy <span class="float-right "><b>{{$practice['item']['accuracy']}}%</b></span></div>
			 				<div class="progress bg-white" style="height: 8px;">
							  <div class="progress-bar bg-success" role="progressbar" style="width: {{$practice['item']['accuracy']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
			 			</div>
			 			<div class="p-4 " style="background: rgba(229, 80, 57, 0.12);">
			 				<div class="display-5 mb-3"> <i class="fa fa-clock-o"></i> Avg Pace </div>
			 				<div class="display-4">{{$practice['item']['time']}} sec</div>
			 				<div class="p-3"></div>
			 			</div>


	 				</div>
	 			</div>
	 			
	 			
	 		</div>
	 	</div>
	 	@if($test['item']['count'])
	 	<div class="col-12 col-md-5">
	 		<div class="" style="background: rgba(56, 173, 169, 0.28);min-height: 340px">
	 			<div class="p-3 display-4 text-white" style="background: #38ada9"> Tests</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"> <img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;<b>Excellent </b> <span style="color:#39aca9;" >{{$test['item']['excellent']}} / {{$test['item']['count']}} </span><span class="float-right " style="color:#39aca9;">{{$test['item']['excellent_percent']}}%</span></div>
	 				<div class="progress"  style="height: 8px;">
					  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$test['item']['excellent_percent']}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
					</div>	
	 			</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;<b> Average </b> <span style="color:#39aca9;" >{{$test['item']['good']}} / {{$test['item']['count']}} </span><span class="float-right"  style="color:#39aca9;">{{$test['item']['good_percent']}}% </span></div>
	 				<div class="progress bg-white"  style="height: 8px;">
					  <div class="progress-bar bg-info" role="progressbar" style="width: {{$test['item']['good_percent']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 			<div class="p-4 pb-5" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;<b> Need to Improve</b> <span style="color:#39aca9;" >{{$test['item']['need_to_improve']}} / {{$test['item']['count']}} </span><span class="float-right " style="color:#39aca9;">{{$test['item']['need_to_improve_percent']}}%</span></div>
	 				<div class="progress bg-white" style="height: 8px;">
					  <div class="progress-bar bg-danger" role="progressbar" style="width: {{$test['item']['need_to_improve_percent']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 		</div>
	 	</div>
	 	@endif
	 </div>

	 <!-- Batch Analytics--> 

	  @if(isset($practice['items']))
	 <div class="rounded table-responsive">
	 @if(count($practice['items']))
	 <table class="table mt-4 bg-white table-bordered ">
	  <thead>
	    <tr>
	      <th scope="col"></th>
	      <th scope="col"></th>
	      <th scope="col" class="text-center" colspan="3">Practice</th>
	      
	    </tr>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">{{ $practice['item_name']}}</th>
	      <th scope="col" colspan="1"><i class="fa fa-user"></i></th>
	      <th scope="col" colspan="1">Completion</th>
	     
	      <th scope="col" >Accuracy</th>
	    </tr>
	  </thead>
	  <tbody>

	    @foreach($practice['items'] as $k=>$batch)
	    @if($batch->url)
	    @if($practice['item'][$batch->id]['total']!=0)
	    <tr>
	      <th scope="row">{{++$k}}</th>
	      <td><a href="{{$batch->url}}">{{$batch->name}}  </a></td>
	      <td>{{$practice['item'][$batch->id]['participants']}}  </td>
	      <td>
	      	<div class="mb-3" style="font-weight: 100"> {{$practice['item'][$batch->id]['completion']}}%</div>
	      	<div class="progress " style="height: 3px">
				<div class="progress-bar bg-primary" role="progressbar" style="width: {{$practice['item'][$batch->id]['completion']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
	      </td>
	      <td>
	      	<div class="mb-3" style="font-weight: 100"> {{$practice['item'][$batch->id]['accuracy']}}%</div>
	      	<div class="progress " style="height: 3px">
				<div class="progress-bar bg-success" role="progressbar" style="width: {{$practice['item'][$batch->id]['accuracy']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
	      </td>
	     
	      </tr>
	      @endif
	      @endif
	     @endforeach
	  </tbody>
	</table>
	@else
	@endif
	</div>
	@endif



	  @if(isset($test['exam']))
	 <div class="rounded table-responsive">
	 @if(count($test['exam']))
	 <table class="table mt-4 bg-white table-bordered {{$w=0}}">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Tests</th>
	      <th scope="col" colspan="1">Score</th>
	      <th scope="col" colspan="1">Pace</th>	     
	      <th scope="col" >Performance</th>
	    </tr>
	  </thead>
	  <tbody>

	    @foreach($test['exam'] as $k=>$exam)
	  	@if(isset($exam['users']))
	    	@foreach($exam['users'] as $u)
	    		@break
	    	@endforeach
	    
	    <tr>
	      <th scope="row">{{++$w}}</th>
	      <td><a href="{{ $exam['url']}}">@if(isset($exam['name'])){{$exam['name']}} @endif </a></td>
	      <td>{{$u['score']}} / {{ $u['max'] }} </td>
	      <td>{{$u['pace']}} sec  </td>
	      
	      <td>
	      	<div class="mb-3">
	      		<div class="display-5 mb-3"><img src="{{ asset('/img/medals/'.str_replace('_', '', $u['performance']).'.png')}}" style="width:20px;"  />&nbsp; {{ ucfirst(str_replace('_', ' ', $u['performance'])) }}
	      		</div>
	 			
			</div>
	      </td>
	      </tr>
	      @else
	      <tr>
	      <th scope="row">{{++$w}}</th>
	      <td>@if(isset($exam['name'])){{$exam['name']}} @endif 
	      		<span class="badge badge-secondary">unattempted</span>
	      </td>
	      <td> - </td>
	      <td> - </td>
	      
	      <td>
	      	<div class="mb-3">
	      		<div class="display-5 mb-3"> -
	      		</div>
	 			
			</div>
	      </td>
	      </tr>
	      @endif


	     @endforeach
	  </tbody>
	</table>
	@else
	@endif
	</div>
	@endif

	 