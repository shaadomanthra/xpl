
 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col" style="width: 5%">#({{$objs->total()}})</th>
                <th scope="col" style="width: 60%">Name </th>
                <th scope="col" style="width: 10%">Category</th>
                <th scope="col" style="width: 10%">Status</th>
                <th scope="col" style="width: 20%">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  
                  <a href=" {{ route($app->module.'.show',$obj->id) }} ">
                  <h4 class="mb-0">{{ $obj->name }}</h3>
                  </a>
                  {!! $obj->description !!}
                </td>
                <td>
                  {!! $obj->label !!}
                </td>
                <td>
                  @if($obj->status==0)
                    <span class="badge badge-warning">Inactive</span>
                  @elseif($obj->status==1)
                    <span class="badge badge-success">Active</span>
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
          No {{ $app->module }} found
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(request()->except(['page','search']))->links()  }}
      </nav>
