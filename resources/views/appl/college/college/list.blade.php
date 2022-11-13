
 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name </th>
                <th scope="col">Students</th>
                <th scope="col">Location</th>
                <th scope="col">Zone </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr class="" @if($obj->type=='degree') style="background: #ffe7e7e8;"  @elseif($obj->type=='btech') style="background: #f8ffe7e8;" @endif>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route($app->module.'.show',$obj->id) }} ">
                  {{ $obj->name }}
                  </a>
                </td>
                <td>
                  @if(isset($lusers[$obj->id]))
                  {{ count($lusers[$obj->id])}}
                  @else
                  0
                  @endif
                </td>
                <td>
                  {{ $obj->location}}
                </td>
                 <td>
                  {{ $obj->college_website}}
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
