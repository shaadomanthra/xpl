
<script src="{{ asset('js/pdf.js')}}"></script>

 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col" style="width:5%">Sno</th>
                <th scope="col" style="width:12%">Day</th>
                <th scope="col" style="width:60%">Name </th>
                <th scope="col">Status</th>
                <th scope="col">actions </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <td scope="row">{{$obj->sno}}</td>
                <td>
                  {{\carbon\carbon::parse($obj->day)->format('M d, Y')}}
                </td>
                <td>
                  <h3>{{ $obj->name }}</h3>
                  @if(trim(strip_tags($obj->details)))
                  {!! $obj->details!!}
                  @endif
                  @if(count($obj->resources))
                  <div class="p-3 border my-3 rounded">
                    @foreach($obj->resources as $r)
                        <span class="block_item mb-0 h5" data-id="{{$r->id}}" style="cursor: pointer">
  @if($r->type=='youtube_video_link')
    <i class="fa fa-file-video-o"></i> 
  @elseif($r->type=='ppt_link')
    <i class="fa fa-file-powerpoint-o"></i> 
  @elseif($r->type=='audio_link')
    <i class="fa fa-file-audio-o"></i> 
  @elseif($r->type=='test_link')
    <i class="fa fa-file-code-o"></i> 
  @else
    <i class="fa fa-file-pdf-o"></i> 
  @endif

  {{$r->name}}</span>
  <span class="float-right">
    <a href=
    "{{route('resource.edit',[$app->training->slug,$r->id])}}"><i class="fa fa-edit" ></i> </a>

    <a href=
    "{{route('resource.destroy',[$app->training->slug,$r->id])}}" class="rdelete" data-name="{{$r->name}}"><i class="fa fa-trash"></i> </a>
  </span>
                      @include('appl.training.schedule.embed')
                    @endforeach
                  </div>
                  @endif
                  <a href="{{route('resource.store',[$app->training->slug])}}" class="btn btn-sm btn-outline-info dresource" data-name="{{$obj->name}}" data-id="{{$obj->id}}">Add Resource</a>
                </td>
                
                
                <td>
                  @if($obj->status==0)
                    <span class="badge badge-warning">Draft</span>
                  @elseif($obj->status==1)
                    <span class="badge badge-success">Active</span>
                  @endif
                </td>
                <td>
                  <a href="{{route('schedule.edit',[$app->training->slug,$obj->id])}}" class="btn btn-sm btn-outline-primary">edit</a>
                  <a href="{{route('schedule.destroy',[$app->training->slug,$obj->id])}}" class="btn btn-sm btn-outline-danger ddelete" data-name="{{$obj->name}}">delete</a>
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



<style>
.pdfobject-container { height: 30rem; border: 1px solid rgba(0,0,0,.2); }
</style>