@extends('layouts.nowrap-white')

@section('title', 'Users ')

@section('description', 'Know you users')

@section('content')

@include('appl.exam.exam.xp_css')

<div class='pb-4 dblue' >
  <div class='container'>
     <nav class="mb-0">
      @if(\auth::user()->checkRole(['administrator']))
        <a href="{{ request()->url() }}?export=1&month={{request()->get('month')}}" class="btn btn-sm btn-outline-primary float-md-right mt-3">Excel Download</a>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 )
        <a href="{{ request()->url() }}?export=1&month={{request()->get('month')}}" class="btn btn-sm btn-outline-primary float-md-right mt-3">Excel Download</a>
        @else
        @endif
      
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Users </li>

          </ol>

        </nav>
       <div class="row ">
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(!request()->get('month')) dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">All users</div>
          <div class="h2" ><a href="{{ route('user.list')}}">{{ ($data['users_all'] -$count)}}</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='thismonth') dblue border-secondary @else bg-white @endif" >
          <div class="h6">{{\carbon\carbon::now()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('user.list')}}?month=thismonth">@if($data['users_thismonth']) {{ ($data['users_thismonth']-$count)}} @else 0 @endif</a></div>
        </div>
      </div> 
      <div class="col-12 col-md-3">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='lastmonth') dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth()->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('user.list')}}?month=lastmonth">
          @if($data['users_lastmonth']){{ ($data['users_lastmonth']-$count)}}@else 0 @endif</a></div>
        </div>
      </div>
      <div class="col-12 col-md-3">
         <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox @if(request()->get('month')=='lastbeforemonth') dblue border-secondary @else bg-white @endif" style=''>
          <div class="h6">{{\carbon\carbon::now()->submonth(2)->format('M Y')}}</div>
          <div class="h2" ><a href="{{ route('user.list')}}?month=lastbeforemonth">
          @if($data['users_lastbeforemonth'])
          {{ ($data['users_lastbeforemonth']-$count)}}
          @else
           0 @endif</a></div>
        </div>
      </div>
  </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>

<div class="container mt-4 mb-4">

 

  <div class="mt-4 mb-4">
    @if($users->total()!=0)
        <div class="table-responsive">
          <div class="bg-light p-3 border-top border-left border-right " >Filter : <span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @elseif(request()->get('role')) {{request()->get('role')}}@else All users @endif</span>
            <span class="badge badge-info float-right"> 
            {{$user->name}}</span>
          </div>
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Role </th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$u) 
              @if(request()->get('role')=='student')

                @if(!$u->roles()->first()) 

                 <tr>
                  <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                  <td>
                    <a href="{{ route('profile','@'.$u->username)}}">
                    {{ $u->name }}
                  </a>
                   
                 
                  </td>
                  <td>
                  @if(count($u->roles))
                    @foreach($u->roles as $r)
                      {{$r->name}}
                    @endforeach
                  @else
                    student
                  @endif
                  </td>
                  <td>
                   {{$u->email}}
                  </td>
                  <td>
                   {{$u->phone}}
                  </td>
                  <td>
                    {{$u->created_at->format('d-m-Y')}}
                  </td>
                 
                </tr>
                @else

                @endif
              @else
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href="{{ route('profile','@'.$u->username)}}">
                  {{ $u->name }}
                </a>
                 
               
                </td>
                <td>
                @if(count($u->roles))
                  @foreach($u->roles as $r)
                    {{$r->name}}
                  @endforeach
                @else
                  student
                @endif
                </td>
                <td>
                 {{$u->email}}
                </td>
                <td>
                 {{$u->phone}}
                </td>
                <td>
                  {{$u->created_at->format('d-m-Y')}}
                </td>
               
              </tr>
              @endif
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Users listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

  </div>

</div>

@endsection           