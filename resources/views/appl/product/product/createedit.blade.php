@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Product
        @else
          Update Product
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('product.store')}}" >
      @else
      <form method="post" action="{{route('product.update',$product->slug)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Product Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Product Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $product->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Product Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $product->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>


      <div class="form-group">
        <label for="formGroupExampleInput ">Description</label>
        <textarea class="form-control summernote" name="description"  rows="5">
            @if($stub=='Create')
            {{ (old('description')) ? old('description') : '' }}
            @else
            {{ $product->description }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Price</label>
        <input type="number" class="form-control" name="price" id="formGroupExampleInput" placeholder="Enter the Price" 
            @if($stub=='Create')
            value="{{ (old('price')) ? old('price') : '' }}"
            @else
            value = "{{ $product->price }}"
            @endif
          >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($product)) @if($product->status==0) selected @endif @endif >Private</option>
          <option value="1" @if(isset($product)) @if($product->status==1) selected @endif @endif > Public</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection