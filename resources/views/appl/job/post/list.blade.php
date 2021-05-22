
 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Title </th>
                <th scope="col">Author</th>
                <th scope="col">Applicants</th>
                <th scope="col">Status</th>
                <th scope="col">Created </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route($app->module.'.show',$obj->slug) }} ">
                  {{ $obj->title }}
                  </a>
                </td>
                <td>
                  {{$obj->user->name}}
                </td>
                <td>
                  {{$obj->users_count}}
                </td>
                <td>
                  @if($obj->status==0)
                    <span class="badge badge-secondary">Draft</span>
                  @elseif($obj->status==1)
                    <span class="badge badge-success">Public</span>
                    @elseif($obj->status==2)
                <span class="badge badge-warning">Unlisted</span>
              @else
                <span class="badge badge-info">Priavte</span>
                  @endif
                </td>
                <td>{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No {{ $app->module }} listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
