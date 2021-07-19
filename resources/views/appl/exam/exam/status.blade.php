@extends('layouts.app-metronic')
@section('title', 'Candidate Status - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')




<div class="mt-4 container" >
<nav class="mb-0">
  <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    @if(auth::user()->role!=11)
    <li class="breadcrumb-item"><a href="{{ url('/exam')}}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug)}}">{{$exam->name}}</a></li>
       <li class="breadcrumb-item"><a href="{{ route('test.active',$exam->slug)}}">Live Tracker</a></li>

    @else
    <li class="breadcrumb-item">Tests</li>
    @endif
  </ol>
</nav>



    <div class="row proctoring" data-active="{{$exam->active}}">
      <div class="col-12  col-md-5">

        <div class=' pb-3'>
          <p class="heading_two mb-2 f30 " >
              <span class="svg-icon svg-icon-primary svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-15-014444/theme/html/demo1/dist/../src/media/svg/icons/Devices/LTE1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M15.4508979,17.4029496 L14.1784978,15.8599014 C15.324501,14.9149052 16,13.5137472 16,12 C16,10.4912085 15.3289582,9.09418404 14.1893841,8.14910121 L15.466112,6.60963188 C17.0590936,7.93073905 18,9.88958759 18,12 C18,14.1173586 17.0528606,16.0819686 15.4508979,17.4029496 Z M18.0211112,20.4681628 L16.7438102,18.929169 C18.7927036,17.2286725 20,14.7140097 20,12 C20,9.28974232 18.7960666,6.77820732 16.7520315,5.07766256 L18.031149,3.54017812 C20.5271817,5.61676443 22,8.68922234 22,12 C22,15.3153667 20.523074,18.3916375 18.0211112,20.4681628 Z M8.54910207,17.4029496 C6.94713944,16.0819686 6,14.1173586 6,12 C6,9.88958759 6.94090645,7.93073905 8.53388797,6.60963188 L9.81061588,8.14910121 C8.67104182,9.09418404 8,10.4912085 8,12 C8,13.5137472 8.67549895,14.9149052 9.82150222,15.8599014 L8.54910207,17.4029496 Z M5.9788888,20.4681628 C3.47692603,18.3916375 2,15.3153667 2,12 C2,8.68922234 3.47281829,5.61676443 5.96885102,3.54017812 L7.24796852,5.07766256 C5.20393339,6.77820732 4,9.28974232 4,12 C4,14.7140097 5.20729644,17.2286725 7.25618985,18.929169 L5.9788888,20.4681628 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <circle fill="#000000" cx="12" cy="12" r="2"/>
            </g>
        </svg><!--end::Svg Icon--></span>
           Candidate Status 
        </p>

        </div>

       
       
      </div>
      <div class="col-12  col-md-4">
        
      </div>
      <div class="col-12  col-md-3">
        
      </div>
     
    </div>


    <div class="card bg-success mb-4 text-white">
      <div class="card-body">
        <h4 class="text-light-success"><i class="fa fa-file-pdf-o text-light-success"></i> &nbsp;Answersheet PDF Upload URL (optional)</h4>
         <a href="{{ route('test.pdfupload',$exam->slug)}}"  class="text-white h2" target="_blank">{{ route('test.pdfupload',$exam->slug)}}</a>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h3 class="mb-3">Exam: <span class="text-primary">{{$exam->name}}</span></h3>
        <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Upload Images</th>
                <th scope="col">Answersheet PDF</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody class="{{$m=0}}">
              @foreach($users as $ud=>$ux)
              <tr class="{{$m=$m+1}}">
                <th scope="row">{{$m}}</th>
                <td>
                  <div class="d-flex align-items-center">   
                  <div class="symbol symbol-40 symbol-sm flex-shrink-0">                <img class="" src="{{$ux['last_photo']}}" alt="photo">              </div>
                    <div class="ml-4">                <a href="#" class="text-dark-75 text-hover-primary font-weight-bolder font-size-lg mb-0">{{$ux['uname']}}</a>                <div class="text-muted font-weight-bold">{{$ux['os_details']}}</div>              </div>            </div>
                </td>
                <td><h4><a href="{{ route('assessment.response_images',$exam->slug)}}?student={{$ud}}" target="_blank">{{ $ux['imagecount']}}</a></h4></td>
                <td>
                  @if(Storage::disk('s3')->exists('pdfuploads/'.$exam->slug.'/'.$exam->slug.'_'.$ud.'.pdf'))
               <div class="">
                <a href="{{ route('test.pdfupload',$exam->slug)}}?student={{$ud}}"  class="" target="_blank"><i class="fa fa-file-pdf-o text-primary"></i> &nbsp;Answersheet PDF uploaded</a>
              </div>
              @else
              - 
              @endif
                </td>
                <td>@if($ux['completed']!=1) <span class="text-secondary"> <i class="fa fa-ellipsis-h text-secondary" aria-hidden="true"></i> ongoing</span>  @else <span class="text-success"> <i class="fa fa-check-circle text-success"></i> completed</span> @endif</td>
              </tr>
              @endforeach
           
            </tbody>
          </table>
      </div>
    </div>
     
  </div>
</div>



@endsection


