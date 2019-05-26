
	 <!-- Campus Analytics--> 
	 <div class="row mt-4">
	 	<div class="col-12 col-md-6" >
	 		<div class="" style="background: rgba(229, 80, 57, 0.12);min-height: 340px" >
	 			<div class="p-3 display-4 text-white" style="background: #e55039"> Practice 
	 				<a href="{{ route('campus.students')}}?practice=true">
	 				<span class="float-right text-white"><i class="fa fa-user"></i> {{$practice['item']['participants']}}</span>
	 				</a>
	 			</div>

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
			 				<div class="display-5 mb-3"> <i class="fa fa-user"></i> Participants </div>
			 				<div class="display-4">
			 				<a href="{{ route('campus.students')}}?practice=true" class="text-dark">{{$practice['item']['participants']}}
			 				</a></div>
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
	 	<div class="col-12 col-md-6">
	 		<div class="" style="background: rgba(56, 173, 169, 0.28);min-height: 340px">
	 			<div class="p-3 display-4 text-white" style="background: #38ada9"> Tests
	 				<a href="{{ route('campus.students')}}?test=true">
	 				<span class="float-right text-white"><i class="fa fa-user"></i> {{$test['item']['participants']}}</span>
	 				</a>
	 			</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"> <img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;<b>Excellent </b> <span style="color:#39aca9;" >{{$test['item']['excellent']}} / {{$test['item']['participants']}} </span><span class="float-right " style="color:#39aca9;">{{$test['item']['excellent_percent']}}%</span></div>
	 				<div class="progress"  style="height: 8px;">
					  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$test['item']['excellent_percent']}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
					</div>	
	 			</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;<b> Average </b> <span style="color:#39aca9;" >{{$test['item']['good']}} / {{$test['item']['participants']}} </span><span class="float-right"  style="color:#39aca9;">{{$test['item']['good_percent']}}% </span></div>
	 				<div class="progress bg-white"  style="height: 8px;">
					  <div class="progress-bar bg-info" role="progressbar" style="width: {{$test['item']['good_percent']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 			<div class="p-4 pb-5" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;<b> Need to Improve</b> <span style="color:#39aca9;" >{{$test['item']['need_to_improve']}} / {{$test['item']['participants']}} </span><span class="float-right " style="color:#39aca9;">{{$test['item']['need_to_improve_percent']}}%</span></div>
	 				<div class="progress bg-white" style="height: 8px;">
					  <div class="progress-bar bg-danger" role="progressbar" style="width: {{$test['item']['need_to_improve_percent']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 		</div>
	 	</div>
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
	      <th scope="col" class="text-center" colspan="2">Test</th>
	    </tr>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">{{ $practice['item_name']}}</th>
	      <th scope="col" colspan="1"><i class="fa fa-user"></i></th>
	      <th scope="col" colspan="1">Completion</th>
	      <th scope="col" >Accuracy</th>
	      <th scope="col" colspan="1"><i class="fa fa-user"></i></th>
	       <th scope="col" >Performance</th>
	    </tr>
	  </thead>
	  <tbody>

	    @foreach($practice['items'] as $k=>$batch)
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
	      <td>{{$test['item'][$batch->id]['participants']}}  </td>
	      <td>
	      	
	      	<div class="mb-3">
	      		<div class="display-5 mb-3"><img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;{{$test['item'][$batch->id]['excellent']}} &nbsp;&nbsp;<img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;{{$test['item'][$batch->id]['good']}} &nbsp;&nbsp;<img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;{{$test['item'][$batch->id]['need_to_improve']}}</div>
	 			<div class="progress" style="height:3px;">
				  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$test['item'][$batch->id]['excellent_percent']}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-info" role="progressbar" style="width: {{$test['item'][$batch->id]['good_percent']}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-danger" role="progressbar" style="width: {{$test['item'][$batch->id]['need_to_improve_percent']}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>	
	      </td>
	      </tr>
	     @endforeach
	  </tbody>
	</table>
	@else
	<div class="rounded border p-3 mt-4">No batches Defined</div>
	@endif
	</div>
	@endif