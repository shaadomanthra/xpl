@if(isset($details['users']))
		 <div class="rounded table-responsive">
		 @if(count($details['users']))
		 <table class="table mt-4  table-bordered bg-white" >
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col" >Branch</th>
		      @if($colleges)
		      <th scope="col" >College</th>
		      @endif
		      @if(isset($sections))
		      @foreach($sections as $s)
		      <th scope="col" >{{$s->name }}</th> 
		      @endforeach
		      @endif
		      <th scope="col" style="width:10%"  >Score</th>
		      <th scope="col" class=" {{$m=0}} " style="width:20%" >Performance</th>
		     
		    </tr>
		  </thead>
		  <tbody>

		    @foreach($details['users'] as $k=>$user)

		    <tr>
		      <th scope="row">{{++$m}}</th>
		      <td><a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$user['username']}}">{{$user['name']}}  
		      	@if($user['video'])
		      	<i class="fa fa-check-circle text-success"></i>
		      	@endif
		      	</a> 
		      </td>
		      <td>@if(isset($branches[$user['branch']])){{  $branches[$user['branch']] }}@endif</td>

		      @if($colleges)
		      <td>@if($user['college']){{  $colleges[$user['college']][0]->name }}@endif</td>
		      @endif

		      @if(isset($sections))
		      	@foreach($sections as $s)
		      		<td>{{ $details['section'][$s->id]['users'][$k]['score'] }}</td>
		      	@endforeach
		      @endif
		      
		      <td>{{$user['score']}} / {{$user['max']}}  </td>
		      
		      <td>

		      	@if($user['performance']=='need_to_improve')
		      	<img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;
		      		Need to Improve
		      	@else
		      	<img src="{{ asset('/img/medals/'.$user['performance'].'.png')}}" style="width:20px;"  />&nbsp;
		      	{{ ucfirst($user['performance'])}}
		      	@endif
		      	
		      </td>
		      
		      </tr>
		     @endforeach
		  </tbody>
		</table>
		@else
		<div class="rounded border p-3 mt-4">No items Defined</div>
		@endif
		</div>
		@endif