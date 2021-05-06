@extends('layouts.nowrap-white')

@section('title', 'Users ')

@section('description', 'Know you users')

@section('content')

@include('appl.exam.exam.xp_css')


<div class='pb-4 dblue' >
  <div class='container'>
     <nav class="mb-0">
        
      
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/users')}}">Users</a></li>
            <li class="breadcrumb-item">Performance </li>

          </ol>

        </nav>

        <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th>
                  <a href="{{route('performance')}}" class="">
              All ({{$totalusers}})
            </a>
                </th>
        @foreach($user_info as $k=>$ui)


            @if($k)
            <th>
            <a href="{{route('performance')}}?info={{$k}}" class=" ">
              {{$k}} ({{count($ui)}})
            </a>
          </th>
            @else
            @endif
            @endforeach
          </tr>
        </thead>
      </table>

        
    
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>

<div class="container mt-4 mb-4">

 @include('flash::message')

  <div class="row">
    <div class="col-12 col-md-12">
   @if($users->total()!=0)
        <div class="table-responsive">
          <div class="bg-light p-3 border-top border-left border-right " >Filter : <span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @elseif(request()->get('role')) {{request()->get('role')}} @elseif(request()->get('info')) {{request()->get('info')}} @else All users @endif</span>
            
          </div>
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Info </th>
                @foreach($exams as $e)
                <th scope="col">{{$e->name}}</th>
                @endforeach
                <th scope="col">CGPA</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$u) 

                @if(!$u->roles()->first()) 

                 <tr>
                  <th scope="row">{{ $users->currentpage() ? ($users->currentpage()-1) * $users->perpage() + ( $key + 1) : $key+1 }}</th>
                  <td>
                    <a href="{{ route('profile','@'.$u->username)}}">
                    {{ $u->name }}
                  </a>
                   
                 
                  </td>
                  <td>
                   {{$u->info}}
                  </td>
                   @foreach($exams as $id=>$e)
                  <td>
                    @if($data[$u->id]['test'][$id])
                    {{$data[$u->id]['test'][$id]}}
                    @elseif($data[$u->id]['test'][$id]=="0")
                    0
                    @else
                    -
                    @endif
                  </td>
                  @endforeach
                  
                  <td>
                   {{$data[$u->id]['cgpa']}}
                  </td>
                </tr>
                @else

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


</div>

@endsection           