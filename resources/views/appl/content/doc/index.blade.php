@extends('layouts.nowrap-product')
@section('content')

<div class=" p-4  bg-white mb-4 border-bottom">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="mt-2 mb-4 mb-md-2">
      <i class="fa fa-spotify"></i> &nbsp;Tracks
      @can('create',$doc)
            <a href="{{route('docs.create')}}">
              <button type="button" class="btn btn-outline-success btn-sm my-2 my-sm-2 mr-sm-3"><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
      </h1>

    </div>
    <div class="col-12 col-md-4">

      <form class="form" method="GET" action="{{ route('assessment.index') }}">

            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control form-control-lg" id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>

      </div>
  </div>
  </div>
</div>
</div>


<div class="wrapper " >
    <div class="container" >  
    
      <div class="row">
        

        <div class="col-12 ">
          <div id="search-items">
            @include('appl.content.doc.list')
          </div>
        </div>
      </div>


      

     </div>   
</div>



@endsection


