@extends('layouts.app2')
@section('title', 'Placement material for all companies | PacketPrep')
@section('description', 'Here you will find placement preperation material for wipro,infosys, capgemini, delloite etc')
@section('keywords', 'company placement preparation')
@section('content')

@include('flash::message')
<div class="container">
      <div class="p-3 p-md-4 p-lg-5 bg-white company">
        <h1 class="mb-2"> Placement material for all companies
        </h1>
        <p>Preparing for placements is a herculean task. Searching for previous papers, marking important questions, learning the quant fundamentals,  then verbal, reasoning and even coding...ufff..its no easy task.  We went through this cycle, and everybody in the final year of graduation also does the same. So we thought it could be a good idea to collect everything relevant to placements and stack them in one place.  </p>
        <p class="mb-5">Here you will find company-wise placement papers, practice questions for quantitative aptitude, verbal ability, reasoning, coding and interview questions. Do share this with your friends and post your feedback in the comments section. </p>
        
        <div class="row">
          @include('appl.content.article.blocks.company_list')
        </div>
      </div>
    </div>
</div>
@endsection