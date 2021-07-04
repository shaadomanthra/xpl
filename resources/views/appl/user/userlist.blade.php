@extends('layouts.nowrap-white')

@section('title', 'Users ')

@section('description', 'Know you users')

@section('content')

@include('appl.exam.exam.xp_css')


<div class='pb-4 dblue' >
  <div class='container'>
     <nav class="mb-0">
        @if(\auth::user()->checkRole(['administrator']))
        <a href="{{ request()->url() }}?downloadexport=1" class="btn btn-sm btn-outline-success float-md-right mt-3 mr-3">Download </a>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 || \auth::user()->role ==13)
        <a href="{{ route('performance') }}" class="btn btn-sm btn-outline-info float-md-right mt-3 mr-3">Performance</a>
          <a href="{{ route('upload.users') }}" class="btn btn-sm btn-outline-success float-md-right mt-3 mr-3">Upload</a>
        <a href="{{ request()->url() }}?downloadexport=1" class="btn btn-sm btn-outline-primary float-md-right mt-3 mr-3">Download </a>
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

 @include('flash::message')

  <div class="row">
    <div class="col-12 col-md-10">
   @if($users->total()!=0)
        <div class="table-responsive">
          <div class="bg-light p-3 border-top border-left border-right " >Filter : <span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @elseif(request()->get('role')) {{request()->get('role')}} @elseif(request()->get('info')) {{request()->get('info')}} @else All users @endif</span>
            <span class="badge badge-info float-right"> 
            {{$user->name}}</span>
          </div>
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Email / Phone</th>
                <th scope="col">Created / Lastlogin</th>
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
                  @if($u->status!=1)
                  <span class="badge-info">{{$u->status}}</span>
                  @endif
                   
                    <div class="text-secondary">   
                    @if($u->info)
                    <span class="mr-2"><i class="fa fa-graduation-cap"></i> {{$u->info}}</span>
                    @endif
                   
                    @if(count($u->roles))
                    @foreach($u->roles as $r)
                      {{$r->name}}
                    @endforeach
                    @else
                     <span class="fa fa-user-circle"> student</span>
                    @endif
                  </div>
                 
                  </td>
                  
                  <td>
                   <h5>{{$u->email}}</h5>
                    {{$u->phone}}
                  </td>
                  <td>
                   
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
                  <h4 class="mb-1">{{ $u->name }}</h4>
                </a>
                @if($u->status==0)
                  <span class="badge-info badge">Inactive</span>
                  @elseif($u->status==2)
                    <span class="badge-warning badge">Blocked</span>
                  @endif
                   
                  <div class="text-secondary">   
                    @if($u->info)
                    <span class="mr-2"><i class="fa fa-graduation-cap"></i> {{$u->info}}</span>
                    @endif
                   
                    @if(count($u->roles))
                    @foreach($u->roles as $r)
                      {{$r->name}}
                    @endforeach
                    @else
                     <span class="fa fa-user-circle"> student</span>
                    @endif
                  </div>
                </td>
              
                <td>
                 <h4>{{$u->email}}</h4>
                  <div class="text-secondary">{{$u->phone}}</div>
                </td>
                <td>
                  {{$u->created_at->format('d-m-Y')}}
                    <div class="text-secondary"><small><i class="fa fa-clock-o"></i> {{$u->updated_at->diffForHumans()}}</small></div>
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


     <div class="col-12 col-md-2">
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action bg-light disabled">
              Groups
            </a>
            @foreach($user_info as $k=>$ui)
            @if($k)
            <a href="{{route('user.list')}}?info={{$k}}" class="list-group-item list-group-item-action @if(request()->get('info')==$k) active @endif">
              {{$k}} ({{count($ui)}})
            </a>
            @else
            <a href="#" class="list-group-item list-group-item-action ">
              Null ({{count($ui)}})
            </a>
            @endif
            @endforeach
          </div>

           <div class="my-3">
        <form class="w-100" method="GET" action="{{ route('user.list') }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
      </div>
      </div>



  </div>


</div>

@endsection           