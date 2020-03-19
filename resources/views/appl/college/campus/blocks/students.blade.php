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
		      @if(\auth::user()->isAdmin())
		    	<th scope="col" style="width:8%"  >Delete</th>
		    	@endif
		    </tr>
		  </thead>
		  <tbody>

		    @foreach($details['users'] as $k=>$user)

		    <tr>
		      <th scope="row">{{++$m}}</th>
		      <td>{{$user['name']}}  </td>
		      <td>@if($user['branch']){{  $branches[$user['branch']] }}@endif</td>

		      @if($colleges)
		      <td><a href="{{ route('test.analytics',$exam->slug)}}?college_id={{$user['college']}}">@if($user['college']){{  $colleges[$user['college']][0]->name }}@endif</a></td>
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
		      @if(\auth::user()->isAdmin())
		      <td>
		      		<form method="post" action="{{ route('assessment.delete',$exam->slug)}}" >
		      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		      			<input type="hidden" name="user_id" value="{{ $k }}">
		      			<input type="hidden" name="test_id" value="{{ $exam->id }}">
		      			<button class="btn btn-sm btn-primary" type="submit">delete</button>

		      		</form>
		      		
		      	</td>
		      	@endif
		      </tr>
		     @endforeach
		  </tbody>
		</table>
		@else
		<div class="rounded border p-3 mt-4">No items Defined</div>
		@endif
		</div>
		@endif