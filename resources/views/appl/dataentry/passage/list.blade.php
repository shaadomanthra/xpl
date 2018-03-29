 @if($passages->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$passages->total()}})</th>
                <th scope="col">Passage </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($passages as $key=>$passage)  
              <tr>
                <th scope="row">{{ $passages->currentpage() ? ($passages->currentpage()-1) * $passages->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('passage.show',[$project->slug,$passage->id]) }} ">
                  {{ $passage->name }}
                  </a>
                  <div>
                    {!! str_limit(strip_tags($passage->passage),200) !!}
                  </div>
                </td>
                <td>{{ ($passage->created_at) ? $passage->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Passages Listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($passages->total() > config('global.no_of_records'))mt-3 @endif">
        {{$passages->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
