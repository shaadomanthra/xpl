@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">System</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-9">

    <div class="card mb-4">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-md-3 col-lg-2 d-none d-md-block">
            <div class="text-center"><i class="fa fa-chrome fa-5x"></i> </div>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
              <h1 class=" mb-2">System App</h1>
              <blockquote class="blockquote mb-0">
                <p class="mb-0">Ideas are cheap. Ideas are easy. Ideas are common. Everybody has ideas. Ideas are highly, highly overvalued. Execution is all that matters.</p>
                <footer class="blockquote-footer"><cite title="Source Title">Casey Neistat</cite></footer>
              </blockquote>
            </div>
         </div>
        </div>
    </div>

    <div class="row mb-3 ">
      <div class="col-md-6 mb-4 mb-md-0">
          <div class="card">
              <div class="card-body">
                <h1 class="mb-4"><i class="fa fa-bullhorn"></i> Updates 
                  <span class="s15 float-right">
                    <a href="{{ route('update.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h1>
                @foreach($updates as $update)
                  <div><b><a href="{{ route('profile','@'.$update->user->username)}}">{{ $update->user->name }}</a></b></div>
                  {!! str_limit(strip_tags($update->content),100) !!} <a href="{{ route('update.show',$update->id) }}">readmore</a><br><Br>
                @endforeach
              </div>
          </div>
      </div>
      <div class="col-md-6 mb-4 ">
          <div class="card">
              <div class="card-body">
                <h1 class="mb-4"><i class="fa fa-flag"></i> Goals
                  <span class="s15 float-right">
                    <a href="{{ route('goal.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h1>
                @foreach($goals as $goal)
                  <div><b class="text-primary">{{ \carbon\carbon::parse($goal->end_at)->format('d M Y') }}</b></div>
                  <div class="mb-3">
                  {!! str_limit(strip_tags($goal->title),100) !!} 
                </div>
                @endforeach
              </div>
          </div>
      </div>

      @can('view',$finance)
      <div class="col-md-6 mb-4 mb-md-0">
          <div class="card">
              <div class="card-body">
                <h1 class="mb-4"><i class="fa fa-rupee"></i> Cash Flow
                  <span class="s15 float-right">
                    <a href="{{ route('finance.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h1>
                <div class="p-3 border mb-3 bg-light">
                <div>Balance</div>
                  @if($finance->cashin - $finance->cashout > -1)
                    <h1 class="text-success"><i class="fa fa-rupee"></i>{{ $finance->cashin - $finance->cashout   }}</h1>
                  @else
                    <h1 class="text-danger"> - <i class="fa fa-rupee"></i>{{ $finance->cashout - $finance->cashin   }}</h1>
                  @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <div>Cash In</div>
                        <h1 class="text-secondary"><i class="fa fa-rupee"></i>  {{ $finance->cashin }}</h1>
                    </div>
                    <div class="col-6">
                        <div>Cash Out</div>
                        <h1 class="text-secondary"><i class="fa fa-rupee"></i> {{ $finance->cashout }}</h1>
                    </div>
                </div>
              </div>
          </div>
      </div>
      @endcan

      @can('view',$finance)
      <div class="col-md-6 mb-3 mb-md-0">
          <div class="card">
              <div class="card-body">
                <h1 class="mb-4"><i class="fa fa-align-right"></i> Reports
                  <span class="s15 float-right">
                    <a href="{{ route('report.week') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h1>
                @foreach($reports as $report)
                  <div><b class="text-primary">{{ $report->user->name }}</b>
                    <span class="s10 float-right">{{ $report->created_at->diffForHumans()}}</span>
                  </div>
                  <div class="mb-3">
                  {!! str_limit(strip_tags($report->content),100) !!} 
                </div>
                @endforeach
              </div>
          </div>
      </div>
      @endcan

    </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>

@endsection


