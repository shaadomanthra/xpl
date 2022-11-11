@extends('layouts.plain')
@section('title', $college->name.' Student List | PacketPrep')
@section('content')



@include('flash::message')

  <div class="row p-4">

    <div class="col-md-12">
      

     
      <div class="card mb-4">
        
        <h3 class="px-3 pt-3">{{$college->name}}</h3>
        <h5 class="px-3 pb-3">{{$college->code}} | {{$college->location}} | {{$college->college_website}}</h5>
    
      @if(count($users)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($users)}})</th>
                <th scope="col">Name </th>
                <th scope="col">Branch</th>
                <th scope="col">YOP</th>
                <th scope="col">Phone</th>
                <th>Status</th>
              </tr> 
            </thead>
            <tbody>
              @foreach($users as $key=>$obj)  
              <tr>
                <th scope="row"  style="padding:1px;margin:0px;text-align:center">{{ $key+1}}</th>
                <td  style="padding:1px;margin:0px">
                  {{ $obj->name }}
                 
                </td>
                <td  style="padding:1px;margin:0px;text-align:center">
                  @if(isset($branches[($obj->branch_id)]))
                  {{ $branches[($obj->branch_id)]->name}}
                  @endif
                </td>
                <td  style="padding:1px;margin:0px;text-align:center">{{ $obj->year_of_passing}}</td>
                <td  style="padding:1px;margin:0px;text-align:center">
                  {{$obj->phone}}
                </td>
                <td style="padding:1px;margin:0px"></td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No {{ $app->module }} student listed
        </div>
        @endif
        


      </div>

      <a href="{{ route('college.show',$college->id)}}" class="my-3 ml-4"><i class="fa fa-angle-left"></i> back</a>

    </div>

     

  </div> 





@endsection