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
            <li class="breadcrumb-item">Candidates </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-user "></i> Candidates
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
        
          <form class="form-inline mr-3 float-right" method="GET" action="{{ route('test.candidatelist',$exam->slug) }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="" name="item" autocomplete="off" type="search" placeholder="Search by id" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
          

         
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
                <th scope="col">Candidate Name </th>
                <th scope="col" width="20%">Proctor Name </th>
                <th scope="col">Exam started at</th>
                <th scope="col">OS details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$obj)  
              <tr>
                <th scope="row">{{ $obj->username }}</th>
                <td>
                  <h5>{{ $obj->name }} </h5>
                  <span class="text-secondary">{{$obj->email}}</span><br>
                  <span class="text-secondary">{{$obj->phone}}</span>
                </td>
                 <td> 
                  @if(isset($emails[trim($obj->email)])) {{$proctors[$emails[trim($obj->email)]]->name}} 
                  <br><span class="text-secondary">{{$proctors[$emails[trim($obj->email)]]->email}}<br> {{$proctors[$emails[trim($obj->email)]]->phone}}</span> @endif
                </td>
                
                <td>@if(isset($candidates[$obj->username])) {{ $candidates[$obj->username]['time'] }} @endif</td>
                <td>@if(isset($candidates[$obj->username])) {{ $candidates[$obj->username]['os_details'] }} @endif</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No candidates listed
        </div>
        @endif
       

       </div>

     </div>
   </div>
 </div>

</div>
</div>

@endsection


