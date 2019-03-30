@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
    <li class="breadcrumb-item">{{ $product->name}}</li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-12 col-md-9">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $product->name }} 

          @can('update',$product)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('product.edit',$product->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('productpage',$product->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-eye"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-4">Product slug</div>
            <div class="col-md-8">
              {{ $product->slug}}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Description</div>
            <div class="col-md-8">
              {!! $product->description !!}
            </div>
          </div>

         
          <div class="row mb-2">
            <div class="col-md-4">Price</div>
            <div class="col-md-8">
              Rs. {{ $product->price }}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Validity</div>
            <div class="col-md-8">
              {{ $product->validity }} months
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-4">Status</div>
            <div class="col-md-8">
             @if($product->status==0)
                    <span class="badge badge-warning">Private</span>
                  @else
                    <span class="badge badge-success">Public</span>
                  @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Courses</div>
            <div class="col-md-8">
            @if(count($product->courses)!=0)
             @foreach($product->courses as $course)
             <div class="p-3 border rounded mb-2">
              <a href="{{ route('course.show',$course->slug) }}">{{ $course->name }}</a> <br>
             @if($course->description)
             {!! $course->description !!}
             @endif
            </div>
             @endforeach
           @else
              <div>- NA -</div>
            @endif 
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Exams</div>
            <div class="col-md-8">
            @if(count($product->exams)!=0)
             @foreach($product->exams as $exam)
             <div class="p-3 border rounded mb-2">
             <a href="{{ route('assessment.show',$exam->slug) }}">{{ $exam->name }}</a>
             @if($exam->description)
             {!! $exam->description !!}
             @endif
            </div>
             
             @endforeach
           @else
              <div>- NA -</div>
            @endif 
            </div>
          </div>
          
          
        
         
        </div>
      </div>

 


      

    </div>
    <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
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
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('product.destroy',$product->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection