 @if($lpassages->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$lpassages->total()}})</th>
                <th scope="col">Passage </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lpassages as $key=>$lpassage)  
              <tr>
                <th scope="row">{{ $lpassages->currentpage() ? ($lpassages->currentpage()-1) * $lpassages->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('lpassage.show',[$repo->slug,$lpassage->id]) }} ">
                  {{ $lpassage->name }}
                  </a>
                  <div>
                    {!! str_limit(strip_tags($lpassage->passage),200) !!}
                  </div>
                </td>
                <td>{{ ($lpassage->created_at) ? $lpassage->created_at->diffForHumans() : '' }}</td>
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
        <nav aria-label="Page navigation  " class="card-nav @if($lpassages->total() > config('global.no_of_records'))mt-3 @endif">
        {{$lpassages->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
