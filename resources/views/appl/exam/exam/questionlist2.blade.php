@extends('layouts.nowrap-white')
@section('title', 'Question List')
@section('content')
<style>
h4{
  line-height: 30px;
}
</style>
@include('appl.exam.exam.xp_css')
<div class="dblue d-print-none">
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Questions </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
      </div>
     
    </div>
  </div>
</div>
<div class='p-1  ddblue d-print-none' ></div>

<div class="container">
@include('flash::message')
<div  class="row py-4">

  <div class="col-md-12">

    @if(request()->get('all'))
    <div class="card  bg-light mb-3">
      <div class="card-body">
        <div class="row mb-0">
          <div class="col-12 col-md-4">
            <h3> Level</h3>
            <hr>
            <dl class="row mb-0">
              <dt class="col-sm-6">No Level</dt>
              <dd class="col-sm-6">{{$qdata['no_level']}}</dd>
              <dt class="col-sm-6">Level 1</dt>
              <dd class="col-sm-6">{{$qdata['level1']}}</dd>
              <dt class="col-sm-6">Level 2</dt>
              <dd class="col-sm-6">{{$qdata['level2']}}</dd>
              <dt class="col-sm-6">Level 3</dt>
              <dd class="col-sm-6">{{$qdata['level3']}}</dd>
            </dl>

          </div>
          <div class="col-12 col-md-4">
            <h3> Topic</h3>
            <hr>
            <dl class="row">
            @foreach($qdata['topic'] as $k=>$t)
              <dt class="col-sm-6">{{$k}}</dt>
              <dd class="col-sm-6">{{$t}}</dd>

            @endforeach
            </dl>
            

          </div>

          <div class="col-12 col-md-4">
            <h3> Mark</h3>
            <hr>
            <dl class="row mb-0">
              <dt class="col-sm-3">1 Mark</dt>
              <dd class="col-sm-9">{{$qdata['mark_1']}}</dd>
              <dt class="col-sm-3">2 Mark</dt>
              <dd class="col-sm-9">{{$qdata['mark_2']}}</dd>
              <dt class="col-sm-3">3 Mark</dt>
              <dd class="col-sm-9">{{$qdata['mark_3']}}</dd>
              <dt class="col-sm-3">4 Mark</dt>
              <dd class="col-sm-9">{{$qdata['mark_4']}}</dd>
              <dt class="col-sm-3">5 Mark</dt>
              <dd class="col-sm-9">{{$qdata['mark_5']}}</dd>
            </dl>
            

          </div>

        </div>
        
      </div>
    </div>
    @endif
 
    <div class=" mb-3 mb-md-0">
      <div class="mb-0">
       

        <div id="search-items bg-white">
         <img 
        src="{{ request()->session()->get('client')->logo }} " height="50px" class="ml-md-0 mb-5 d-none d-print-block float-right"  alt="logo " type="image/png">

          <div class="mb-4">
          <h1 class="text-primary">{{$exam->name}}</h1>
            <p> {{$exam->questionCount()}} Questions | {{$qdata['time']}} min </p>
            <hr>
            <p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________________________________________</p>
                <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________________________________________</p>
                <p>Phone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________________________</p>
              <h5 class="text-success">Instructions</h5>
              <p>{!! $exam->instructions !!}
              </p>

          </div>
      @if(count($data)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$obj)  
              <tr>
                <td>
                  @if($obj->passage)
                    <div class="p-4 mb-3" style="background-color: #ddffef;border: 1px solid #caefdd;border-radius: 5px;">
                      {!!$obj->passage!!}
                    </div>
                  @endif
                  <h4 ><span class="float-left">(Q{{ ($key+1) }}) &nbsp;</span> {!! $obj->question !!} </h4>
                  <p>
                    <div class="row">
                      <div class="col-6">
                        @if($obj->a)
                    <div class="row no-gutters">
                      <div class="col-2 col-md-1">(A)</div>
                      <div class="col-10 col-md-11">{!! $obj->a !!}</div>
                    </div>
                    @endif
                      </div>
                      <div class="col-6">
                         @if($obj->b)
                    <div class="row no-gutters">
                      <div class="col-2 col-md-1">(B)</div>
                      <div class="col-10 col-md-11">{!! $obj->b !!}</div>
                    </div>
                    @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                         @if($obj->c)
                    <div class="row no-gutters">
                      <div class="col-2 col-md-1">(C)</div>
                      <div class="col-10 col-md-11">{!! $obj->c !!}</div>
                    </div>
                    @endif
                      </div>
                      <div class="col-6">
                         @if($obj->d)
                    <div class="row no-gutters">
                      <div class="col-2 col-md-1">(D)</div>
                      <div class="col-10 col-md-11">{!! $obj->d !!}</div>
                    </div>
                    @endif
                      </div>
                    </div>
                    

                   

                   

                   

                    @if($obj->e)
                    <div class="row no-gutters">
                      <div class="col-2 col-md-1">(E)</div>
                      <div class="col-10 col-md-11">{!! $obj->e !!}</div>
                    </div>
                    @endif

                  </p>
                  <div>Your Answer: ________________________</div>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No questions listed
        </div>
        @endif
       

       </div>

     </div>
   </div>
 </div>

</div>
</div>

@endsection


