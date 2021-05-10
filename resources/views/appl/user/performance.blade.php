@extends('layouts.nowrap-white')

@section('title', 'Performance ')

@section('description', 'Know you users performance')

@section('content')

@include('appl.exam.exam.xp_css')


<div class='pb-1 dblue' >
  <div class='container'>
     <nav class="mb-0">
        
      
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/users')}}">Users</a></li>
            <li class="breadcrumb-item">Performance </li>

          </ol>

        </nav>

      

        
    
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>


<div class="container mt-4 mb-4">
  <div class="bg-light p-4 rounded border mb-3">
  <h4>Filters</h4>
  <form class="form-inline" action="{{route('performance')}}" method="get">
  <label class="sr-only" for="inlineFormInputName2">Exams</label>

  <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="exam" placeholder="Enter exam slugs " value="{{request()->get('exam')}}">
  

  <label class="sr-only" for="inlineFormInputGroupUsername2">Group</label>
  <div class="input-group mb-2 mr-sm-2">
    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="info" placeholder="Enter group name" value="{{request()->get('group')}}">
  </div>

  <div class="form-check mb-2 mr-sm-2">
    <input class="form-check-input" type="checkbox" name="status" id="inlineFormCheck" @if(request()->get('status')=='on') checked @endif
    <label class="form-check-label" for="inlineFormCheck">
      Attendance
    </label>
  </div>

  <button type="submit" class="btn btn-primary mb-2">Submit</button>
</form>
</div>

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
   @if(count($exams)!=0)
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
                <th scope="col" class="">CGPA(10)</th>
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
        <div class="card card-body bg-light text-secondary">
          Enter exams slugs seperated by commas to extract the candidates performance
        </div>
        @endif
     </div>


     

  </div>


</div>

@endsection           