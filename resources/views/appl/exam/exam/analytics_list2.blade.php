
        

         
      @if(count($report)!=0)
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
                
                <th scope="col">Window swap</th>
                <th scope="col">Screenshots</th>
                <th scope="col">Face Detect</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($report as $key=>$r)  
              <tr @if($r->cheat_detect==1)
                  style='background: #fff3f3' 
                @elseif($r->cheat_detect==2)
                  style='background: #ffffed' 
                @else
                  
                @endif >
                <th scope="row">{{$key+1 }}</th>
                <td>
                  <a href="{{route('profile','@'.$r->user->username)}}"  >
                  {{ $r->user->name }}</a>
                </td>
                <td>
                @if($r->cheat_detect==1)
                  <span class="text-danger"><i class="fa fa-ban "></i> Potential Cheating  </span>
                @elseif($r->cheat_detect==2)
                  <span class="text-warning"><i class="fa fa-ban"></i> Cheating - Not Clear </span>
                @else
                  <span class="text-success"><i class="fa fa-check-circle"></i> No Cheating  </span>
                @endif
                </td>
                
                <td>
                  {{$r->window_change}}
                </td>
                <td>
                  @if(Storage::disk('public')->exists('tests/'.$r->user->username.'_'.$exam->id.'_1.jpg'))
                  <div class="row mb-4">
                    @for($i=1;$i<21;$i++)
                      @if(Storage::disk('public')->exists('tests/'.$r->user->username.'_'.$exam->id.'_'.$i.'.jpg'))
                      <div class='col-6 col-md-2'>
                        <img src="{{ asset('/storage/tests/'.$r->user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
                      </div>
                      @endif
                    @endfor
                  </div>
                  @endif
                </td>
                <td>
                  {{$r->face_detect}}
                </td>
                <td>
                -
                  
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
      </div>
