
 @if($examtypes->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$examtypes->total()}})</th>
                <th scope="col">Examtypes </th>
                <th scope="col">Slug</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($examtypes as $key=>$examtype)  
              <tr>
                <th scope="row">{{ $examtypes->currentpage() ? ($examtypes->currentpage()-1) * $examtypes->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('examtype.show',$examtype->slug) }} ">
                  {{ $examtype->name }}
                  </a>
                </td>
                <td>
                  <span class="badge badge-warning">{{ $examtype->slug }}</span>
                </td>
                <td>{{ ($examtype->created_at) ? $examtype->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Tests listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($examtypes->total() > config('global.no_of_records'))mt-3 @endif">
        {{$examtypes->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
