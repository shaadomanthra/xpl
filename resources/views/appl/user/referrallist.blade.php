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
     
        <div class="col-12 col-md-12">
            

            <div class="card mb-3">
              <div class="card-body " >
                <div> </div>
                <div class="">
                  <div class="table-responsive">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Sno </th>
                        <th scope="col">Name </th>
                        <th scope="col">College </th>
                        <th scope="col">Branch </th>
                        <th scope="col">Score </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $j = 0}}">
                      @foreach($users as $user )
                      <tr>
                        <td class="">{{ $i++ }}
                        </td>
                        <td class="">

                        <a href="{{ route('admin.user.view',$user->username) }}">
                          {{ $user->name }}<br>
                          @foreach($user->roles()->get() as $k=> $r)
                          <span class="badge badge-warning">{{ $r->name }}</span><br>
                          @endforeach
                        </a>
                        </td>
                        <td> {{ ($user->colleges()->first())?$user->colleges()->first()->name:'' }}</td>
                        <td> {{ ($user->branches()->first())?$user->branches()->first()->name:'' }}</td>
                        <td class="{{ $j=$j+$user->referrals->count() }}"> {{ $user->referrals->count() }}</td>
                        
                      </tr>
                      
                      @endforeach    
                    </tbody>
                  </table>

                  
                </div>
                </div>
                
              </div>
            </div>
            @if(\auth::user()->checkRole(['administrator']))
                    <div class="p-3 border">Total Referrals   
                      <div class="display-2">{{ $j }}</div></div>
                  @endif
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