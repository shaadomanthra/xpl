@if(count($objs))
          <div class="row mb-2">
          @foreach($objs as $user)
            <div class="col-12 col-md-3">
              <div class="card mb-3">
                <div class="card-body">
                <h3>{{ $user['name'] }}</h3>
                <small>{{ ($user->details()->first())?$user->details()->first()->roll_number:'' }}</small><br>
                <small>{{ ($user->branches()->first()) ? $user->branches()->first()->name : '' }}</small><br>
                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                <a class="btn btn-outline-secondary" href="{{ route('campus.courses')}}?student={{$user->username}}">Courses
                </a>
                <a class="btn btn-outline-secondary" href="{{ route('campus.tests')}}?student={{$user->username}}"> Tests
                </a>
                </div>
              </div>
              <div class="card-footer">
              @can('update',$obj)
              <form method="post" action="{{route($app->module.'.detach',$obj->id)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button class="btn btn-sm btn-outline-danger " type="submit"><i class="fa fa-trash"></i> Remove</button>
              </form>
              @endcan
            </div>
              </div>
            </div>
          @endforeach
          </div>
          @else
           <div class="card"><div class="card-body"> - Student not Found -</div></div>
          @endif