@extends('layouts.app')
@section('content')


<div class="container bg-white">

  <div class="p-4">
      <h1><a href="{{ route('college.view',$obj->id)}}">{{ $obj->name }}</a> - Student List (#{{$total}})</h1>
      <p>@if(request()->get('branch')) Branch:  <b>{{request()->get('branch')}}</b> @endif

        @if(request()->get('year_of_passing')) <br>Year:  <b>{{request()->get('year_of_passing')}}</b> @endif

        @if(request()->get('metric')) <br>Metric:  <b>{{request()->get('metric')}}</b> @endif
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
                  {{ ($user->details)?$user->details->roll_number:'-' }}
                 
                </td>
                <td>
                  <a href=" {{ route('admin.user.view',$user->username)}}">{{ $user->name }}</a>
                </td>
                
                <td>
                  @if($user->branches())
                  @foreach($user->branches()->get() as $branch)
                      <a href="{{ route('branch.view',$branch->name)}}">{{ $branch->name}}</a> &nbsp;
                  @endforeach
                  @endif
                </td>
                <td>
                 {{ ($user->details)?$user->details->phone:'-' }}
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
        


</div>
 <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
</div>


@endsection

