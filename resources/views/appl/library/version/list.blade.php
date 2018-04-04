 @if($versions->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$versions->total()}})</th>
                <th scope="col">Version </th>
                <th scope="col">Creator </th>
                <th scope="col">Concept </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($versions as $key=>$version)  
              <tr>
                <th scope="row">{{ $versions->currentpage() ? ($versions->currentpage()-1) * $versions->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('version.show',[$repo->slug,$version->id]) }} ">
                  {{ $version->name }}
                  </a>
                  <div>
                    {!! str_limit(strip_tags($version->content),200) !!}
                  </div>
                </td>
                <td><a href="{{ route('profile','@'.$version->user->username) }}">{{ $version->user->name }}</a></td>
                <td>{{ $version->structure->name }}</td>
                <td>{{ ($version->created_at) ? $version->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Versions Listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($versions->total() > config('global.no_of_records'))mt-3 @endif">
        {{$versions->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
