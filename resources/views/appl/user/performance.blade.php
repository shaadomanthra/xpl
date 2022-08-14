@extends('layouts.nowrap-white')

@section('title', 'Performance ')

@section('description', 'Know you users performance')

@section('content')

@include('appl.exam.exam.xp_css')


@php
function initials($str) {
   $acronym='';
        $word='';
        $words = preg_split("/(\s|\-|\.)/", $str);

        foreach($words as $w) {
            if(substr($w,0,1)!='#')
            $acronym .= substr($w,0,1);
            else
            $acronym .= $w;
        }
        $word = $word . $acronym ;
        return $word;

        
}
@endphp
<div class=' pb-1 dblue d-print-none' >
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
<div class='p-1  ddblue d-print-none' >
</div>



<div class="pl-5 mt-4 mb-4 px-3">
  <div class="d-print-inline h3 mt-3">Assessments - Performance @if(request()->get('info')) - {{ request()->get('info')}} @endif</div>
  <div class="bg-light p-4 rounded border mb-3 d-print-none">
  <h4>Filters</h4>
  <form class="form-inline" action="{{route('performance')}}" method="get">
  <label class="sr-only" for="inlineFormInputName2">Exams</label>

  <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="exam" placeholder="Enter exam slugs " value="{{request()->get('exam')}}">
  

  <label class="sr-only" for="inlineFormInputGroupUsername2">Group</label>
  <div class="input-group mb-2 mr-sm-2">
    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="info" placeholder="Enter group name" value="{{request()->get('info')}}">
  </div>

  <div class="form-check mb-2 mr-sm-2">
    <input class="form-check-input" type="checkbox" name="status" id="inlineFormCheck" @if(request()->get('status')=='on') checked @endif
    <label class="form-check-label" for="inlineFormCheck">
      Attendance
    </label>
  </div>

  <button type="submit" class="btn btn-primary mb-2">Submit</button>
  <a href="{{route('performance')}}?export=1 @if(request()->get('info'))&info={{request()->get('info')}} @endif @if(request()->get('exam'))&exam={{request()->get('exam')}} @endif  @if(request()->get('status'))&status={{request()->get('status')}} @endif"  class="btn btn-success float-right mb-2 ml-4">Download</a>
</form>

<div class=" " ><hr><span class="badge badge-warning"> 
            @if(request()->get('month')) {{request()->get('month')}} @elseif(request()->get('role')) {{request()->get('role')}} @elseif(request()->get('info')) {{request()->get('info')}} @else No Filter @endif</span>
            
          </div>
</div>

 @include('flash::message')

 @if(request()->get('exam'))
 <div class="rounded border p-4 my-3">
    @foreach($exams as $e)
                
                <h1 class="mt-0 mb-0">{{$e->name}}</h1>
                  <a href="" class="d-inline d-print-none">{{route('assessment.show',$e->slug)}}</a>
                @endforeach
 </div>
 @endif


  <div class="row">
    <div class="col-12 col-md-12">
   @if(count($exams)!=0)
        <div class="table-responsive">
          
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($data)}})</th>
                <th scope="col" class="{{$i=1}}" style="width: 200px">Name </th>

                @if(request()->get('exam')&& request()->get('status')!='on')
                  <th scope="col" >Batch</th>
                @endif
                  @if(!request()->get('status'))
                <th scope="col" class="bg-light">CGPA (10)</th>
                @endif
                @foreach($exams as $e)
                <th scope="col">
                  @if(request()->get('all'))
                  <a href="{{route('performance')}}?exam={{$e->slug}}&info={{request()->get('info')}}">{{$e->name}}</a>
                  @else
                  <a href="{{route('performance')}}?exam={{$e->slug}}&info={{request()->get('info')}}" class="d-print-none d-block">{{initials($e->name)}} - Total({{$scores['scores']['exam']}})</a>
                  <span class="d-print-inline d-none">Total({{$scores['scores']['exam']}})</span>
                  @endif

                  <span class="badge badge-info d-print-none d-inline">{{$e->slug}}</span></th>
                @endforeach

                @if(request()->get('exam')&& request()->get('status')!='on')
                  @foreach($exams->first()->sections as $a=>$b)
                    <th scope="col">{{$b->name}} ({{$scores['scores']['section'][$b->id]}})</th>
                  @endforeach
                @endif
              </tr>
            </thead >
            <tbody class="text-center">
              @foreach($data as $key=>$u) 


                 <tr>
                  <td scope="row" class="p-1 text-center">{{ $i++ }}</td>
                  <td class="p-1 text-left">
                    <a href="{{ route('profile','@'.$u['user']->username)}}" class="d-print-none d-inline">
                    {{ $u['user']->name }}
                  </a>

                  <span class="d-none d-print-inline"> {{ $u['user']->name }}</span>
                   
                   @if(!request()->get('exam'))
                 <span class="badge badge-light border border-dark d-print-none d-inline"> {{$u['user']->info}}</span>
                  @endif
                  </td>

                  @if(request()->get('exam')&& request()->get('status')!='on')
                  <td  >{{$u['user']->info}}</th>
                  @endif

                   @if(!request()->get('status'))
                  <td class="bg-light p-1" >
                   {{$data[$u['user']->id]['cgpa']}}
                  </td>
                  @endif
                   @foreach($exams as $id=>$e)
                  <td class="p-1">
                    @if(isset($data[$u['user']->id]['test'][$id]))
                       @if(!request()->get('status'))
                          @if($data[$u['user']->id]['status'][$id]==0)
                            @if($data[$u['user']->id]['test'][$id]=="0")
                              0
                            @else
                              <a href="{{ route('assessment.analysis',$e->slug)}}?student={{$u['user']->username}}" class="d-print-none d-block"><h4>{{$data[$u['user']->id]['test'][$id]}}</h4></a>
                              <h4 class="d-print-block d-none">{{$data[$u['user']->id]['test'][$id]}}</h4>
                            @endif
                          @else
                           <i class="fa fa-question-circle-o text-secondary" aria-hidden="true"></i>
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
                  @if(request()->get('exam') && request()->get('status')!='on')
                    @if(count($data[$u['user']->id]['section'][$e->id]))
                    @foreach($data[$u['user']->id]['section'][$e->id] as $a=>$b)
                    <td class="p-1">{{$b}}</td>
                    @endforeach
                    @else
                       @foreach($exams->first()->sections as $a=>$b)
                        <td class="p-1">-</td>
                      @endforeach
                    @endif
                  @endif
                  @endforeach
                  
                  
                  
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