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
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
       
      </div>

      @if(isset($products))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Product</label>
        <select class="form-control" name="product_id">
          <option value="0"  >None</option>
          @foreach($products as $product)
          <option value="{{$product->id}}" @if($obj->product) @if($product->id == $obj->product->id ) selected @endif @endif >{{ $product->name }}</option>
          @endforeach         
        </select>

      </div>
      @endif
      

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