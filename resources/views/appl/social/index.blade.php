@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-9">

    <div class="card mb-3">
        <div class="card-body bg-light">
          <div  class="row ">
            <div class="col-2">
            <div class="text-center"><i class="fa fa-gg-circle fa-5x"></i> </div>
            </div>
            <div class="col-9">
              <h1 class=" mb-2"> Social App</h1>
              <p class="mb-0">
                This is an app to stream line digital media marketing using blog posts and feeds for social media.
              </p>
            </div>
         </div>
        </div>
    </div>

    

   <div class="card">
      <div class="card-body pb-1">
        <h2 class="mb-4"><i class="fa fa-camera-retro"></i> Social Media - Weekly </h2>
        @if($socials)
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">Schedule</th>
                <th scope="col">Content</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($socials as $key => $col)  
              <tr>
                <td>{{ \carbon\carbon::parse($key)->format('M d Y') }}</td>
                <td>
              @foreach($col as $item=>$social)
              
                  @if($social->network==1)
                    <b>Facebook</b><br>
                  @elseif($social->network == 2)
                    <b>Instagram</b><br>
                  @else
                    <b>Twitter  </b><br>
                  @endif
                
                  @if(trim($social->image)!= '&nbsp;')
                  <img src="{{ route('root').'/'.$social->image }}" width="100px"/>  
                  @else
                  -NA-
                  @endif 

                  <a href=" {{ route('media.edit',$social->id) }} ">
                  {!! $social->content !!}
                  </a><br>
                
              
              @endforeach
               </td>
               <td>
                  @if($social->status==0)
                    Draft
                  @elseif($social->status ==1)
                    Published
                   @endif     
                </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        @else
        <div class="card card-body  mb-3">
          No Items listed
        </div>
        @endif
        <nav aria-label="Page navigation example">
      </nav>

     </div>
     </div>
   </div>

  </div>

  <div class="col-md-3 pl-md-0">
      @include('appl.social.snippets.menu')
    </div>
</div>

@endsection


