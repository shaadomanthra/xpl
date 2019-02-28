@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ambassador.connect') }}">Campus Connect</a></li>
    <li class="breadcrumb-item">Referral </li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-12">
 
        <div class="bg-white  border mb-3 p-3">
          <div class="navbar-brand"><i class="fa fa-user"></i> My Referrals - @if(!request()->get('othercollege')) My College @else Other Colleges @endif -{{ $username }} <a href="{{ route('user.referral',$username) }}? @if(!request()->get('othercollege')) othercollege=true @endif"><button class="btn btn-outline-primary btn-sm"> @if(request()->get('othercollege')) View All @else Other Colleges @endif </button></a></div>
          <p>Referral URL : <a href="{{ route('student.'.$type.'register') }}?code={{$username}}">{{ route('student.'.$type.'register') }}?code={{$username}}</a></p>

          
        </div>

        <div class="row">
          <div class="col-12 col-md-8">
           @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th >#({{$users->total()}})</th>
                <th >Name </th>
                <th>College</th>
                <th >Branch</th>
                <th >Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th >{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  {{ $user->name }}
                  
                </td>
                <td>@if($user->colleges->first())
                    {{ $user->colleges->first()->name }}
                    @endif
                </td>
                <td>@if($user->branches->first()) 
                  {{ $user->branches->first()->name }}
                  @endif</td>
                
                <td>
                  @if($user->status==0)
                    <span class="badge badge-secondary">Inactive</span>
                  @elseif($user->status==1)
                    <span class="badge badge-success">Active</span>
                    @elseif($user->status==2)
                    <span class="badge badge-warning">Blocked</span>
                  @endif
                </td>
              </tr>
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
    <div class="col-12 col-md-4">

      <div class="table-responsive bg-white">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">College ({{count($colleges)}})</th>
                <th scope="col">Count ({{array_sum($colleges)}})</th>
              </tr>
            </thead>
            <tbody>
              @foreach($colleges as $college=>$count)  
              <tr>
                <td>{{ $college }}</td>
                <td>
                  {{ $count}}
                  
                </td>
               
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>

    </div>
       </div>


 </div>

</div>

@endsection


