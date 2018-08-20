 @if($clients->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$clients->total()}})</th>
                <th scope="col">Project </th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $key=>$client)  
              <tr>
                <th scope="row">{{ $clients->currentpage() ? ($clients->currentpage()-1) * $clients->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('client.show',$client->slug) }} ">
                  {{ $client->name }}
                  </a>
                </td>
                <td>{{ $client->slug }}</td>
                <td>
                   @if($client->status==0)
                      <span class="badge badge-secondary">Unpublished</span>
                    @elseif($client->status==1)
                      <span class="badge badge-success">Published</span>
                    @elseif($client->status==2)
                      <span class="badge badge-warning">Request Hold</span>
                    @else
                      <span class="badge badge-danger">Terminated</span>
                    @endif
                </td>
                <td>{{ ($client->created_at) ? $client->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Clients listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($clients->total() > config('global.no_of_records'))mt-3 @endif">
        {{$clients->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
