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
      <form method="post" action="{{route('product.update',$product->slug)}}" enctype="multipart/form-data">
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


      @if($stub=='Update')
      <div class="form-group">
            <label for="formGroupExampleInput ">Attach users  - <a href="{{ asset('product_format.csv')}}">product_format.csv</a></label>
            <input type="file" class="form-control" name="file" id="formGroupExampleInput" >
         </div>
      @endif


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
        <label for="formGroupExampleInput ">Validity</label>
        <select class="form-control validity_data" name="validity">
          <option value="1" >1 month</option>
          @for($i=2;$i < 24;$i++)
          <option value="{{$i}}" @if(isset($product)) @if($product->validity == $i) selected @endif @endif>{{$i}} months</option>
          @endfor
           <option value="24" >24 months</option>
        </select>
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
        <label for="formGroupExampleInput ">Discount</label>
        <input type="number" class="form-control" name="discount" id="formGroupExampleInput" placeholder="Enter the Discount" 
            @if($stub=='Create')
            value="{{ (old('discount')) ? old('discount') : '' }}"
            @else
            value = "{{ $product->discount }}"
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


      <div class="form-group">
        <label for="formGroupExampleInput ">Courses</label>
        <div class="border p-2">
          <div class="row">
        @foreach($courses as $a=>$course)
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="courses[]" value="{{$course->id}}"
              @if($stub=='Create')
                @if(old('course'))
                  @if(in_array($course->id,old('course')))
                  checked
                  @endif
                @endif
              @else
                @if($product->courses)
                  @if(in_array($course->id,$product->courses->pluck('id')->toArray()))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$course->name }}
          </div>
        @endforeach
        </div>
        </div>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Exams</label>
        <div class="border p-2">
          <div class="row">
        @foreach($exams as $a=>$exam)
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="exams[]" value="{{$exam->id}}"
              @if($stub=='Create')
                @if(old('exam'))
                  @if(in_array($exam->id,old('exam')))
                  checked
                  @endif
                @endif
              @else
                @if($product->exams)
                  @if(in_array($exam->id,$product->exams->pluck('id')->toArray()))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$exam->name }}
          </div>
        @endforeach
        </div>
        </div>
      </div>

       

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection