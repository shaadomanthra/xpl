@extends('layouts.plain')
@section('content')


<div  class="row p-5">

  <div class="col-md-12">
    <div class="row mb-5">
      <div class="col-12 col-md-5">
           <h2 class="display-3">Hi, {{ $user->name}}</h2>
      <p> Welcome to PacketPrep</p>

      <p class="lead">"Develop a passion for learning.<br> If you do, you will never cease to grow "<br>- 
            Anthony J Dangelo</p>
      </div>
      <div class="col-12 col-md-7">
        
         <div class="card mb-3">
      <div class="card-body">
        
        <dl class="row">
  @if($user->colleges()->first())        
  <dt class="col-sm-4">College Name</dt>
  <dd class="col-sm-8">{{ $user->colleges()->first()->name}}</dd>
  @endif

  @if($user->branches())
  <dt class="col-sm-4">Branch</dt>
  <dd class="col-sm-8">
  @foreach($user->branches()->get() as $branch)
    {{ $branch->name}} &nbsp;
  @endforeach
  </dd>
  @endif

  <dt class="col-sm-4">Roll Number</dt>
  <dd class="col-sm-8">
    {{ ($user->details)?$user->details->roll_number:'' }}
  </dd>

  <dt class="col-sm-4">Year of Passing</dt>
  <dd class="col-sm-8">
    {{ ($user->details)?$user->details->year_of_passing:'' }}
  </dd>
  
</dl>  
  
        </div>
      </div>

      </div>

    </div>

    <div class="p-2"></div>
    <div class="">
      <div class="">
        
       
        <div class="row mb-5">

          <div class="col-12 col-md-5">
           
          <div class="">  
          <h1> Activation Code</h1>
           @if(isset($user->services()->first()->pivot->code))
          <div class="display-1 mb-3">{{$user->services()->first()->pivot->code}}</div>
          
          @else
           <div class="display-1 mb-3"> - NA -</div>
          @endif

          <h4>Instructions for service activation</h4>
          <ul>
            <li>Login to packetprep.com</li>
            <li>Open Dashboard page and enter activation code in the input box</li>
            <li>On confirmation, your services will be active</li>
          </ul>
        </div>
        
    </div>

    <div class="col-12 col-md-7">
       <div class="card mb-3">

      <div class="card-body">
        <h1 class="card-title">Account Details</h1>
        <dl class="row">

  
  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9">
    {{ $user->email }}
  </dd>
  <dt class="col-sm-3">Username</dt>
  <dd class="col-sm-9">{{ $user->username}}</dd>



  <dt class="col-sm-3">Password</dt>
  <dd class="col-sm-9">{{ $user->activation_token}}</dd>
  <dt class="col-sm-3">Website</dt>
  <dd class="col-sm-9">packetprep.com</dd>

  <dt class="col-sm-3">Status</dt>
  <dd class="col-sm-9">
     @if($user->status==0)
                    <span class="badge badge-secondary">Inactive</span>
                  @elseif($user->status==1)
                    <span class="badge badge-success">Active</span>
                    @elseif($user->status==2)
                    <span class="badge badge-warning">Blocked</span>
                  @endif
  </dd>
  
</dl>

         
  
        </div>
      </div>

    </div>

  </div>

             

    <div class="p-2"></div>
      <div class="card mb-5">
      <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-7">
              <h2> Your Services</h2>
              <div >
                @if($user->services())
                @foreach($user->services()->get() as $service)
                    <div class="display-4">{{ $service->name}} </div>
                @endforeach
                @else
                  <div class="display-4">- NA -</div>
                @endif
              </div>
            </div>
            <div class="col-12 col-md-5">
              <h2> Validity</h2>
              <div class="display-4">
              @if($service->name =='Pro Access')
                3 Months
              @else
                2 Years
              @endif
              </div>
            </div>
        </div>
        
        </div>
      </div>

      <div class="p-2"></div>
      <hr>
      <h3> About PacketPrep</h3>
      <p>
         PacketPrep, one stop learning platform for Bank exams, Government Exams and Campus Recruitment. With more than 200 video lectures, 5000+ practice questions and 100+ online tests, makes students learning simple interesting and effective. 
      </p>

      <h3> For Queries Contact</h3>
      <dl class="row">
  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9"> founder@packetprep.com</dd>
  <dt class="col-sm-3">Phone</dt>
  <dd class="col-sm-9"> +91 95151 25110</dd>
  <dt class="col-sm-3">website</dt>
  <dd class="col-sm-9"> packetprep.com</dd>
</dl>


    


        

     </div>
   </div>
 </div>

</div>


@endsection

