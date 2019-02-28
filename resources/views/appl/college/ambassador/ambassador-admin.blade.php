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
          <a class="navbar-brand"><i class="fa fa-bars"></i> {{ ucfirst($app->module) }}s </a>

          
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
                        <th scope="col">Network </th>
                        <th scope="col">Score </th>
                        <th scope="col">Level </th>
                      </tr>
                    </thead>
                    <tbody class="{{ $j = 0}}">
                      @foreach($data['users'] as $user => $score)
                      <tr>
                        <td class="">{{ $i++ }}
                        </td>
                        <td class="">

                        <a href="{{ route('admin.user.view',$data['username'][$user]) }}">
                          {{ $user }}
                        </a>
                        </td>
                        <td> {{ $data['colleges'][$user] }} - {{ $data['branch'][$user] }}</td>
                        <td> <a href="{{ route('user.referral',$data['username'][$user]) }}?othercollege=true">{{ $data['network'][$user] }}</a></td>
                        <td class="{{ $j=$j+$score }}"> {{ $score }}</td>
                        <td> @if($score > 49 && $score < 80)
                            <div class="bg-white p-2 border text-secondary"><i class ="fa fa-shield"></i> Silver</div>
                            @elseif($score > 79 && $score < 100)
                            <div class="bg-white p-2 border text-success"><i class ="fa fa-graduation-cap"></i> Gold</div>

                            @elseif($score > 99 )
                            <div class="bg-white p-2 border text-primary"><i class ="fa fa-trophy"></i> Platinum</div>

                            @else
                            <div class="text-secondary"> - </div>
                            @endif


                        </td>
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