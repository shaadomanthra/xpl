 @if($documents->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$documents->total()}})</th>
                <th scope="col">Document </th>
                <th scope="col">Creator </th>
                <th scope="col">Chapter </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($documents as $key=>$document)  
              <tr>
                <th scope="row">{{ $documents->currentpage() ? ($documents->currentpage()-1) * $documents->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('document.show',[$repo->slug,$document->id]) }} ">
                  {{ $document->name }}
                  </a>
                  <div>
                    {!! str_limit(strip_tags($document->content),200) !!}
                  </div>
                </td>
                <td><a href="{{ route('profile','@'.$document->user->username) }}">{{ $document->user->name }}</a></td>
                <td>{{ $document->structure->name }}</td>
                <td>{{ ($document->created_at) ? $document->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No documents Listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($documents->total() > config('global.no_of_records'))mt-3 @endif">
        {{$documents->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
