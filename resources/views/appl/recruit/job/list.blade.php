 @if($jobs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$jobs->total()}})</th>
                <th scope="col">Position</th>
                <th scope="col">Vacancy</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($jobs as $key=>$job)  
              <tr>
                <th scope="row">{{ $jobs->currentpage() ? ($jobs->currentpage()-1) * $jobs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('job.show',$job->slug) }} ">
                  {{ $job->title }}
                  </a>
                </td>
                <td>{{ $job->vacancy }}</td>
                <td>@if($job->status==0) <span class="badge badge-success">Open</span> @else <span class="badge badge-warning">Closed</span> @endif</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Jobs listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($jobs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$jobs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
