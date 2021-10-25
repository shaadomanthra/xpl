@if($report->total()!=0)
        <div class="table-responsive">
          @if($exam->slug!='psychometric-test')
          <div class="bg-light p-3 border"> Sorted by : <span class="badge badge-warning">@if(request()->get('score')) Score @else Date @endif</span></div>
          @endif
          <table class="table table-bordered mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Sno</th>
                <th scope="col" style="width:10%">Name</th>
                <th scope="col">Cheating</th>
                @if($exam->slug!='psychometric-test' && $exam->examtype->slug!='psychometric-test')

                @foreach($exam_sections as $sec)
                  @if($sec->name=='typing')
                  <th scope="col">Accuracy</th>
                  @else
                  <th scope="col"><a href="" data-toggle="tooltip" title="{{$sec->name}}">{{first_letters($sec->name)}}</a></th>
                  @endif
                @endforeach

                   @if($sec->name=='typing')
                    <th scope="col">WPM Score</th>
                    @else
                      <th scope="col">Score</th>
                    @endif
                @endif
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($report as $key=>$r)
              <tr @if($r['cheat_detect']==1)
                  style='background: #fff3f3'
                @elseif($r['cheat_detect']==2)
                  style='background: #ffffed'
                @else

                @endif >
                <th scope="row">{{$key+1 }}</th>
                <td>
                  <a href="#" class="showuser"  data-url="{{route('profile','@'.$users[$r['user_id']]->username)}}" >
                  {{ $users[$r['user_id']]->name }}</a>

                  @if(isset($users[$r['user_id']]->phone))
                    <div>{{$users[$r['user_id']]->email}}<br>{{$users[$r['user_id']]->phone}}</div>
                  @endif

                    
                </td>
                <td>
                @if($r['cheat_detect']==1)
                  <span class="text-danger"><i class="fa fa-ban "></i> Potential Cheating  </span>
                @elseif($r['cheat_detect']==2)
                  <span class="text-warning"><i class="fa fa-ban"></i> Cheating - Not Clear </span>
                @else
                  <span class="text-success"><i class="fa fa-check-circle"></i> No Cheating  </span>
                @endif
                </td>
                @if(strtolower(str_replace(" ","",$exam->examtype->name))!='psychometrictest')
               @if(isset($sections[$users[$r['user_id']]->id]))
                @foreach($sections[$users[$r['user_id']]->id] as $s)
                <td>
                  {{ $s->score }} @if($sec->name=='typing')% @endif
                </td>
                @endforeach
              @else
              <td>-</td>
              @endif

                <td>
                  @if(!$r['status'])
                  {{ $r['score'] }}
                    @if($r['comment'])
                      <br><span class="text-warning"><i class="fa fa-commenting-o" ></i> Added</span>
                    @endif
                  @else
                  <span class="badge badge-warning">Under Review</span>
                  @endif
                </td>
                @endif
                <td>
                  {{\carbon\carbon::parse($r['created_at'])->format('d-m-Y')}}
                </td>
                <td>
                <form method="post" class='form-inline' action="{{ route('assessment.delete',$exam->slug)}}?url={{ request()->url()}}" >

                  <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$users[$r['user_id']]->username}}">
                    <i class='fa fa-bar-chart'></i> Report
                  </a>&nbsp;&nbsp;&nbsp;
                  @if($exam->slug!='psychometric-test' && $exam->examtype->slug!='psychometric-test')
                  <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$users[$r['user_id']]->username}}" ><i class='fa fa-commenting-o'></i> responses</a>&nbsp;&nbsp;&nbsp;
                  @endif

                  @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
                  @can('update',$exam)
                  <a href="{{ route('assessment.try',$exam->slug)}}?student={{$users[$r['user_id']]->username}}&admin=1&code={{$r['code']}}" ><i class='fa fa-edit'></i> modify</a>&nbsp;&nbsp;&nbsp;
                  @endcan
                  @endif

                  @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $users[$r['user_id']]->id}}">
                    <input type="hidden" name="test_id" value="{{ $exam->id }}">
                    <button class="btn btn-link  p-0" type="submit"><i class='fa fa-trash'></i> delete</button>
                  @endif
                </form>

                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Reports listed
        </div>
        @endif
<nav aria-label="Page navigation  " class="card-nav @if($report->total() > 30)mt-3 @endif">
        {{$report->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
