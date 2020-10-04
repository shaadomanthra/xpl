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
          <p class="heading_two mb-2 f30" ><i class="fa fa-bars "></i> Assign Evaluators
          </p>
          <a href="{{ route('exam.show',$exam->slug)}}" class="mb-3"><i class="fa fa-angle-left"></i> &nbsp;back to test page</a>
        </div>
      </div>
      
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">
  <div  class="  mb-4 mt-4">
   
   
    <form method="post" action="{{route('test.user_roles',$exam->slug)}}" enctype="multipart/form-data">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        
         <div class="form-group">
            <div class="mt-2">
          <small class=" mb-3"> 
            <INPUT type="checkbox" onchange="checkAll(this)" name="chk[]" /> Check All
             
            </small>

            @if($data['evaluators'])
              <div class="p-3 border bg-light my-3">
                <h3> Assinged Evaluators</h3>
                @foreach($exam->viewers()->wherePivot('role','evaluator')->get() as $k=> $u)
                  @if($k!=0),@endif {{$u->name}} 
                @endforeach

              </div>
            @endif
          </div>
            <div class="border p-3">
              <div class="row">
              @foreach($data['hr-managers'] as $hr)
                 <div class="col-12 col-md-3">
                  <input  type="checkbox" name="evaluators[]" value="{{$hr->id}}"
                   
                      @if($exam->evaluators)
                        @if(in_array($hr->id,$data['evaluators']))
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

          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="evaluator" value="1">
    <button class="btn btn-primary my-4" type="submit">Save</button>

       

      </div>
     
    </div>

    
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


