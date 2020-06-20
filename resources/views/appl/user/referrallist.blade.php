@extends('layouts.app')
@section('title', 'Campus Connect | PacketPrep')
@section('description', 'This page is about campus connect')
@section('keywords', 'college,packetprep,campus connect')

@section('content')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Referrals ({{count($users)}})</a>

          
        </nav>

        <div id="search-items">

       </div>

     </div>
   </div>

            <div class="{{ $i=1}}" >
    <div class="" >  
      <div class="row">
     
        <div class="col-12 col-md-12 ">
            

            <div class="card mb-3">
              <div class="card-body " >
                <div> </div>
                <div class="">
                  <div class="table-responsive">
                  <table class="table  table-bordered mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Sno </th>
                        <th scope="col">Name </th>
                        <th scope="col">Number of Referrals </th>
                      </tr>
                    </thead>
                    <tbody class="{{$i=1}}">
                      @foreach($ulist as $id => $count )
                      <tr>
                        <td class="">{{ $i++ }}
                        </td>
                        <td class="">
                        @if(isset($users[$id]))
                        <a href="{{ route('admin.user.view',$users[$id][0]->username) }}">
                          {{ $users[$id][0]->name }}<br>
                         
                        </a>
                        @endif
                        </td>
                       
                        <td class=""> {{ $count }}

                          

                        </td>
                        
                      </tr>
                      
                      @endforeach    
                    </tbody>
                  </table>

                  
                </div>
                </div>
                
              </div>
            </div>
          
        </div>
      </div>
     </div>   
</div>
 </div>
 <div class="col-md-3 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>



@endsection           