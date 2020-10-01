@extends('layouts.nowrap-white')
@section('title', 'User Roles - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">User Roles </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-bars "></i> User Roles
          </p>
        </div>
      </div>
      
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">
  <div  class="  mb-4 mt-4">
   
   <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Invigilators</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Evaluators</a>
      </li>
    </ul>
    <form method="post" action="{{route('test.user_roles',$exam->slug)}}" enctype="multipart/form-data">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        
         <div class="form-group">
            <div class="mt-2">
          <small class=" "> 
            <INPUT type="checkbox" onchange="checkAll(this)" name="chk[]" /> Check All
             <ul class="pt-2">
              <li>Assigned users can invigilate students assigned to them (automated) </li>
            </ul>
            </small>
          </div>
            <div class="border p-3">
              <div class="row">
              @foreach($data['hr-managers'] as $hr)
                 <div class="col-12 col-md-3">
                  <input  type="checkbox" name="viewers[]" value="{{$hr->id}}"
                   
                      @if($exam->evaluators)
                        @if(in_array($hr->id,$exam->viewers()->wherePivot('role','viewer')->pluck('id')->toArray()))
                        checked
                        @endif
                      @endif
                   
                  > 
                  {{$hr->name }}
                </div>
              @endforeach
            </div>
            </div>
          </div>

          @if($data['invigilation'])
          <div class="bg-light">
               <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invigilator</th>
                    <th scope="col">Candidates</th>
                  </tr>
                </thead>
                <tbody class="{{$i=0}}">
                  @foreach($data['invigilation'] as $id=>$set)

                  <tr>
                    <td scope="row">{{$i = $i+1}}</td>
                    <td scope="row">{{ $exam->viewers()->wherePivot('role','viewer')->find($id)->name }}({{count($set)}})</td>
                    <td><pre><code class="text-light">  {{ json_encode($set,JSON_PRETTY_PRINT) }}</code></pre></td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>


          </div>
          @endif

      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="form-group">
            <div class="mt-2">
          <small class=" "> 
            <ul class="pt-2">
              <li>Evaluators can award marks to subjective questions.</li>
              <li>View reports and download excel.</li>
              <li>Cannot modify test settings.</li>
            </ul>
            </small>
          </div>
            <div class="border p-3">
              <div class="row">
              
            </div>
            </div>
            
          </div>
      </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-primary" type="submit">Save</button>
  </form>

  </div>
</div>
<script>
function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
</script>


@endsection


