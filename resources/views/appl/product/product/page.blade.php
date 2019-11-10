
@extends('layouts.app')
@section('content')

@section('title',  $product->name .' Product Page | Xplore')

@section('description', 'The following page lists the product '.$product->name.', '.$product->description)

@section('keywords', ' products')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/productpage')}}">Products</a></li>
    <li class="breadcrumb-item">{{ $product->name}}</li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-12 col-md-12">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $product->name }} 

          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          

          <div class="row mb-2">
            <div class="col-12 col-md-4">Description</div>
            <div class="col-12 col-md-8">
              {!! $product->description !!}
            </div>
          </div>
          <hr>

         
         @if(!$entry)
          <div class="row mb-2">
            <div class="col-12 col-md-4">Price</div>
            <div class="col-12 col-md-8">
              <h1>

              <i class="fa fa-rupee"></i> {{ $product->price }}
            </h1>
            </div>
          </div>
          <hr>
          @else
          <div class="row mb-2">
            <div class="col-md-4">Status</div>
            <div class="col-md-8">
              @if(strtotime(\auth::user()->products->find($product->id)->pivot->valid_till) > strtotime(date('Y-m-d')))
                      @if(\auth::user()->products->find($product->id)->pivot->status==1)
                      <span class="badge badge-success">Active</span>
                      @else
                      <span class="badge badge-secondary">Disabled</span>
                      @endif
                    @else
                        <span class="badge badge-danger">Expired</span>
                    @endif
            </div>
          </div>
          <hr>

          @endif
          <div class="row mb-2">
            <div class="col-md-4">
              @if(count($product->exams)==0 && count($product->courses)==0 )
              Training
              @else
              Validity
              @endif
              </div>
            <div class="col-md-8">
              @if(count($product->exams)==0 && count($product->courses)==0 )
              Classroom program
              @else
              {{ $product->validity }} months
              @endif
            </div>
          </div>
          <hr>

                   <div class="row mb-2">
            <div class="col-12 col-md-4"></div>
            <div class="col-12 col-md-8">

              @if(!$entry)
              
              @auth
        <a href="{{ route('checkout')}}?product={{$product->slug}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth
             
                <button class="btn btn-success btn-lg ">
                @if($product->price==0)
                Access Now
                @else
                Buy Now
                @endif
                </button>
              </a>
              @else


              <div class=" border p-3 rounded bg-light mb-3"><h1>Service is activated - validity upto<br>
                 <span class="badge badge-primary">{{ date('d M Y', strtotime(\auth::user()->products->find($product->id)->pivot->valid_till)) }}</span>
                 </h1>
               </div>

               @if(strtotime(\auth::user()->products->find($product->id)->pivot->valid_till) < strtotime(date('Y-m-d')))

               @auth
       <a href="{{ route('checkout')}}?product={{$product->slug}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth
               
                <button class="btn btn-success btn-lg ">
                @if($product->price==0)
                Access Now
                @else
                Buy Now
                @endif
                </button>
              </a>
              @endif


              @endif

            </div>
          </div>
          <hr>  

          

          @if(count($product->courses)!=0)
          <div class="row mb-2">
            <div class="col-12 col-md-4">Courses Included</div>
            <div class="col-12 col-md-8">
            
            
             @foreach($product->courses as $course)
             <div class="p-3 border rounded mb-2">
             <a href="{{ route('course.show',$course->slug) }}">{{ $course->name }}</a> <br>
             @if($course->description)
             {!! $course->description !!}
             @endif
            </div>
             @endforeach
              
             
            
            </div>
          </div>
          @endif 

          @if(count($product->exams)!=0)
          <div class="row mb-2">
            <div class="col-12 col-md-4">Exams Included</div>
            <div class="col-12 col-md-8">
           
            @foreach($product->exams as $exam)
             <div class="p-3 border rounded mb-2">
             <a href="{{ route('assessment.show',$exam->slug) }}">{{ $exam->name }}</a>
             @if($exam->description)
             {!! $exam->description !!}
             @endif
            </div>
             @endforeach
           
           
            </div>
          </div>
           @endif 


           @if(count($product->exams)==0 && count($product->courses)==0 )
          <div class="row mb-2">
            <div class="col-12 col-md-4">Service Included</div>
            <div class="col-12 col-md-8">
           
           <div class="p-3 border rounded mb-2">
            <h3>Classroom Training</h3>
            <p class="bg-light p-3  rounded"> Kindly carry the print out of the following page to the packetprep office, after payment. </p>
          </div>
           
            </div>
          </div>
           @endif 


          
        
         
        </div>
      </div>

 


      

    </div>
    

    

  </div> 


<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-success">Login</button>
      </a>
      </div>
    </div>
  </div>
</div>


@endsection