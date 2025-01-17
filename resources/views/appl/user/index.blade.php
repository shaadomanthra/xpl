@extends('layouts.nowrap-white')
@section('title', $user->name.' ')
@section('content')

@auth

@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','client-manager','tpo','hr-manager']) || \Auth::user()->id == $user->id)
<div  class="row ">
  <div class="col">
    @include('flash::message')  

    <div class=" mb-3">
      <div style="height:150px;background: linear-gradient(70deg,#F44336, #3f51b5);"></div>

      <div class="container text-right d-none d-md-block" style="height:180px;margin-top: -100px;">
                <img class="img-thumbnail rounded-circle mb-3 mr-5"src="@if($user->image) {{ ($user->image)}}@else {{ Gravatar::src($user->email, 150) }}@endif" style="width:180px;height:180px">
              </div>
      <div class="container text-right d-block d-md-none" style="height:100px;margin-top: -120px;">
                <img class="img-thumbnail rounded-circle mb-3 mr-5"src="@if($user->image) {{ ($user->image)}}@else {{ Gravatar::src($user->email, 150) }}@endif" style="width:80px;height:80px">
              </div>

      <div class="container  rounded bg-light" style="margin-top: -100px;">
        <div class="row">
         
          <div class="col-md-12">
            <div class="mt-3 mt-md-5 ">
             <h2 class="mb-md-2  heading_two mr-md-4 ml-4" >{{ $user->name }} @if(auth::user()->profile_complete($user->username)==100)<i class="fa fa-check-circle text-success"></i>@endif

               
             </h2>
             
              <div>
              
              </div>
              
            <div class="mr-4 ml-4">
            

              
             <p class="pt-1"></p>


             @if(count($colleges))
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-building'></i> &nbsp; College</dt>
                <dd class="col-sm-7">@if($user->college_id) @if($user->college_id==5 || $user->college_id==295) {{$user->info}} @else {{ $colleges[$user->college_id]->name }} @endif @else {{$user->info}} @endif</dd>
              </dl>
             @endif

             @if($branches )
             @if(isset($branches[$user->branch_id]))
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-bookmark-o'></i> &nbsp; Branch</dt>
                <dd class="col-sm-7">@if($user->branch_id) {{  $branches[$user->branch_id]->name  }} @endif</dd>
              </dl>
            @endif
             @endif

             @if($user->roll_number)

             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-address-book-o'></i> &nbsp; 
                @if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || subdomain()=='packetprep')
              Roll Number
                @else
                Fathers or Mothers Name / Roll number
                @endif</dt>
                <dd class="col-sm-7">{{$user->roll_number}}</dd>
              </dl>
             @endif

             @if($user->year_of_passing)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-tint'></i> &nbsp; Year of Passing</dt>
                <dd class="col-sm-7">{{$user->year_of_passing}}</dd>
              </dl>
             @endif

             @if($user->Phone)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-venus'></i> &nbsp; Candidate Phone</dt>
                <dd class="col-sm-7">{{$user->phone}}</dd>
              </dl>
             @endif

             @if($user->gender)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-venus'></i> &nbsp; 
                  @if(strlen($user->gender)<9) Gender @else Fathers Phone @endif</dt>
                <dd class="col-sm-7">{{ucfirst($user->gender)}}</dd>
              </dl>
             @endif

             @if($user->dob)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-calendar'></i> &nbsp; Date of Birth</dt>
                <dd class="col-sm-7">{{$user->dob}}</dd>
              </dl>
             @endif

             @if($user->current_city)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-address-card-o'></i> &nbsp; Current City  @if(subdomain()!='packetprep')(or) Address @endif</dt>
                <dd class="col-sm-7">@if(strip_tags(trim($user->current_city))) {{$user->current_city}} @else - @endif</dd>
              </dl>
             @endif

             @if($user->hometown)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-home'></i> &nbsp; Hometown @if(subdomain()!='packetprep')(or) District @endif</dt>
                <dd class="col-sm-7">{{$user->hometown}}</dd>
              </dl>
             @endif

             @if($user->personality && subdomain()=='packetprep')
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-globe'></i> &nbsp; State </dt>
                <dd class="col-sm-7">{{$user->personality}}</dd>
              </dl>
             @endif

             @if($user->info && subdomain()=='packetprep')
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-th'></i> &nbsp; Batch </dt>
                <dd class="col-sm-7">{{$user->info}}</dd>
              </dl>
             @endif

             @if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
             @if($user->metrics)
             <dl class="row mb-0">
                <dt class="col-sm-5"><i class='fa fa-gg'></i> &nbsp; Trained In</dt>
                <dd class="col-sm-7">{{implode(', ',$user->metrics->pluck('name')->toArray())}}</dd>
              </dl>
             @endif
             @endif
             
             @can('update',$user)
              <a href="{{route('profile.edit','@'.$user->username)}}?complete_profile=1" class="btn btn-success mt-3 mb-4 d-print-none"><i class="fa fa-edit"></i> Edit</a>
              @endcan
              @can('manage',$user)
              <a href="{{route('profile.manage','@'.$user->username)}}" class="btn btn-primary mt-3 mb-4 d-print-none "><i class="fa fa-gear"></i> Manage</a>
              @endcan

            </div>




@auth

