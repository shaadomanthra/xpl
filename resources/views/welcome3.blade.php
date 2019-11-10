@extends('layouts.app2')
@section('title', 'Xplore - The Best Assessment Platform')
@section('description', 'The best repository for placement papers and aptitude questions for infosys, tcs nqt,tcs ninja, tcs digital, amcat, cocubes, accenture, cognizant, wipro and many more ')
@section('keywords', 'campus placement preparation, wipro placement papers, infosys placement papers, aptitude questions, amcat previous papers, amcat preparation,tcs nqt, tcs ninja, tcs digital')
@section('content')
<div class="bg-white p-3 p-md-5">
<div class="container" style="">
  <div class="row ">
    <div class="col-12 col-md-7 ">
      <div class="display-4 mt-4 mb-4">The best assessment platform for</div>
      <div class="display-1 mb-4" style="font-family: 'Anton', sans-serif;color:#bf5658">Colleges & Companies</div>
      <div class="">
        <a href="{{ route('course.show','quantitative-aptitude')}}">
        <span class="btn btn-success  mr-3 mb-3">Quantitative Aptitude</span></a>
        <a href="{{ route('course.show','logical-reasoning')}}">
        <span class="btn btn-success mr-3 mb-3">Logical Reasoning</span></a> 
        <a href="{{ route('course.show','mental-ability')}}">
        <span class="btn btn-success mr-3 mb-3">Mental Ability</span></a>    
        <a href="{{ route('course.show','verbal-ability-1')}}">
        <span class="btn btn-success mr-3 mb-3">Verbal Ability</span></a>    
        <a href="{{ route('course.show','interview-skills')}}">
        <span class="btn btn-success mr-3 mb-3">Interview Skills</span></a>  
        <a href="{{ route('course.show','programming-concepts-interviews')}}">
        <span class="btn btn-success mr-3 mb-3">Programming Concepts</span></a>   
        <a href="{{ route('course.show','coding-for-interviews')}}">
        <span class="btn btn-success mr-3 mb-3">Coding</span></a> 

  
      </div>
    </div>
    <div class="col-12 col-md-5">
      
  <img srcset="{{ asset('img/banner_xpl2.jpg') }}" class="w-100 d-none d-md-block" alt="xplore banner">
    </div>
  </div>
</div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <div class="video_body">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection    