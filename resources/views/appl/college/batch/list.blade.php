
 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Students </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route($app->module.'.show',$obj->slug) }} ">
                  @if($obj->image) <img src="{{ asset('/img/batch/'.$obj->image.'.png')}}" width="30px"> @endif &nbsp;{{ $obj->name }}
                  </a>
                </td>
                <td>
                  {{count($obj->users)}}
                </td>
                
                </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Batches listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
