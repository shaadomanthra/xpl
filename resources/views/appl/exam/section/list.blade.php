 @if($sections->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$sections->total()}})</th>
                <th scope="col">Sections </th>
                <th scope="col">Questions</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sections as $key=>$section)  
              <tr>
                <th scope="row">{{ $sections->currentpage() ? ($sections->currentpage()-1) * $sections->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('sections.show',[$exam->slug,$section->id]) }} ">
                  {{ $section->name }}
                  </a>
                </td>
                <td>
                  {{ count($section->questions) }}
                </td>
                <td>{{ ($section->created_at) ? $section->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Sections listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($sections->total() > config('global.no_of_records'))mt-3 @endif">
        {{$sections->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
