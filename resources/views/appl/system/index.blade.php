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
      <div class="col-md-6">
          <div class="card mb-4">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-bullhorn"></i> Updates 
                  <span class="s15 float-right">
                    <a href="{{ route('update.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
                @foreach($updates as $update)
                  <div><b><a href="{{ route('profile','@'.$update->user->username)}}">{{ $update->user->name }}</a></b></div>
                  {!! str_limit(strip_tags($update->content),100) !!} <a href="{{ route('update.show',$update->id) }}">readmore</a><br><Br>
                @endforeach
              </div>
          </div>

          @can('view',$finance)
          <div class="card">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-rupee"></i> Cash
                  <span class="s15 float-right">
                    <a href="{{ route('finance.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
                <div class="p-3 border mb-3 bg-light">
                <div>Balance</div>
                  @if($finance->cashin - $finance->cashout > -1)
                    <h1 class="text-success"><i class="fa fa-rupee"></i>{{ $finance->cashin - $finance->cashout   }}</h1>
                  @else
                    <h1 class="text-danger"> - <i class="fa fa-rupee"></i>{{ $finance->cashout - $finance->cashin   }}</h1>
                  @endif
                </div>
                <div class="row no-gutters">
                    <div class="col-6 col-md-12 col-lg-6 mb-3 mb-lg-0">
                        <div>Cash In</div>
                        <h3 class="text-secondary"><i class="fa fa-rupee"></i>  {{ $finance->cashin }}</h3>
                    </div>
                    <div class="col-6 col-md-12 col-lg-6">
                        <div>Cash Out</div>
                        <h3 class="text-secondary"><i class="fa fa-rupee"></i> {{ $finance->cashout }}</h3>
                    </div>
                </div>
              </div>
          </div>
        @endcan


      </div>
      <div class="col-md-6 ">
          <div class="card mb-4">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-flag"></i> Goals
                  <span class="s15 float-right">
                    <a href="{{ route('goal.index') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
                @foreach($goals as $goal)
                  <div><b class="text-primary">{{ \carbon\carbon::parse($goal->end_at)->format('d M Y') }}</b></div>
                  <div class="mb-3">
                  {!! str_limit(strip_tags($goal->title),100) !!} 
                </div>
                @endforeach
              </div>
          </div>


      @can('view',$finance)
          <div class="card">
              <div class="card-body">
                <h2 class="mb-4"><i class="fa fa-align-right"></i> Reports
                  <span class="s15 float-right">
                    <a href="{{ route('report.week') }}"><button class="btn btn-outline-info btn-sm">View All</button></a>
                    </span>
                </h2>
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
      @endcan

      </div>

      


    </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
    </div>
</div>

@endsection


