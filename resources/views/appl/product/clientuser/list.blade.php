 @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Role </th>
                <th scope="col">Joined</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('clientuser.edit',[$client->slug,$user->username]) }} ">
                  {{ $user->name }}
                  </a>
                </td>
                <td>@if($user->roles->find(32))
                      Owner
                      @elseif($user->roles->find(33))
                      Manager
                      @endif
                </td>
                <td>{{ ($user->created_at) ? $user->created_at->diffForHumans() : '' }}</td>
                <td>
                  @if($user->status==0)
                    <span class="badge badge-secondary">Unactivated</span>
                  @elseif($user->status ==1)
                    <span class="badge badge-success">Active</span>
                  @elseif($user->status==2)
                    <span class="badge badge-danger">Blocked</span>
                   @else
                   <span class="badge badge-warning">Frozen</span>
                   @endif     
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light mb-3">
          No Users listed
        </div>
        @endif
        <nav aria-label="Page navigation example">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>