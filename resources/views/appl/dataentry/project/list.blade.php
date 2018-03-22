 @if($projects->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">#({{$projects->total()}})</th>
                <th scope="col">Project </th>
                <th scope="col">Slug</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($projects as $key=>$project)  
              <tr>
                <th scope="row">{{ $projects->currentpage() ? ($projects->currentpage()-1) * $projects->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('dataentry.show',$project->slug) }} ">
                  {{ $project->name }}
                  </a>
                </td>
                <td>{{ $project->slug }}</td>
                <td>{{ ($project->created_at) ? $project->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No projects listed
        </div>
        @endif
        <nav aria-label="Page navigation example">
        {{$projects->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>