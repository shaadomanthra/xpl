@extends('layouts.app2')
@section('title', 'Companies Placement Preparation | PacketPrep')
@section('description', 'Here you will find placement preperation material for wipro,infosys, capgemini, delloite etc')
@section('keywords', 'company placement preparation')
@section('content')


@include('flash::message')
<div class="container">
  <div class="row">

    <div class="col-md-12">


      <div class="p-3 p-md-4 p-lg-5 bg-white company">

        <h1 class="mb-5"> Company Placement Material
        </h1>

        
        <div class="row">
        @foreach($companies as $company)
          <div class="col-12 col-md-4">
            <div class="card mb-4" >
              <div class="card-body">
                @if(file_exists('img/companies/'.$company.'.jpg'))
                <img srcset="{{ asset('img/companies/'.$company.'.jpg') }} 320w"
                  sizes="(max-width: 320px) 280px"
                  src="{{ asset('img/companies/'.$company.'.jpg') }} " class="w-75 pt-3 pb-3 pr-4" alt="{{$company}} Recruitment Process">
                @endif
                <h4 class="card-title article">{{ucfirst($company)}} placement papers and recruitment process</h4>
                @if(file_exists('img/companies/'.$company.'.jpg'))
                <small><a href="{{ $company}}-placement-papers-recruitment-process" class="card-link"> readmore <i class="fa fa-angle-right"></i></a></small>
                @endif
              </div>
            </div>
          </div>
        @endforeach
        </div>

        

      </div>
    </div>

  </div>

  


</div> 

</div>


@endsection