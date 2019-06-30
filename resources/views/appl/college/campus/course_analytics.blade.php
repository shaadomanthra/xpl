
	 <!-- Course Analytics--> 
	 <div class="row mt-4 no-gutters">
	 	<div class="col-12 @if($test['item']['count']) col-md-7 @else col-md-12 @endif" >
	 		<div class="" style="background: rgba(229, 80, 57, 0.12);min-height: 342px" >
	 			<div class="p-3 display-4 text-white" style="background: #e55039"> Practice
				<a href="{{ route('campus.student_table')}}?practice=true&topic={{$category->slug}}&batch={{request()->get('batch')}}@if(request()->get('branch'))&branch={{request()->get('branch')}} @endif @if(request()->get('batch_code'))&batch_code={{request()->get('batch_code')}} @endif">
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
			 				@if(isset($user))

			 				<div class="display-5 mb-3"> <i class="fa fa-th"></i> Ques Solved </div>
			 				<div class="display-4">{{$practice['item']['solved']}}/{{$practice['item']['total']}}</div>
			 				@else
			 				<div class="display-5 mb-3"> <i class="fa fa-user"></i> Participants </div>
			 				<div class="display-4">
			 				<a href="{{ route('campus.student_table')}}?practice=true&topic={{$category->slug}}&batch={{request()->get('batch')}}@if(request()->get('branch'))&branch={{request()->get('branch')}} @endif @if(request()->get('batch_code'))&batch_code={{request()->get('batch_code')}} @endif">{{$practice['item']['participants']}}
			 				</a>
			 				</div>
			 				@endif
			 				
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
	 			<div class="p-3 display-4 text-white" style="background: #38ada9"> Tests <a href="{{ route('campus.student_table')}}?test=true&batch={{request()->get('batch')}}@if(request()->get('branch'))&branch={{request()->get('branch')}} @endif @if(request()->get('batch_code'))&batch_code={{request()->get('batch_code')}} @endif">
	 				<span class="float-right text-white"><i class="fa fa-user"></i> {{$test['item']['participants']}}</span>
	 				</a></div>
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
	      <td><a href="{{ $batch->url_participants}}">{{$practice['item'][$batch->id]['participants']}}  </a></td>
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
	      <th scope="col" colspan="1"><i class="fa fa-user"></i></th>	     
	      <th scope="col" >Performance</th>
	    </tr>
	  </thead>
	  <tbody>

	    @foreach($test['exam'] as $k=>$exam)
	   
	    <tr>
	      <th scope="row">{{++$w}}</th>
	      <td><a href="{{ $exam['url']}}">@if(isset($exam['name'])){{$exam['name']}} @endif </a></td>
	      <td>{{$exam['participants']}}  </td>
	      
	      <td>
	      	<div class="mb-3">
	      		<div class="display-5 mb-3"><img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;{{$exam['excellent']}} &nbsp;&nbsp;<img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;{{$exam['good']}} &nbsp;&nbsp;<img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;{{$exam['need_to_improve']}}</div>
	 			<div class="progress" style="height:3px;">
				  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$exam['excellent_percent']}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-info" role="progressbar" style="width: {{$exam['good_percent']}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-danger" role="progressbar" style="width: {{$exam['need_to_improve_percent']}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
	      </td>
	     
	      </tr>
	     @endforeach
	  </tbody>
	</table>
	@else
	@endif
	</div>
	@endif

	 