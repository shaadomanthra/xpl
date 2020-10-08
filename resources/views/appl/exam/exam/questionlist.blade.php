@extends('layouts.nowrap-white')
@section('title', 'Candidates')
@section('content')

@include('appl.exam.exam.xp_css')
<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Questions </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-bars "></i> Questions
          </p>
        </div>
      </div>
     
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>

<div class="container">
@include('flash::message')
<div  class="row py-4">

  <div class="col-md-12">
 
    <div class=" mb-3 mb-md-0">
      <div class="mb-0">
       

        <div id="search-items bg-white">
         
      @if(count($data)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($data)}})</th>
                <th scope="col">Question </th>
                <th scope="col" width="10%">Topic </th>
                <th scope="col" width="10%">Level</th>
                <th scope="col">Mark</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$obj)  
              <tr>
                <th scope="row">{{ ($key+1) }}</th>
                <td>
                  <h5 >{!! $obj->question !!} </h5>
                  <p>
                    @if($obj->a)<div class=""><div class="d-inline">(A)</div> <div class="d-inline">{!! $obj->a !!}</div> </div>@endif
                    @if($obj->b)<div class=""><div class="d-inline">(B)</div> <div class="d-inline">{!! $obj->b !!}</div> </div>@endif
                    @if($obj->c)<div class=""><div class="d-inline">(C)</div> <div class="d-inline">{!! $obj->c !!}</div> </div>@endif
                    @if($obj->d)<div class=""><div class="d-inline">(D)</div> <div class="d-inline">{!! $obj->d !!}</div> </div>@endif
                    @if($obj->e)<div class=""><div class="d-inline">(E)</div> <div class="d-inline">{!! $obj->e !!}</div> </div>@endif

                  </p>
                  
                </td>
                 <td> 
                 {{ $obj->topic }}
                </td>
                
                <td>@if($obj->level)  Level {{ $obj->level }} @else '-' @endif</td>
                <td>{{ $obj->mark }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No questions listed
        </div>
        @endif
       

       </div>

     </div>
   </div>
 </div>

</div>
</div>

@endsection


