@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')    
<div  class="row ">

  <div class="col-md-9">

    
    @include('flash::message')  
    <div class="card mb-3">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-2">
            <div class="text-center"><i class="fa fa-medium fa-5x"></i> </div>
            </div>
            <div class="col-9">
              <h1 class=" mb-2"> Material App</h1>
              <p class="mb-0">
                Backend of our product to create, process, validate and publish the data. 
              </p>
            </div>
         </div>
        </div>
    </div>
    <div class="card">
      <div class="card-body mb-0">
        sample
     </div>
   </div>
 </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.material_menu')
    </div>
</div>

@endsection


