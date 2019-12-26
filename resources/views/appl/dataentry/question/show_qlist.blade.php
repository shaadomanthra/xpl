@extends('layouts.app')
@section('title', 'Test '.$exam->name.' | PacketPrep')
@section('content')



@include('flash::message')

  <div class="row p-4">

    <div class="col-md-12">

@foreach($questions as $k=>$quest)
      
      <div class="mb-4">
        <div class="">
          
        <div class="row no-gutters">
        	<div class="col-1 col-md-1">
        		<div class="pr-3 pb-2 " >
        			<div class="text-center p-1 rounded  w100 qyellow"  style="">
        				{{ ($k+1) }} 
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 quest">{!! $quest->question !!}</div>
        </div>
        </div>

        <div class="row">
          <div class="col-3">
            @if($quest->a)
             <div class="row no-gutters">
              <div class="col-1 col-md-3">
                <div class="pr-3 pb-2" >
                  <div class="text-center p-1 border rounded bg-light w100  " >
                     A </div>
                </div>
              </div>
              <div class="col-9 col-md-9"><div class="pt-1 a">{!! $quest->a!!}</div></div>
            </div>
            @endif
          </div>

          <div class="col-3">
            @if($quest->b)
             <div class="row no-gutters">
              <div class="col-1 col-md-3">
                <div class="pr-3 pb-2" >
                  <div class="text-center p-1 border rounded bg-light w100  " >
                     B </div>
                </div>
              </div>
              <div class="col-9 col-md-9"><div class="pt-1 a">{!! $quest->b!!}</div></div>
            </div>
            @endif
          </div>

          <div class="col-3">
            @if($quest->c)
             <div class="row no-gutters">
              <div class="col-1 col-md-3">
                <div class="pr-3 pb-2" >
                  <div class="text-center p-1 border rounded bg-light w100  " >
                     C </div>
                </div>
              </div>
              <div class="col-9 col-md-9"><div class="pt-1 a">{!! $quest->c!!}</div></div>
            </div>
            @endif
          </div>

          <div class="col-3">
            @if($quest->d)
             <div class="row no-gutters">
              <div class="col-1 col-md-3">
                <div class="pr-3 pb-2" >
                  <div class="text-center p-1 border rounded bg-light w100  " >
                     D </div>
                </div>
              </div>
              <div class="col-9 col-md-9"><div class="pt-1 a">{!! $quest->d!!}</div></div>
            </div>
            @endif
          </div>

        </div>
        
         
        </div>
      </div>



      

     
@endforeach
    </div>



  </div> 





@endsection