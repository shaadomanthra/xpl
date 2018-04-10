@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('system')}}">System</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('finance.index')}}">Finance</a></li>
    <li class="breadcrumb-item active" aria-current="page">@if($stub=='Create') Create @else Update @endif</li>
  </ol>
</nav>

  @include('flash::message')
  <div class="card">
    <div class="card-body">

      <nav class="navbar navbar-light bg-light justify-content-between mb-3 p-3 border">
          <a class="navbar-brand"><i class="fa fa-rupee"></i> {{ $stub }} Entry </a>
      </nav>    
      
      @if($stub=='Create')
      <form method="post" action="{{route('finance.store')}}">
      @else
      <form method="post" action="{{route('finance.update',$finance->id)}}">
      @endif  
      
      <div class="form-group">
        <input type="hidden" name="year" value="{{\Carbon\Carbon::now()->year}}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Flow</label>
        <select class="form-control" name="flow">
          <option value="0" @if(isset($finance)) @if($finance->flow==0) selected @endif @endif >In</option>
          <option value="1" @if(isset($finance)) @if($finance->flow==1) selected @endif @endif >Out</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Amount</label>
        <input type="number" class="form-control" name="amount" placeholder="Amount in Rupees" 
          @if($stub=='Create')
            value="{{ (old('amount')) ? old('amount') : '' }}"
            @else
            value = "{{ $finance->amount }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Details</label>
         <textarea class="form-control summernote" name="content"  rows="5">{{isset($finance)?$finance->content:''}}</textarea>
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">Transaction Date</label>
      <input type="text" class="form-control" name="transaction_at"   value="{{isset($finance->transaction_at)? \carbon\carbon::parse($finance->transaction_at)->format('Y-m-d'):''}}" id="datepicker">
    </div>

      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="@if(isset($finance->user_id)) {{$finance->user_id}} @else {{ \auth::user()->id }} @endif">
      </div>


      
      @if($stub=='Update')
      <input type="hidden" name="_method" value="PUT">
      @endif
      <button type="submit" class="btn btn-info">Save</button>
       <a href="#" class="btn  btn-outline-danger" data-toggle="modal" data-target="#exampleModal"  title="Delete" ><i class="fa fa-trash"></i> Delete</a>
    </form>
    </div>
  </div>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        This following action will delete the update and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('finance.destroy',$finance->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection