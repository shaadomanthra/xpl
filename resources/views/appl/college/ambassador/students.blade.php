@extends('layouts.app')
@section('content')


<div class="container bg-white">

  <div class="p-4">
      <h1><a href="{{ route('ambassador.college')}}">{{ $obj->name }}</a> - Student List (#{{count($user_list)}})</h1>
      <p>@if(request()->get('branch')) Branch:  <b>{{request()->get('branch')}}</b> @endif

        @if(request()->get('year_of_passing')) <br>Year:  <b>{{request()->get('year_of_passing')}}</b> @endif

      </p>
  </div>

<div  class="row p-4">
 @if(count($user_list)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($user_list)}})</th>
                <th scope="col">Roll Number </th>
                <th scope="col" {{ $i=1}}>Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user_list as $user=>$roll_number)  
              <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>
                  {{ $roll_number}}
                 
                </td>
                <td>
                  {{ $user }}
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
</div>


@endsection

