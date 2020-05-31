 @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Details</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('admin.user.view',$user->username) }} ">
                  {{ $user->name }}

                  @if($user->client_slug && $user->video)
                  <i class="fa fa-check-circle text-success"></i>
                  @endif
                  </a><br>
                   {{ $user->email }}<br>
                  @if($user->client_slug)
                  <span class="badge badge-info">{{$user->client_slug}}</span>
                  @else
                  <span class="badge badge-warning">xplore</span>
                  @endif
                </td>
                 <td>
                  @if($user->college)
                    {{ $user->college->name }} 
                    @if($user->branch)
                     - {{ $user->branch->name }} 
                    @endif
                  @endif 
                  
                </td>
                
                <td>
                 {{ ($user->updated_at) ? $user->updated_at->diffForHumans() : '' }}
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Users listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
