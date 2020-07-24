@extends('layouts.app')
@section('content')



<nav aria-label="breadcrumb">
  <ol class="breadcrumb border bg-light">
    <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item">Branch - {{ ucfirst($obj->name) }}</li>
  </ol>
</nav>

<div class="container bg-white border">

  <div class="p-4">
      <h1><a href="{{ route('metric.view',$obj->id)}}">{{ $obj->name }}</a> - Student List (#{{$total}})</h1>
      <p>@if($metric) Metric:  <b>{{$metric->name}}</b> @endif


        @if($zone) <br>Zone:  <b>{{$zone->name}}</b> @endif
      </p>
  </div>

<div  class="row p-4">
 @if(count($users)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">UserID</th>
                <th scope="col">Roll Number </th>
                <th scope="col">Name</th>
                <th scope="col">Branch</th>
                <th scope="col">Phone</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>
                  {{ ($user->roll_number)?$user->roll_number:'-' }}
                 
                </td>
                <td>
                  <a href=" {{ route('admin.user.view',$user->username)}}">{{ $user->name }}</a>
                </td>
                
                <td>
                  @if($user->branch)
                      <a href="{{ route('branch.view',$user->branch->name)}}">{{ $user->branch->name}}</a> &nbsp;
                  @endif
                </td>
                <td>
                 {{ ($user->phone)?$user->phone:'-' }}
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


@endsection

