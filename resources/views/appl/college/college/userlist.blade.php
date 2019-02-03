@extends('layouts.plain')
@section('content')



@include('flash::message')

  <div class="row">

    <div class="col-md-12">
      

     
      <div class="card mb-4">
        

      @if(count($obj->users)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($obj->users)}})</th>
                <th scope="col">Name </th>
                <th scope="col">Branch</th>
                <th scope="col">Service</th>
                <th scope="col">Amount</th>
                <th scope="col">Signature</th>
              </tr>
            </thead>
            <tbody>
              @foreach($obj->users as $key=>$obj)  
              <tr>
                <th scope="row">{{ $key+1}}</th>
                <td>
                  {{ $obj->name }}
                 
                </td>
                
                <td>{{ ($obj->branches->first())?$obj->branches->first()->name :''}}</td>
                <td>{{ ($obj->services->first())?$obj->services->first()->name :''}}</td>
                <td>
                  @if($obj->services->first())
                    @if($obj->services->first()->name == 'Premium Access')
                      Rs. 500
                    @else
                      Rs. 250
                    @endif
                  @endif
                </td>
                <td></td>
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

    </div>

     

  </div> 





@endsection