@extends('layouts.nowrap-white')
@section('title', 'Participants - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Reports </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-area-chart "></i> Attempts (@if(request()->get('code'))  {{request()->get('code')}} @else All @endif) - {{count($report)}}

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2">
         <a href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-success float-right">Download Excel</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">

<div  class="row  mb-4 mt-4">

  <div class="col-12 ">
 
        

         
      @if(count($report)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Sno</th>
                <th scope="col">Name</th>
                <th scope="col">Cheating</th>
                @foreach($exam_sections as $sec)
                <th scope="col">{{$sec->name}}</th>
                @endforeach
                <th scope="col">Score</th>
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

                  @if($r->user->personality)
                @if($r->user->personality>=8)
                 <span class="badge badge-success"> Grade A</span>
                @elseif($r->user->personality>=5 && $t->user->personality<8)
                  <span class="badge badge-warning">Grade B</span>
                @else
                  <span class="badge badge-secondary">Grade C  </span>
                @endif
              @endif
                  
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
                @foreach($sections[$r->user->id] as $s)
                <td>
                  {{ $s->score }}
                </td>
                @endforeach
                <td>
                  @if(!$r->status)
                  {{ $r->score }} / {{ $r->max }}
                  @else
                  -
                  @endif
                </td>
                <td>
                <form method="post" class='form-inline' action="{{ route('assessment.delete',$exam->slug)}}?url={{ request()->url()}}" >
                  @if(!$r->status)
                  <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$r->user->username}}">
                    <i class='fa fa-bar-chart'></i> Report
                  </a>&nbsp;&nbsp;&nbsp;
                  <a href="{{ route('assessment.solutions',$exam->slug)}}?student={{$r->user->username}}" ><i class='fa fa-commenting-o'></i> responses</a>&nbsp;&nbsp;&nbsp;
                  @else
                  - &nbsp;&nbsp;&nbsp;
                  @endif
                  @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $r->user->id }}">
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
      </div>


       </div>


 </div>
 
</div>

@endsection


