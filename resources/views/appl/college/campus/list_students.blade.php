     
          @if(count($users))
          <div class="row mb-2">
          @foreach($users as $user)
            <div class="col-12 col-md-4">
              <div class="card mb-3">
              	<div class="card-body">
                <h3>{{ $user->name }}</h3>
                <small>{{ ($user->details()->first()) ? $user->details()->first()->roll_number : '' }}</small><br>
                <small>{{ ($user->branches()->first()) ? $user->branches()->first()->name : '' }}</small><br>
                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                <a class="btn btn-outline-secondary" href="{{ route('campus.courses')}}?student={{$user->username}}"> Courses
                </a>
                <a class="btn btn-outline-secondary" href="{{ route('campus.tests')}}?student={{$user->username}}">Tests
                </a>
                </div>

                <br>
                </div>
                <div class="card-footer">
                @if($user->batches()->first())
	            <span class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	              <a href="" class="btn btn-sm btn-outline-secondary disabled" disabled>{{$user->batches()->first()->name}}</a>
	              @can('manage',$college)
	              <a href="{{ route('batch.detach',$user->batches()->first()->id)}}?user_id={{$user->id}}&url={{ url()->current() }}" class="btn btn-outline-secondary"><i class="fa fa-trash"></i></a>
	              @endcan
	            </span>


                @else
              @can('manage',$college)
             	<div class="dropdown ">
				  <a class="btn btn-sm btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Assign Batch
				  </a>

				  @if(count($college->batches))
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				  	@foreach($college->batches as $batch)
				    <a class="dropdown-item" href="{{ route('batch.attach',$batch->id)}}?user_id={{$user->id}}&url={{ url()->current()}}">{{ $batch->name}}</a>
				    @endforeach
				  </div>
				  @else
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				  	<div class="dropdown-item">- No Batches -</div>
				  </div>
				  @endif
				</div>
              @endcan
              @endif
          </div>
              </div>
            </div>
          @endforeach
          </div>
          <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif mb-3 mb-md-0">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
          @else
           <div class="card"><div class="card-body"> - No Students -</div></div>
          @endif