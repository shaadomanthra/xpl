@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create {{ $app->module }}
        @else
          Update {{ $app->module }}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" >
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} code</label>
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter the Code" 
            @if($stub=='Create')
            value="{{ (old('code')) ? old('code') : '' }}"
            @else
            value = "{{ $obj->code }}"
            @endif
          >
       
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Product</label>
        <select class="form-control" name="product_id">
          <option value="0" @if(isset($obj)) @if($obj->product_id==0) selected @endif @endif >All</option>
          @foreach($products as $p)
          <option value="{{$p->id}}" @if(isset($obj)) @if($obj->product_id==$p->id) selected @endif @endif >{{$p->name}}</option>
          @endforeach
          
        </select>
      </div>
      

      <div class="form-group">
        <label for="formGroupExampleInput2">Percent</label>
        <input type="text" class="form-control" name="percent" id="formGroupExampleInput2" placeholder="Enter the percentage"
            @if($stub=='Create')
            value="{{ (old('percent')) ? old('percent') : '' }}"
            @else
            value = "{{ $obj->percent }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput2">Price</label>
        <input type="text" class="form-control" name="price" id="formGroupExampleInput2" placeholder="Enter the discount price"
            @if($stub=='Create')
            value="{{ (old('price')) ? old('price') : '0' }}"
            @else
            value = "{{ $obj->price }}"
            @endif
          >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Expiry</label>
      <input type="text" class="form-control" name="expiry"   value="{{isset($obj->expiry)? \carbon\carbon::parse($obj->expiry)->format('Y-m-d'):''}}" id="datepicker">
      </div>



      <div class="form-group">
        <label for="formGroupExampleInput ">Type</label>
        <select class="form-control" name="type">
          <option value="0" @if(isset($obj)) @if($obj->type==0) selected @endif @endif >Discount</option>
          <option value="1" @if(isset($obj)) @if($obj->type==1) selected @endif @endif >Access</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Inactive</option>
          <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
        </select>
      </div>

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection