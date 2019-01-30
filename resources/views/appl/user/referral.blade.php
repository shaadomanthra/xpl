@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Referral </li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-12">
 
        <div class="bg-white  border mb-3 p-3">
          <div class="navbar-brand"><i class="fa fa-user"></i> My Referrals </div>
          <p>Referral URL : <a href="{{ route('student.'.$type.'register') }}?code={{$username}}">{{ route('student.'.$type.'register') }}?code={{$username}}</a></p>

          
        </div>

        <div id="search-items bg-white">
           @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">College</th>
                <th scope="col">Branch</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  {{ $user->name }}
                  
                </td>
                <td>{{ $user->colleges->first()->name }}</td>
                <td>{{ $user->branches->first()->name }}</td>
                
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

 </div>

</div>

@endsection


