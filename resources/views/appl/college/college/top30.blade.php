@extends('layouts.plain')
@section('content')



@include('flash::message')
<h1 class="border p-3 text-center display-3"> Xplore Network - Top Colleges </h1>
<div  class="row ">

  <div class="col-md-12">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        

        <div id="search-items">
         

 @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">College</th>
                <th scope="col">Students </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  {{ $obj->name }}
                </td>
                 <td>
                  {{ count($obj->users)}}
                </td>
                
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No {{ $app->module }} listed
        </div>
        @endif
       


       </div>

     </div>
   </div>
 </div>
 
</div>

@endsection