@if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || subdomain()=='packetprep' )
      <div class="row mr-2 mb-4 ml-2">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              @if(!Storage::disk('s3')->exists('resume/resume_'.\auth::user()->username.'.pdf') )
              <a href="{{ route('resume.upload')}}" class="btn btn-sm btn-secondary float-right"> 
                Upload your resume
              </a>
              @else
              <a href="{{ route('resume.upload')}}" class="btn btn-sm btn-secondary float-right"> 
                View your resume
              </a>
              @endif
              <h3>My Resume </h3>
              

            </div>
          </div>
        </div>
    </div>

      <div class="row mr-2 ml-2">
        <div class="col-12 col-md ">
          <h3 class=" p-3 mb-0 bg-white border border-bottom-0"><i class='fa fa-university'></i> Academic Scores</h3>
         
          <div class="table-responsive">
            <table class="table table-bordered bg-light">
  <thead>
    <tr class="">
      <th scope="col">Board</th>
      <th scope="col">CGPA / Percentage </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Class 10</td>
      <td>
        @if($user->tenth)
        {{$user->tenth}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Class 12</td>
      <td>
        @if($user->twelveth)
        {{$user->twelveth}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Graduation</td>
      <td>
        @if($user->bachelors)
        {{$user->bachelors}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Masters</td>
      <td>
        @if($user->masters)
        {{$user->masters}}
        @else
          - 
        @endif
      </td>
    </tr>

  </tbody>
</table>
          </div>
        </div>

        @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
          <div class="col-12 col-md-5 ">
          @include('appl.user.video')
          </div>
        @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
          <div class="col-12 col-md-5 ">
          @include('appl.user.video')
          </div>
        @else
        @endif

        
      </div>

    @elseif(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','client-manager','tpo','hr-manager']))
    
     

    @endif
@endauth
 
 @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','client-manager','tpo','hr-manager']))
      <div class="px-3">
      <div class="card bg-white d-print-none ">
        <div class="card-body">
          <h3>Admin Tools</h3>
          <button class="btn btn-outline-dark" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">Reset password to 12345</button>
          <button class="btn btn-outline-dark" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal2">Reset password to abcde</button>
          <button class="btn btn-outline-dark" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal3">Reset password to dd@809</button>
          <button class="btn btn-outline-danger" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal4">Delete Account</button>
        </div>
      </div>
    </div>

    @endif

 @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','client-manager','tpo','hr-manager']))

 @if(count($user->tests())!=0)
  <div class="rounded table-responsive mt-4 px-3">
            <table class="table table-bordered {{$i=0}}">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tests</th>
                  <th scope="col">Score</th>
                  <th scope="col">Details</th>
                  <th scope="col">Attempted</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($user->tests() as $k=>$test)

                 <tr>
                  <th scope="row">{{ $i=$i+1}}</th>
                  <td>
                    <a href="{{ route('assessment.analysis',$test->slug) }}?student={{$user->username}}">{{$test->name}}</a>
                  </td>

                  <td>

                    @if(!$test->attempt_status)
                      
                      {{$test->score}} / {{$test->max}}
                     
                    @else
                     -
                    @endif
                  </td>
                   <td>
                      {!!$test->details !!}
                   </td>
                  <td>{{date('d M Y', strtotime($test->attempt_at))}}</td>
                  <td> 
                      @if(!$test->attempt_status)
                      <span class="badge badge-success">Completed</span>
                      @else
                      <span class="badge badge-warning">Under Review</span>
                      @endif
                    
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
  
        @endif


        @if(count($user->mycourses())!=0)
         <div class="rounded table-responsive mt-4 px-3">
            <table class="table table-bordered {{$i=0}}">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Course</th>
                  <th scope="col">Practice</th>
                  <th scope="col">Tests</th>
                </tr>
              </thead>
              <tbody class="{{$k=1}}">
                @foreach($user->mycourses() as $a=>$c)
                @if($c)
                  <tr>
                    <td>{{($k++)}}</td>
                    <td>{{$c->name}}</td>
                    <td>
                      @if($c->practice || $c->ques_count)
                        {{$c->practice}} / {{$c->ques_count}} <br>
                      @else
                      -
                      @endif

                      @if($c->ques_count)
                      <div class="progress" style="height:8px">
                        <div class="progress-bar" role="progressbar" style="width: {{round($c->practice/$c->ques_count*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      @endif
                    </td>
                    <td>
                      @if($c->attempt_count || $c->exam_count)
                      {{$c->attempt_count}} / {{$c->exam_count}} <br>
                      @else
                      -
                      @endif
                      @if($c->exam_count)
                      <div class="progress" style="height:8px">
                        <div class="progress-bar" role="progressbar" style="width: {{round($c->attempt_count/$c->exam_count*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      @endif
                    </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>

        @endif
        @endif
      
            </div>

          </div>
        </div>
        
      
     </div>
   </div>

   @else
    <h1>Account is private</h1>
   @endif

@else

  <h1>Account is private</h1>
@endauth



  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Password update to 12345</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('profile.update','@'.$user->username)}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="newpassword" value="12345">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-success">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Password update to abcde</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('profile.update','@'.$user->username)}}">
        <input type="hidden" name="_method" value="PUT">

        <input type="hidden" name="newpassword" value="abcde">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-success">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        <h5 class="modal-title" id="exampleModalLabel">Confirm Password update to dd@809</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('profile.update','@'.$user->username)}}">
        <input type="hidden" name="_method" value="PUT">

        <input type="hidden" name="newpassword" value="dd@809">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-success">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        
        <form method="post" action="{{route('profile.update','@'.$user->username)}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="delete" value="1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection


