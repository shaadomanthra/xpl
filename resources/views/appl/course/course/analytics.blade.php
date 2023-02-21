@extends('layouts.app')
@section('title', $course->name.' - Analytics')


@section('content')


<div class="d-none d-md-block d-print-none">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.index')}}">Courses</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.show',$course->slug)}}">{{ $course->name }}</a></li>
     
    </ol>
  </nav>
</div>

<div class="">
<div class="row ">
  <div class="col-12">
    <div class="card">
        <div class="card-body">
          <h1>{{$course->name}}</h1>
          @if($category)
          <h4><i class="fa fa-angle-double-right"></i> {{$category->name}}</h4>
          @else
          <h4><i class="fa fa-angle-double-right"></i> All Topics</h4>
          @endif

          <hr>

          @if(isset($batches))
           <h3>Batch Completion</h3>
     <div class="table-responsive mb-3">
          <table class="table table-bordered mb-0 bg-light">
            <thead>
              <tr>
                <th scope="col">Batch</th>
                <th scope="col">Students</th>
                <th scope="col">Avg Completion</th>
              </tr>
            </thead>
            <tbody>
              @foreach($batches as $g=>$h)
              <tr>
                <td>{{$h['name']}}</td>
                <td>{{$h['count']}}</td>
                <td>{{$h['avg']}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      @endif

      
          @if(request()->get('batch'))
          @if(count($users))
          <h3>Student Completion</h3>
          <table class="table table-bordered mt-3">
            <thead>
              <tr class="bg-light">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Roll Number</th>
                <th scope="col">Batch</th>
                <th scope="col">Completion</th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $i=>$u)
              <tr>
                <th scope="row" class="p-1">{{$i+1}}</th>
                <td class="p-1">
                  @if(isset($category->slug)) <a href="{{ route('course.question',[$course->slug,$category->slug,''])}}?student={{$u->username}}" class="d-print-none">{{$u->name}}</a> @else
                  <a href="{{ route('profile','@'.$u->username) }}" class="d-print-none">{{$u->name}}</a> 

                  <span class="d-print-block d-none">{{$u->name}}</span>
                
                  @endif

                  
                </td>
                <td class="p-1">  <span class="">  {{$u->roll_number}}</span></td>
                <td class="p-1">{{strtoupper($u->info)}}</td>
                <td class="p-1">
                  @if($total)
                  @if(isset($practice[$u->id]))
                  @if($practice[$u->id])
                    @if(is_array($practice[$u->id]))
                    {{count($practice[$u->id])}} / {{$total}}
                    <div class="progress" style="height:8px">
                      <div class="progress-bar" role="progressbar" style="width: {{round(count($practice[$u->id])/$total*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    {{$practice[$u->id]}} / {{$total}}
                    <div class="progress" style="height:8px">
                      <div class="progress-bar" role="progressbar" style="width: {{round($practice[$u->id]/$total*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  @endif
                  @endif
                  @endif
                </td>
              </tr>
            @endforeach
             
            </tbody>
          </table>
          <div class="my-2 text-info">{{ "Report Generated : " . date("d-m-Y h:i:s a", strtotime("now")) }}</div>
          @else
            <div class="bg-light border p-3 rounded mt-3">No data found</div>
          @endif
          <a href="{{ url()->previous() }}" class="btn btn-primary mt-3 d-print-none">go back</a>
          @else
          <form action="" >
            <div class="form-group mt-5">
    <label for="exampleInputEmail1">Practice Questions Data</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="batch" placeholder="Enter batch number">
    <input type="text" class="form-control my-3" id="exampleInputEmail1" aria-describedby="emailHelp" name="topic" placeholder="Enter topic slug (optional)" value="@if(request()->get('topic') ){{request()->get('topic') }} @endif">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>

          </form>

          <hr>

          <form action="{{ url('/performance')}}" >
            <div class="form-group mt-5">
    <label for="exampleInputEmail1">Exam Data</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="info" placeholder="Enter batch number">
    <input type="hidden" name="course" value="{{$course->slug}}" >
    <input type="text" class="form-control my-3" id="exampleInputEmail1" aria-describedby="emailHelp" name="exam" placeholder="Enter exam slug (optional)" value="@if(request()->get('exam') ){{request()->get('exam') }} @endif">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>

          </form>

          @endif

        </div>
    </div>
  </div>

</div>    
</div>
@endsection           