
 @if(count($objs)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name </th>

                <th scope="col">Contact</th>
                <th scope="col">College </th>
                <th scope="col">Bachelors </th>
                @foreach($exams as $e)
                <th scope="col">{{$e->name}} </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr id="tr{{$obj['id']}}" @if($obj['pivot']['shortlisted']=="YES")
                  style='background: #dffbe2' 
                @elseif($obj['pivot']['shortlisted']=="MAY BE")
                  style='background: #ffffed' 
                @elseif($obj['pivot']['shortlisted']=="NO")
                  style='background: #fff3f3'
                @endif>

                <th scope="row">{{  ($key+1) }}</th>
                <td>
                  <a href="#" class="showuser"  id="u{{$obj['id']}}" data-id="{{$obj['id']}}" data-score="{{$obj['pivot']['score']}}" data-shortlisted="{{$obj['pivot']['shortlisted']}}" data-url="{{route('profile','@'.$obj['username'])}}">
                  {{ $obj['name'] }} 
                  </a>
                  @if(\auth::user()->profile_complete(null,$obj)==100)
                  <i class="fa fa-check-circle text-success"></i>
                  @endif
                  @if($obj['video'])
                  <i class="fa fa-vcard-o text-secondary"></i>
                  @endif
                </td>
                <td>
                  {{$obj['email']}}<br>{{$obj['phone']}}
                </td>
                
                <td>
                  @if($obj['college_id'])
                    @if($obj['college_id']==5 || $obj['college_id']==295)
                    {{$obj['info']}}
                    @else
                    {{$colleges[$obj['college_id']]['name']}}
                    @endif
                  @endif  

                  @if($obj['branch_id']) - 
                    {{$branches[$obj['branch_id']]->name}}
                  @endif
                </td>
                <td>
                  {{$obj['bachelors']}}%
                </td>
                @foreach($exams as $ex)
                <td >@if(isset($exam_data[$ex->id][$obj['id']]['score'])){{$exam_data[$ex->id][$obj['id']]['score']}}@else - @endif </td>
                @endforeach
                
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
        <nav aria-label="Page navigation  " class="card-nav mt-3">
        {{$objs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
