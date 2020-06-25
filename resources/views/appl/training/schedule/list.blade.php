<script src="{{ asset('js/pdf.js')}}"></script>

      @foreach($objs as $s)
      <div class="row mb-4 no-gutters">
        <div class="col-4 col-md-2">
          <div class="mr-1 mr-md-2">
          <div class="bg-warning text-white rounded p-3 mb-3 text-center " ><span class="h5">{{\carbon\carbon::parse($s->day)->format('M')}}</span><br>
            <div class="display-3 d-inline">{{\carbon\carbon::parse($s->day)->format('d')}}</div>
          </div>

        @if($s->users->count())
          <div class="row no-gutters">
            <div class="col-12 col-md-6 ">
              <div class="card mr-md-1 mb-2 mb-md-0">
                <div class="p-2 text-center">
                  <small class="present present_{{$s->id}}" data-id="{{$s->present_ids()}}">Present</small>
                  <div class="display-4">
                    @if($s->users->count())
                    {{$s->users->count()}}
                    @else
                    -
                    @endif
                  </div>
                </div>
              </div>
            </div>
             <div class="col-12 col-md-6">
              <div class="card ml-md-1">
                <div class="p-2 text-center">
                  <small>Absent</small>
                  <div class="display-4">
                    @if($s->users->count())
                    {{($app->training->users->count() - $s->users->count())}}
                    @else
                    -
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
        </div>
        <div class="col-8 col-md-7">
          <div class="bg-white rounded ml-1 ml-md-2 mb-3" style="box-shadow: 1px 1px 1px 1px #eee;border:1px solid #eee">
            <div class="card-body pt-5">
              
              <h4 class="mb-3">{{$s->name}}</h4>
              <div class="progress" style="height:5px;">
                <div class="progress-bar bg-success present_{{$s->id}}" role="progressbar" style="width: {{$s->present($app->training,1)}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-danger absent_{{$s->id}}" role="progressbar" style="width: {{$s->absent($app->training,1)}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @if(strip_tags(str_replace('&nbsp;','',$s->details)))
              <div class="mt-4">{!! $s->details !!}</div>
              @endif


              @if($s->meeting_link)
              <div class="py-3">
              <a href="{{$s->meeting_link}}" class="btn btn-outline-primary" target="_blank">Join Session</a>
              </div>
              @endif

             
              
            </div>
            <div class="p-5" style="background: #f8f8f8;border-radius:0px 5px 5px 0px;">
            @foreach($s->resources as $r)
                      <span class="block_item mb-0 " data-id="{{$r->id}}" style="cursor: pointer">
  @if($r->type=='youtube_video_link')
    <i class="fa fa-file-video-o"></i> 
  @elseif($r->type=='ppt_link')
    <i class="fa fa-file-powerpoint-o"></i> 
  @elseif($r->type=='audio_link')
    <i class="fa fa-file-audio-o"></i> 
  @elseif($r->type=='test_link')
    <i class="fa fa-file-code-o"></i> 
    @elseif($r->type=='external_link')
    <i class="fa fa-file-excel-o"></i> 
  @else
    <i class="fa fa-file-pdf-o"></i> 
  @endif

  {{$r->name}}</span>
  
                      @include('appl.training.schedule.embed')
                    @endforeach

          </div>
          </div>
          
        </div>

        <div class="col-12 col-md-3">
          <div class="bg-light border p-3 rounded mb-3  ml-md-3">
          @can('edit',$obj)
            <span class="float-right">
            @if($s->status==0)
                    <span class="badge badge-warning">Draft</span>
                  @elseif($s->status==1)
                    <span class="badge badge-success">Active</span>
                  @endif
                </span>
            <h4>Tools</h4>
            
                
             <a href="{{route('schedule.edit',[$app->training->slug,$s->id])}}" class="btn btn-sm btn-outline-primary mb-1 "><i class="fa fa-edit"></i> Edit</a>
                  <a href="{{route('schedule.destroy',[$app->training->slug,$s->id])}}" class="btn btn-sm btn-outline-danger ddelete mb-1" data-name="{{$s->name}}"><i class="fa fa-trash"></i> Delete</a>
                  <a href="{{route('resource.store',[$app->training->slug])}}" class="btn btn-sm btn-outline-info dresource mb-1" data-name="{{$s->name}}" data-id="{{$s->id}}"><i class="fa fa-file-o"></i> Add Resource</a>
                  <a href="{{route('schedule.attendance',[$app->training->slug,$s->id])}}" class="btn btn-sm btn-outline-success dattendance" data-name="{{$s->name}}"><i class="fa fa-user-plus"></i> Attendance</a>
          @endcan
          </div>


        </div>

      </div>
      @endforeach




<div class="modal fade" id="ddelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion <span class="dname" style="display: none">sample</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('schedule.destroy',[$app->training->slug,$obj->id])}}" class="ddelete_form">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rdelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion <span class="rname" style="display: none">sample</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('resource.destroy',[$app->training->slug,$obj->id])}}" class="rdelete_form">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dresource" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="" class="dresource_form">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Resource <span class="drname" style="display: none">sample</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" class="form-control" id="example" aria-describedby="emailHe" placeholder="Enter name" name="name">
        </div>
         <div class="form-group">
          <label for="exampleFormControlSelect1">Type</label>
          <select class="form-control" id="exampleFormControlSelect1" name="type">
            <option value="youtube_video_link">Youtube Video Link</option>
            <option value="pdf_link">PDF Link</option>
            <option value="ppt_link">PPT Link</option>
            <option value="audio_link">Audio Link</option>
            <option value="test_link">Test Link</option>
            <option value="external_link">External Link</option>
          </select>
        </div>
         <div class="form-group">
          <label for="exampleFormControlInput1">Link</label>
          <input type="text" class="form-control" id="exampleFormControlInput1" name="link" placeholder="Enter the link ">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ \auth::user()->id }}">
        <input type="hidden" name="status" value="1">
        <input type="hidden" class="dschedule_id"name="schedule_id" value="">
          <button type="submit" class="btn btn-success">Add</button>
        
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="dattendance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="" class="dattendance_form">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attendance <span class="daname" style="display: none">sample</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        @foreach($app->training->users as $u)
          <div class="col-12 col-md-3">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input_{{$u->id}}" id="exampleCheck1_{{$u->id}}" name="attendance[]" value="{{$u->id}}" >
              <label class="form-check-label_{{$u->id}}" for="exampleCheck1_{{$u->id}}">{{$u->name}}</label>
            </div>
          </div>
        @endforeach
        </div>
       
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ \auth::user()->id }}">
        <input type="hidden" name="status" value="1">
        <input type="hidden" class="daschedule_id"name="schedule_id" value="">
          <button type="submit" class="btn btn-success">Save</button>
        
      </div>
      </form>
    </div>
  </div>
</div>


<style>
.pdfobject-container { height: 30rem; border: 1px solid rgba(0,0,0,.2); }
</style>