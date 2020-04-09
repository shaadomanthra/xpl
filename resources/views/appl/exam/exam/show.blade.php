@extends('layouts.nowrap-white')
@section('title', $exam->name)
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">



<style>
.cardbox
{

  border-radius:5px;
  border:1px solid #e4edf5;
  box-shadow:  2px 3px #e4edf5;
}
.lblue{  background: #fcfdff;}
.dblue{background: #e9f4ff}
.img-cirlce{ border-radius: 50px;max-height: 60px;max-width: 60px;  }
.f18{ font-size: 18px; }
.lborder{ border-left:3px solid #28a745;padding-left:10px; margin-bottom: 10px; border-radius:5px;}

</style>
<div class="line" style="padding:1px;background:#ebf1fb"></div>
@include('flash::message')
<div class="" style="background: #e9f4ff">
  <div class="container">

<div class="row">
  <div class="col-12 col-md-10">
    <nav class="mb-0">
  <ol class="breadcrumb  pt-3" style="background: transparent;padding:0" >
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
    
  </ol>
</nav>
    <div class=' pb-3'>
  <p class="heading_two mb-2" style="font-size:30px;"><i class="fa fa-inbox "></i> {{ $exam->name }}</p>
    </div>
  </div>
  <div class="col-12 col-md-2">
    <div class=" p-3 mt-2 text-center" style='background: #fcfdff;box-shadow: 2px 3px  #e4edf5;border-radius: 5px;'>
      <div class="h6">Participants</div>
      <div class="h2" style="font-family: 'Raleway', sans-serif;font-weight: 800;color:#3155b8;">{{$exam->getUserCount()}}</div>
    </div>
  </div>
</div>

</div>

<div class='p-3 mb-3'  style="background: #4262be">
  <div class='container'>
    <a href="{{route('assessment.show',$exam->slug)}}" class="" style="font-size:20px;color:white;font-family: 'Raleway', sans-serif;"> <i class="fa fa-external-link" style="color:#657ec8"></i> {{route('assessment.show',$exam->slug)}}</a>&nbsp; @if($exam->active==1)
                <span class="badge badge-secondary">Inactive</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif
    @can('update',$exam)
            <span class="btn-group float-right btn-group-sm" role="group" aria-label="Basic example">
              <a href="{{ route('exam.edit',$exam->slug) }}" class="btn btn-outline-light" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i> edit</a>
              <a href="#" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i> delete</a>
            </span>
            @endcan
    </div>
  </div>

  </div>


<div class="container ">
  <div class="row mt-4">

    <div class="col-md-7">

      <div class="card mb-4 ">
        <div class="card-body">
            <div class="row mb-2">
            <div class="col-md-3 pt-1">
              @if(isset($exam->image))
                @if(Storage::disk('public')->exists($exam->image))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/'.$exam->image) }} " class="d-print-none" alt="{{  $exam->name }}" style='max-width:200px;'>
                  </picture>
                </div>
                @endif
              @else
              <div class="text-center">
                <i class="fa fa-newspaper-o fa-5x p-1 d-none d-md-block" aria-hidden="true"></i>
                <i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
              </div>
              @endif
            </div>
            <div class="col-md-9">
              <div class="pt-2 f18 mb-4" style="line-height: 1.5">
              <h4 class="mb-3"><i class="fa fa-angle-right"></i> Description</h4>
              {!! $exam->description !!}
              </div>


              <div class="row mb-2">
            <div class="col-md-4"><i class="fa fa-th"></i>&nbsp; Report</div>
            <div class="col-md-8">
              @if($exam->solutions==1)
                <span class="badge badge-warning">No solutions</span>
              @elseif($exam->solutions==2)
              <span class="badge badge-warning">No report</span>
              @else
                <span class="badge badge-primary">Report with solutions</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4"><i class="fa fa-camera"></i>&nbsp; Camera</div>
            <div class="col-md-8">
              @if($exam->camera==1)
                <span class="badge badge-success">Enabled</span>
              @else
                <span class="badge badge-secondary">Disabled</span>
              @endif
            </div>
          </div>


          


          <div class="row mb-0">
            <div class="col-md-4"> <i class="fa fa-check-square"></i>&nbsp;Exam Status</div>
            <div class="col-md-8">
              @if($exam->status==0)
                <span class="badge badge-warning">Draft</span>
              @elseif($exam->status==1)
                <span class="badge badge-success">Free Access</span>
              @else
                <span class="badge badge-primary">Private</span>
              @endif
            </div>
          </div>

            </div>
            </div>
        </div>
      </div>

      <div class="card mb-4 ">
        <div class="card-body">
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Instructions</h4>
            @if($exam->instructions)
              {!! $exam->instructions !!}
            @else
              -
            @endif
        </div>
      </div>

      <div class=" mb-4 ">
        <div class="">
              <div class="table-responsive">
              <table class="table table-bordered rounded">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sections</th>
                    <th scope="col">Time</th>
                    <th scope="col">Mark per ques</th>
                    <th scope="col">Negative</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($exam->sections as $w=>$section)
                  <tr>
                    <th scope="row">{{($w+1)}}</th>
                    <td><a href="{{ route('sections.show',[$exam->slug,$section->id]) }}">{{$section->name}}({{ count($section->questions)}})</a></td>

                    <td>{{ $section->time }} min</td>
                    <td>{{$section->mark}}</td>
                    <td>@if($section->negative)  -{{ $section->negative}} @else NA @endif</td>
                  </tr>
                            @endforeach
                  
                  
                </tbody>
              </table>
              </div>
        </div>
      </div>

      <div class="card mb-4 ">
        <div class="card-body">
      <h4 class="mb-3"><i class="fa fa-angle-right"></i> Access Codes <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Employer can uniquely name the access codes to categorise the participants based on job opening."></i></h4>
      
      <div class="">
      @foreach(explode(',',$exam->code) as $code)
              @if($code)
              <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}" class="btn btn-outline-primary mb-2 ">{{ $code}}({{ $exam->getUserCount($code)}})</a>
              @else
              <a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-primary">Default({{ $exam->getUserCount($code)}})</a>
              @endif &nbsp;&nbsp;
              @endforeach
       </div>
     </div>
   </div>
      
      <div class="card mb-4 ">
        <div class="card-body">
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Candidates Emails <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Only the listed candidates can attempt the test with a valid access code. If no emails are listed, then the test will be open for all."></i></h4>
            <hr>
            @if($exam->emails)
              {!! nl2br($exam->emails) !!}
              @else
              - None -
              @endif
        </div>
      </div>
     


    </div>

    <div class="col-md-5">

      <div class="row mb-4">
        <div class="col-12 col-md-4">
          <a href="{{ route('sections.index',$exam->slug)}}">
          <div class="cardbox p-4 text-center">
            <img src="{{ asset('img/icons/category.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Sections</h4>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="{{ route('exam.questions',$exam->slug)}}">
          <div class="cardbox p-4 text-center">
            <img src="{{ asset('img/icons/tag.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Questions</h4>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="{{ route('test.accesscode',$exam->slug)}}">
          <div class="cardbox p-4 text-center">
            <img src="{{ asset('img/icons/analytics.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Reports</h4>
            </div>
          </a>
        </div>
      </div>
      @if($exam->getUserCount())
      <div class="h4 mt-3 mb-4" ><i class="fa fa-angle-right"></i> Latest participants <small><span class="text-secondary">({{$exam->getUserCount()}})</span></small><a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-primary btn-sm float-right">View all</a></div>

      @foreach($exam->latestUsers() as $u =>$t)
      <div class='cardbox lblue p-3 mb-3'>
        <div class="row">
          <div class='col-4 col-md-2 '>
            <img src="@if($t->user->image) {{ ($t->user->image)}}@else {{ Gravatar::src($t->user->email, 150) }}@endif" class="img-cirlce " />
          </div>
          <div class='col-8 col-md-10'>
            <div class="f18 mb-0">
              <a href="{{ route('assessment.analysis',[$exam->slug]) }}?student={{$t->user->username}}"><b>{{$t->user->name}}</b></a>

              @if($t->status)
              has attempted the test
              @else
               has scored <b class="text-primary">
                @if($t->score){{ $t->score }}@else 0 @endif</b> out of {{ $t->max }}
              @endif
              <div class="float-right">
              @if($t->user->personality)
                @if($t->user->personality>=8)
                 <span class="badge badge-success"> Grade A</span>
                @elseif($t->user->personality>=5 && $t->user->personality<8)
                  <span class="badge badge-warning">Grade B</span>
                @else
                  <span class="badge badge-secondary">Grade C  </span>
                @endif
              @endif
              
              </div>
            </div>
            <small>{{$t->created_at->diffforHumans()}} </small>

            <div class=''>
              <small class="mr-2">
              <a href="{{ route('assessment.analysis',[$exam->slug]) }}?student={{$t->user->username}}" ><i class="fa fa-bar-chart"></i> Report</a></small>

              <small class="mr-2">
              <a href="{{ route('assessment.solutions',$exam->slug)}}?student={{$t->user->username}}" ><i class="fa fa-check-circle"></i> Responses</a></small>

              <small class="mr-2 float-right @if($t->window_change>5) text-danger @else text-secondary @endif"><i class="fa fa-desktop"></i> Window Swap @if($t->window_change) [{{$t->window_change}}] @else [0] @endif </small>

            </div>
          </div>
        </div>
      </div>
      @endforeach
      
      @endif

      


      


    </div>



  </div> 
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('exam.destroy',$exam->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection