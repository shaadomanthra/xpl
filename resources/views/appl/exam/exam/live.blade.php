@extends('layouts.app-metronic')
@section('title', 'Live Data - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')
<style>
.progress-bar{padding:left:10px;}
.progress{position: relative;}
.fleft{ position: absolute;right:10px;top:18px; color:black;}
.fright{ position: absolute;left:10px;top:18px; color:black;}
</style>

<div class="my-4 py-4" >
  <div class="container">

   
    <div class="row">
      <div class="col-12 col-md-8 col-lg-8">
       <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Participants </li>
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30 " >
            <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Chart-line1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
        <path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>
           Live Tracking </p>
           <span class="text-secondary"><small>Auto page refresh - 10 sec</small></span>
        </div>

      </div>
     

    </div>
  </div>
</div>

<div class="container">
<div class="row">
<div class="col-6 col-md-3">
                    <!--begin::Stats Widget 30-->
                    <div class="card card-custom bg-info card-stretch gutter-b">
                      <!--begin::Body-->
                      <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                          <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Group.svg-->
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24" />
                              <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                              <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                          </svg>
                          <!--end::Svg Icon-->
                        </span>
                        <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{($data['total'])}}</span>
                        <span class="font-weight-bold text-white font-size-sm">Total Participants</span>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 30-->
                  </div>

                  <div class="col-6 col-md-3">
                    <!--begin::Stats Widget 20-->
                    <div class="card card-custom bg-light-warning card-stretch gutter-b">
                      <!--begin::Body-->
                      <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-warning font-size-h6 mb-4 text-hover-state-dark d-block">Live Participants ({{round((($data['total']-$data['completed'])*100/$data['total']))}}%)</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{($data['total']-$data['completed'])}}</span></div>
                        <div class="progress progress-xs mt-7 bg-warning-o-60">
                          <div class="progress-bar bg-warning" role="progressbar" style="width: {{(($data['total']-$data['completed'])*100/$data['total'])}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 20-->
                  </div>

                  <div class="col-6 col-md-3">
                    <!--begin::Stats Widget 22-->
                    <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{asset('assets/media/svg/shapes/abstract-3.svg') }})">
                      <!--begin::Body-->
                      <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-primary font-size-h6 mb-4 text-hover-state-dark d-block">Completed ({{round((($data['completed'])*100/$data['total']))}}%)</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{($data['completed'])}}</span></div>
                        <div class="progress progress-xs mt-7 bg-info-o-60">
                          <div class="progress-bar bg-primary" role="progressbar" style="width: {{(($data['completed'])*100/$data['total'])}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 22-->
                  </div>


                  <div class="col-6 col-md-3">
                    <!--begin::Stats Widget 20-->
                    <div class="card card-custom bg-light-danger card-stretch gutter-b">
                      <!--begin::Body-->
                      <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-danger font-size-h6 mb-4 text-hover-state-dark d-block">Inactive </a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2 counter_rejected">{{($data['inactive'])}}</span></div>
                       
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 20-->
                  </div>

</div>
</div>

@include('flash::message')

<div class="container">

<div  class="row  {{$i=0}}">

  

  

@foreach($questions as $q => $question)
<div class="col-md-6 ">
  <div class="card  card-custom my-3">
    <div class="card-body ">
      <div class="row no-gutters">
        <div class="col-2 col-md-1">
          <div class="pr-3 pb-2 " >
            <div class="text-center p-1 rounded  w100 qno  qyellow "  style="" data-qqno="{{$question->id}}">
              {{ ($i=$i+1) }}
            </div>
          </div>
        </div>
        <div class="col-10 col-md-11">
          <div class="pt-1  disable-select">{!! $question->question!!}</div>

        </div>
      </div>

  @if($question->type=='maq')
    <div class="alert alert-info alert-important">Select one or more choices from the given options.</div>
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-1">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded  w100  @if (strpos('A', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > A </div>
          </div>
        </div>

        <div class="col-9 col-md-11"><div class=" ">
          <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_a}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_a}}" aria-valuemin="0" aria-valuemax="100"> 

                </div>
                <span class="fleft" >{{$question->opt_a}}%</span>
                <span class="fright" >{!! substr($question->a ,40)!!}</span>
              </div>
        </div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-1">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded  w100  @if (strpos('B', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > B </div>
            </div>
          </div>

          <div class="col-9 col-md-11"><div class=" ">
            <div class="progress " style="height:32px;margin-top:1px;color:red">
                  <div class="progress-bar" role="progressbar" style="width: {{$question->opt_b}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_b}}" aria-valuemin="0" aria-valuemax="100"> 

                  </div>
                  <span class="fleft" >{{$question->opt_b}}%</span>
                  <span class="fright" >{!! $question->b!!}</span>
                </div>
          </div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-1">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded  w100  @if (strpos('C', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > C </div>
              </div>
            </div>

            <div class="col-9 col-md-11"><div class=" ">
              <div class="progress " style="height:32px;margin-top:1px;color:red">
                    <div class="progress-bar" role="progressbar" style="width: {{$question->opt_c}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_c}}" aria-valuemin="0" aria-valuemax="100"> 

                    </div>
                    <span class="fleft" >{{$question->opt_c}}%</span>
                    <span class="fright" >{!! $question->c!!}</span>
                  </div>
            </div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-1">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if (strpos('D', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > D </div>
                </div>
              </div>

              <div class="col-9 col-md-11"><div class=" ">
                <div class="progress " style="height:32px;margin-top:1px;color:red">
                      <div class="progress-bar" role="progressbar" style="width: {{$question->opt_d}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_d}}" aria-valuemin="0" aria-valuemax="100"> 

                      </div>
                      <span class="fleft" >{{$question->opt_d}}%</span>
                      <span class="fright" >{!! $question->d!!}</span>
                    </div>
              </div></div>
            </div>
          @endif

          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-1">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if (strpos('E', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > E </div>
                </div>
              </div>

              <div class="col-9 col-md-11"><div class=" ">
                <div class="progress " style="height:32px;margin-top:1px;color:red">
                      <div class="progress-bar" role="progressbar" style="width: {{$question->opt_e}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_e}}" aria-valuemin="0" aria-valuemax="100"> 

                      </div>
                      <span class="fleft" >{{$question->opt_e}}%</span>
                      <span class="fright" >{!! $question->e!!}</span>
                    </div>
              </div></div>
            </div>
          @endif

  @elseif($question->type=='mcq')
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-1">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded  w100  @if($question->answer=='A') qgreen-border qgreen @else bg-light border @endif" > A </div>
          </div>
        </div>

        <div class="col-9 col-md-11"><div class=" ">
          <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_a}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_a}}" aria-valuemin="0" aria-valuemax="100"> 

                </div>
                <span class="fleft" >{{$question->opt_a}}%</span>
                <span class="fright" >{!! $question->a  !!}</span>
              </div>
        </div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-1">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded  w100  @if($question->answer=='B') qgreen-border qgreen @else bg-light border @endif" >  B</div>
            </div>
          </div>
          <div class="col-9 col-md-11"><div class=" ">
            <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_b}}%;height:50px;color:black;background: #c8d5de;" aria-valuenow="{{$question->opt_b}}" aria-valuemin="0" aria-valuemax="100"> 
                  
                </div>
                <span class="fleft" >{{$question->opt_b}}%</span>
                <span class="fright" >{!! $question->b!!}</span>
              </div>
          </div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-1">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded  w100  @if($question->answer=='C') qgreen-border qgreen @else bg-light border @endif " >C</div>
              </div>
            </div>
            <div class="col-9 col-md-11"><div class="">
              <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_c}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_c}}" aria-valuemin="0" aria-valuemax="100"> 
                
                </div>
                <span class="fleft" >{{$question->opt_c}}%</span>
                <span class="fright" >{!! $question->c!!}</span>
              </div>
            </div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-1">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if($question->answer=='D') qgreen-border qgreen @else bg-light border @endif" >D</div>
              </div>
            </div>
            <div class="col-9 col-md-11">
              <div class=" ">
               <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_d}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_d}}" aria-valuemin="0" aria-valuemax="100"> 
                  
                </div>
                <span class="fleft" >{{$question->opt_d}}%</span>
                <span class="fright" >{!! $question->d!!}</span>
              </div>
              </div></div>
          </div>
          @endif


          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-1">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if($question->answer=='E') qgreen-border qgreen @else bg-light border @endif" > 
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-11"><div class=" ">
              <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_e}}%;height:50px;color:black;background: #c8d5de" aria-valuenow="{{$question->opt_e}}" aria-valuemin="0" aria-valuemax="100"> 
                </div>
                <span class="fleft" >{{$question->opt_e}}%</span>
                <span class="fright" >{!! $question->e!!}</span>
              </div>
            </div></div>
          </div>
          @endif

      @endif
    </div>
  </div>
</div>
@endforeach
  


 </div>
 
</div>
<script>
setTimeout(function(){
   window.location.reload(1);
}, 10000);
  </script>



@endsection


