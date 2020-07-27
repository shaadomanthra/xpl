
 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Name </th>

                <th scope="col">Contact</th>
                <th scope="col">College </th>
                <th scope="col">Bachelors </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('profile','@'.$obj->username) }} ">
                  {{ $obj->name }}
                  </a>
                  @if($obj->profile_complete()==100)
                  <i class="fa fa-check-circle text-success"></i>
                  @endif
                  @if($obj->video)
                  <i class="fa fa-vcard-o text-secondary"></i>
                  @endif
                </td>
                <td>
                  {{$obj->email}}<br>{{$obj->phone}}
                </td>
                
                <td>
                  @if($obj->college)
                    @if($obj->college->id==5 || $obj->college->id==295)
                    {{$obj->info}}
                    @else
                    {{$obj->college->name}}
                    @endif
                  @endif  

                  @if($obj->branch) - {{$obj->branch->name}}@endif
                </td>
                <td>
                  {{$obj->bachelors}}%
                </td>
                
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
