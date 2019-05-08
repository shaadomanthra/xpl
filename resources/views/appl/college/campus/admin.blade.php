@extends('layouts.app')

@section('title', 'Campus | PacketPrep')
@section('description', 'Packetprep Campus Page')
@section('keywords', 'packetprep, campus page')


@section('content')

@include('flash::message')
<div  class="row ">
  <div class="col-12 col-md-10">
  	<!-- College Header-->
	  <div class="w-100  rounded p-5 " style="background: rgb(242, 237, 218);border :1px solid rgb(216, 209, 182);">
	  		<div class="row">
	  			<div class="col-12 col-md-2">
	  				<img class=" w-100" src="{{ asset('/img/university.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-10">
	  				<div class=" display-4 ml-4 mt-3 mb-3" >{{ $college->name }}</div>
	  			<div class="custom-control custom-switch ml-4">
				  <input type="checkbox" class="custom-control-input batch" id="customSwitch1" name="batch" @if(request()->get('batch')) checked @endif>
				  <label class="custom-control-label" for="customSwitch1">Batch Mode</label>
				</div>
	  			</div>
	  		</div>
	  </div>
	 <!-- Campus Analytics--> 
	 <div class="row mt-4">
	 	<div class="col-12 col-md-6" >
	 		<div class="" style="background: rgba(229, 80, 57, 0.12);min-height: 340px" >
	 			<div class="p-3 display-4 text-white" style="background: #e55039"> Practice</div>

	 			<div class="row">
	 				<div class="col-6">
	 					<div class="p-2"></div>
	 					<div class="p-4 " >
			 				<div class="display-5 mb-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Completion <span class="float-right"><b>{{$data['college']['completion']}}%</b></span></div>
			 				<div class="progress bg-white" style="height: 8px;">
							  <div class="progress-bar" role="progressbar" style="width: {{$data['college']['completion']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
			 			</div>
			 			<div class="p-4 " >
			 				<div class="display-5 mb-3"> <i class="fa fa-user"></i> Participants </div>
			 				<div class="display-4">{{$data['college']['participants']}}</div>
			 			</div>
			 			<div class="p-2"></div>
	 				</div>
	 				<div class="col-6">

	 					<div class="p-4 " style="background: rgba(229, 80, 57, 0.12);">
	 						<div class="p-2"></div>
			 				<div class="display-5 mb-3"><i class="fa fa-check-square-o" aria-hidden="true"></i>  Accuracy <span class="float-right "><b>{{$data['college']['accuracy']}}%</b></span></div>
			 				<div class="progress bg-white" style="height: 8px;">
							  <div class="progress-bar bg-success" role="progressbar" style="width: {{$data['college']['accuracy']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
			 			</div>
			 			<div class="p-4 " style="background: rgba(229, 80, 57, 0.12);">
			 				<div class="display-5 mb-3"> <i class="fa fa-clock-o"></i> Avg Pace </div>
			 				<div class="display-4">{{$data['college']['time']}} sec</div>
			 				<div class="p-3"></div>
			 			</div>


	 				</div>
	 			</div>
	 			
	 			
	 		</div>
	 	</div>
	 	<div class="col-12 col-md-6">
	 		<div class="" style="background: rgba(56, 173, 169, 0.28);min-height: 340px">
	 			<div class="p-3 display-4 text-white" style="background: #38ada9"> Tests</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"> <img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;<b>Excellent </b> <span class="float-right " style="color:#39aca9;">18%</span></div>
	 				<div class="progress"  style="height: 8px;">
					  <div class="progress-bar bg-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
					</div>	
	 			</div>
	 			<div class="pt-4  pr-4 pl-4 pb-1" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;<b> Good </b><span class="float-right"  style="color:#39aca9;">40% </span></div>
	 				<div class="progress bg-white"  style="height: 8px;">
					  <div class="progress-bar bg-info" role="progressbar" style="width: 35%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 			<div class="p-4 pb-5" >
	 				<div class="display-5 mb-3"><img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;<b> Need to Improve</b>  <span class="float-right " style="color:#39aca9;">50%</span></div>
	 				<div class="progress bg-white" style="height: 8px;">
					  <div class="progress-bar bg-danger" role="progressbar" style="width: 65%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
	 			</div>
	 		</div>
	 	</div>
	 </div>

	 <!-- Batch Analytics--> 

	 <div class="rounded table-responsive">
	 @if(count($data['items']))
	 <table class="table mt-4 bg-white table-bordered ">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">@if(request()->get('batch')) Batches @else Branches @endif</th>
	      <th scope="col" colspan="1">Completion</th>
	      <th scope="col" >Accuracy</th>
	       <th scope="col" >Performance</th>
	    </tr>
	  </thead>
	  <tbody>

	    @foreach($data['items'] as $k=>$batch)
	    <tr>
	      <th scope="row">{{++$k}}</th>
	      <td>{{$batch->name}}({{$data[$batch->id]['participants']}})</td>
	      <td>
	      	<div class="mb-3" style="font-weight: 100"> {{$data[$batch->id]['completion']}}%</div>
	      	<div class="progress " style="height: 3px">
				<div class="progress-bar bg-primary" role="progressbar" style="width: {{$data[$batch->id]['completion']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
	      </td>
	      <td>
	      	<div class="mb-3" style="font-weight: 100"> {{$data[$batch->id]['accuracy']}}%</div>
	      	<div class="progress " style="height: 3px">
				<div class="progress-bar bg-success" role="progressbar" style="width: {{$data[$batch->id]['accuracy']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
	      </td>
	      <td>
	      	
	      	<div class="mb-3">
	      		<div class="display-5 mb-3"><img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;10% &nbsp;&nbsp;<img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;60% &nbsp;&nbsp;<img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;50%</div>
	 			<div class="progress" style="height:3px;">
				  <div class="progress-bar bg-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
				  <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
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
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


