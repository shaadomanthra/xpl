 @if($docs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">#({{$docs->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Joined</th>
                <th scope="col">Visibility</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($docs as $key=>$doc)  
              <tr>
                <th scope="row">{{ $docs->currentpage() ? ($docs->currentpage()-1) * $docs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('docs.show',$doc->slug) }} ">
                  {{ $doc->name }}
                  </a>
                </td>
                <td>{{ ($doc->created_at) ? $doc->created_at->diffForHumans() : '' }}</td>
                 <td>
                  @if($doc->privacy==0)
                    Public
                  @elseif($doc->privacy ==1)
                    Site Members Only
                   @endif     
                </td>
                <td>
                  @if($doc->status==0)
                    Draft
                  @elseif($doc->status ==1)
                    Published
                   @endif     
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light mb-3">
          No Docs listed
        </div>
        @endif
        <nav aria-label="Page navigation example">
        {{$docs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>