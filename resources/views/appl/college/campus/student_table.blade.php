 @extends('layouts.app')
@section('title', 'Campus Students | PacketPrep')
@section('description', 'This page for listing students under campus')
@section('keywords', 'college,packetprep,campus connect')
@section('content')
<div class="container mt-4 mb-4">

          <div class="border p-3 ">
            <h2>Student List 
              @if(request()->get('practice'))
                - Practice
              @endif

              @if(request()->get('test'))
                - Test
              @endif
            </h2>
            @if(request()->get('branch'))
            <div><b>Branch : </b>{{$item['branch']->name }} </div>
            @endif
            @if(request()->get('batch_code'))
            <div><b>Batch : </b>{{$item['batch']->name }} </div>
            @endif
            @if(request()->get('topic'))
            <div><b>Topic : </b>{{$item['topic']->name }} </div>
            @endif
            @if(request()->get('course'))
            <div><b>Course : </b>{{ $item['course']->name }} </div>
            @endif
            <div><b>Participants : </b>{{count($users) }} </div>
          </div>
          @if(count($users))
          <div class="rounded table-responsive">
           <table class="table mt-4  table-bordered bg-white" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col" class="" >Branch</th>
                <th scope="col" class="" >Roll number</th>
                <th scope="col" class="" >Completion</th>
                <th scope="col" class="" >Accuracy</th>
                
              </tr>
            </thead>
            <tbody>
          @foreach($users as $m=> $user)
            <tr>
          <th scope="row">{{++$m}}</th>
          <td><a href="{{ route('campus.courses')}}?student={{$user->username}}">{{$user->name}}  </a></td>
          <td>{{ ($user->branches()->first())?$user->branches()->first()->name:'-'}} </td>
          <td>{{ ($user->details()->first())?$user->details()->first()->roll_number:'-'}}</td>
          <td>
            <div class="mb-3" style="font-weight: 100"> {{$data[$user->id]['completion']}}%</div>
            <div class="progress " style="height: 3px">
              <div class="progress-bar bg-primary" role="progressbar" style="width: {{$data[$user->id]['completion']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>
          </td>
          <td>
            <div class="mb-3" style="font-weight: 100"> {{$data[$user->id]['accuracy']}}%</div>
            <div class="progress " style="height: 3px">
              <div class="progress-bar bg-success " role="progressbar" style="width: {{$data[$user->id]['accuracy']}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>
          </td>

          </tr>
          @endforeach
            </tbody>
          </table>
          </div>
          <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif mb-3 mb-md-0">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
          @else
           <div class="card mt-4"><div class="card-body"> <i class="fa fa-exclamation-circle"></i> Students have not participated </div></div>
          @endif

</div>
@endsection