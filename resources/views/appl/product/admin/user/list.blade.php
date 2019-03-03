 @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Details</th>
                <th scope="col">Referral</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('admin.user.view',$user->username) }} ">
                  {{ $user->name }}
                  </a><br>
                  {{ $user->email }}
                </td>
                 <td>
                  @if($user->colleges()->first())
                    {{ $user->colleges()->first()->name }} 
                    @if($user->branches()->first())
                     - {{ $user->branches()->first()->name }} 
                    @endif
                  @endif 
                  - {{ ($user->updated_at) ? $user->updated_at->diffForHumans() : '' }}
                </td>
                
                <td>
                 {{ ($user->user_id)?$user->where('id',$user->user_id)->first()->name:'' }}
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
