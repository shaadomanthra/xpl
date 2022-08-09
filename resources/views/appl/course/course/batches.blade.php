@extends('layouts.none')

@section('title', 'Batches')
@section('content')



@if(!request()->get('batches'))
<div class="bg-white ">
  <div class="bg-white border p-3">
    <div class="p-2">
      <h1 class="display-4 mb-3"> <div class="">Enter the Batches </div></h1>
      <form>
        <input type="text" class="form-control w-100 mb-3" name="batches" value="{{ request()->get('batches')}}">
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>    
</div>
@else
<div class="bg-white mb-3">
  <div class="bg-white border p-3">
      <a href="{{ url()->previous() }}" class="float-right"><button class="btn btn-success">Back</button></a>
    <h1 class="display-4 mb-1"> <div class="">Batch Analysis </div></h1>
   
  
  </div>
</div>
  <div class="row">
  @foreach($data as $bno)
    
        <div class="col-12 col-md-4">
            <div class="card w-100">
              <div class="card-header"><h3>{{strtoupper($bno['batch'])}} [{{count($bno['users'])}}]</h3></div>
              <div class="card-body">
                @if(isset($bno['practice_set']))
                @foreach($bno['practice_set'] as $a=>$b)
                    <div class="">{{$bno['users'][$a]->name}} <span class="float-right">{{$b}}</span></div>
                @endforeach
                @endif
              </div>
              <div class="card-footer">
                 Student Count: {{count($bno['users'])}}<br>
           Total Solved Questions : {{($bno['pavg']*count($bno['users']))}}<br>
        
        Total Avg Practice Ques : <b>{{round($bno['pavg'],2)}}</b><br>
        <span class="text-info">Last 7 days Solved Questions : <b>{{($bno['wpavg']*count($bno['users']))}}</b></span><br>
        <span class="text-info">Last 7 days Avg Practice Ques : <b>{{round($bno['wpavg'],2)}}</b></span><br>
              </div>
            </div>
        </div>
    
  @endforeach
  </div>
@endif
@endsection           