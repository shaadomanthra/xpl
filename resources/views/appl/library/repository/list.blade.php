 @if($repos->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$repos->total()}})</th>
                <th scope="col">Project </th>
                <th scope="col">Slug</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($repos as $key=>$repo)  
              <tr>
                <th scope="row">{{ $repos->currentpage() ? ($repos->currentpage()-1) * $repos->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('library.show',$repo->slug) }} ">
                  {{ $repo->name }}
                  </a>
                </td>
                <td>{{ $repo->slug }}</td>
                <td>{{ ($repo->created_at) ? $repo->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No repositories listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($repos->total() > config('global.no_of_records'))mt-3 @endif">
        {{$repos->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
