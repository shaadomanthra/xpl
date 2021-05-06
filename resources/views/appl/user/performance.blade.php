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

 @if(request()->get('exam'))
 <div class="rounded border p-4 my-3">
    @foreach($exams as $e)
                
                <h1 class="mt-0 mb-0">{{$e->name}}</h1>
                  <a href="">{{route('assessment.show',$e->slug)}}</a>
                @endforeach
 </div>
 @endif

  <div class="row">
    <div class="col-12 col-md-12">
   @if(count($data)!=0)
        <div class="table-responsive">
          <div class="bg-light p-3 border-top border-left border-right " >Filter : <span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @elseif(request()->get('role')) {{request()->get('role')}} @elseif(request()->get('info')) {{request()->get('info')}} @else All users @endif</span>
            
          </div>
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($data)}})</th>
                <th scope="col">Name </th>
                <th scope="col" class="{{$i=1}}">Group</th>
                @foreach($exams as $e)
                <th scope="col">{{$e->name}}({{$e->max}})<br><span class="badge badge-primary">{{$e->slug}}</span></th>
                @endforeach

                @if(!request()->get('status'))
                <th scope="col" class="">CGPA</th>
                @endif
              </tr>
            </thead >
            <tbody>
              @foreach($data as $key=>$u) 


                 <tr>
                  <th scope="row">{{ $i++ }}</th>
                  <td>
                    <a href="{{ route('profile','@'.$u['user']->username)}}">
                    {{ $u['user']->name }}
                  </a>
                   
                 
                  </td>
                  <td>
                   {{$u['user']->info}}
                  </td>
                   @foreach($exams as $id=>$e)
                  <td>
                    @if(isset($data[$u['user']->id]['test'][$id]))
                       @if(!request()->get('status'))
                          @if($data[$u['user']->id]['test'][$id]=="0")
                            0
                          @else
                            {{$data[$u['user']->id]['test'][$id]}}
                          @endif
                        @else
                        <span class="badge badge-success">Attempted</span>
                        @endif
                    @else
                      @if(!request()->get('status'))
                      -
                      @else
                      <span class="badge badge-secondary">Unattempted</span>
                      @endif

                    @endif
                  </td>
                  @endforeach
                  
                   @if(!request()->get('status'))
                  <td>
                   {{$data[$u['user']->id]['cgpa']}}
                  </td>
                  @endif
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


</div>

@endsection           