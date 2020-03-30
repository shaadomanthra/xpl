@extends('layouts.app')
@section('title', 'Report - '.$exam->name)
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{ $exam->name}}</a></li>
    <li class="breadcrumb-item">Report - @if(request()->get('code')) {{request()->get('code')}} @else All @endif</li>
  </ol>
</nav>

@include('flash::message')

<div class="p-4   rounded  mb-4" style="background: #f7f1e3;border: 2px solid #d1ccc0;">
  <a href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn btn-sm btn-outline-primary float-right">Download Excel</a>
      <h1 class="display-5 "><i class="fa fa-bar-chart"></i> {{ ucfirst($exam->name) }} - Report
    </h1>
    @if(request()->get('code'))
      Access Code: <span class="badge badge-warning"> {{ strtoupper(request()->get('code')) }}</span>
    @endif


    </div>

<div  class="row ">

  <div class="col-12 ">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        

        <div id="search-items">
         
 @if(count($report)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($report)}})</th>
                <th scope="col">Name</th>
                @foreach($exam_sections as $sec)
                <th scope="col">{{$sec->name}}</th>
                @endforeach
                <th scope="col">Score</th>
                <th scope="col">View</th>
                @if(\auth::user()->isAdmin())
                <th scope="col">Delete</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($report as $key=>$r)  
              <tr>
                <th scope="row">{{$key+1 }}</th>
                <td>
                  <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$r->user->username}}">{{ $r->user->name }}</a>
                  
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
                  @if(!$r->status)
                  <a href="{{route('profile','@'.$r->user->username)}}"  class="btn btn-sm btn-success mb-1">
                    Profile
                  </a>
                  <a href="{{ route('assessment.solutions',$exam->slug)}}?student={{$r->user->username}}" class="btn btn-sm btn-primary mb-1"> responses</a>

                  
                  
                  @else
                  -
                  @endif
                </td>
                @if(\auth::user()->isAdmin())
                <td>
              <form method="post" action="{{ route('assessment.delete',$exam->slug)}}?url={{ request()->url()}}" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ $r->user->id }}">
                <input type="hidden" name="test_id" value="{{ $exam->id }}">
                <button class="btn btn-sm btn-danger mb-1" type="submit">delete</button>

              </form>
            </td>
            @endif
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
 
</div>

@endsection


