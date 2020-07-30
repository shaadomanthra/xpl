@extends('layouts.app')
@section('content')
<style>
.text-silver{ color:#eee; }
</style>
  @include('flash::message') 
  <div class="card">
    <div class="card-body">
      <h1 class="mb-2">Edit Profile </h1>
      <div class="progress mb-4" style="height:5px;">
  <div class="progress-bar" role="progressbar" style="width: {{$user->profile_complete()}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-step="{{$user->profile_complete_step()}}" data-percent="{{$user->profile_complete()}}"></div>
</div>
       <form method="post" action="{{route('profile.update','@'.$user->username)}}" enctype="multipart/form-data">
    <div class="mb-3">
      <h3 class=>Personal Details</h3>
    
      <div class="row">
        

        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Name 
               <i class="fa fa-check-circle name @if($user->name) text-success @else text-secondary @endif"></i> 
            </label>
            <input type="text" class="form-control" name="name"  value="{{ $user->name }}">
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group">
          <label for="formGroupExampleInput ">Aadhar Number <i class="fa fa-check-circle aadhar @if($user->aadhar) text-success @else text-silver @endif"></i> </label>
          <input type="text" class="form-control" name="aadhar"  value="@if($user->aadhar){{  $user->aadhar }} @endif" >
        </div>
         </div>

      </div>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
          <label for="formGroupExampleInput ">Phone <i class="fa fa-check-circle phone @if($user->phone) text-success @else text-silver @endif"></i></label>
          <input type="text" class="form-control" name="phone"  value="@if($user->phone){{  $user->phone }} @endif" disabled>
        </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Email <i class="fa fa-check-circle email @if($user->email) text-success @else text-silver @endif"></i></label>
        <input type="text" class="form-control" name="email"  value="{{ $user->email }}" disabled>
      </div>
         </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Username <i class="fa fa-check-circle username @if($user->username) text-success @else text-silver @endif"></i></label>
            <input type="text" class="form-control" name="username"  value="{{ $user->username }}" disabled>
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Profile Image <i class="fa fa-check-circle file_ @if($user->getImage()) text-success @else text-silver @endif"></i></label>
            <input type="file" class="form-control" name="file_" id="formGroupExampleInput" >
         </div>
      </div>
      </div>

       <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Current City <i class="fa fa-check-circle current_city @if(trim($user->current_city)) text-success @else text-silver @endif"></i></label>
        <input type="text" class="form-control" name="current_city"  placeholder="Enter your city name" value="{{ $user->current_city }}">
      </div>
        </div>
         <div class="col-12 col-md-6">
            

       <div class="form-group">
        <label for="formGroupExampleInput ">Hometown <i class="fa fa-check-circle hometown @if($user->hometown) text-success @else text-silver @endif"></i></label>
        <input type="text" class="form-control" name="hometown"  placeholder="Enter your hometown name" value="{{ $user->hometown }}">
      </div>
         </div>
      </div>

       <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Gender <i class="fa fa-check-circle gender @if($user->gender) text-success @else text-silver @endif"></i></label>
            <select class="form-control" name="gender">
             
              <option value="male"  @if(isset($user_details)) @if($user->gender=='male')  selected @endif  @endif>Male</option>
              <option value="female"  @if(isset($user_details)) @if($user->gender=='female')  selected @endif  @endif>Female</option>
              <option value="transgender"  @if(isset($user_details)) @if($user->gender=='transgender')  selected @endif  @endif>Transgender</option>
                     
            </select>
          </div>
        </div>
         
         <div class="col-12 col-md-6">
            <div class="form-group ">
            <label for="formGroupExampleInput ">Date of Birth (DD-MM-YYYY) <i class="fa fa-check-circle dob @if($user->dob) text-success @else text-silver @endif"></i></label><br>
            <input type="text" minlength="1" class="form-control" name="dob" id="formGroupExampleInput" placeholder="Enter your date of birth (eg: 25-09-2001)" 
            value="{{ $user->dob }}">
          </div>
         </div>
      </div>

      
    </div>

      
    <div class="mb-3">
      <h3 class="border p-3 bg-light rounded mt-2">Education Details</h3>

     

      <div class="row">
        <div class="col-12 col-md-6">

          @if(isset($colleges))
      <div class="form-group">
        <label for="formGroupExampleInput ">College <i class="fa fa-check-circle college_id @if($user->college_id) text-success @else text-silver @endif"></i></label>
        <select class="form-control" name="college_id">
          @foreach($colleges as $c)
          <option value="{{$c->id}}" @if(isset($user)) @if($user->colleges->first()) @if($c->id == $user->colleges->first()->id ) selected @endif @endif @endif >{{ $c->name }}</option>
          
          @endforeach         
        </select>
      </div>
      @endif
        </div>

        <div class="col-12 col-md-6">
          <div class="form-group">
          <label for="formGroupExampleInput ">College Full Roll Number <i class="fa fa-check-circle roll_number @if($user->roll_number) text-success @else text-silver @endif"></i> </label>
          <input type="text" class="form-control" name="roll_number"  value="@if($user->roll_number){{  $user->roll_number }} @endif" >
        </div>
         </div>

        </div>
        <div class="row">
         <div class="col-12 col-md-6">
            @if(isset($branches))
      <div class="form-group ">
        <label for="formGroupExampleInput ">Branch <i class="fa fa-check-circle branch_id @if($user->branch_id) text-success @else text-silver @endif"></i></label><br>
        <select class="form-control" name="branch_id">
          @foreach($branches as $b)
          <option value="{{$b->id}}" @if(isset($user)) @if($user->branches->first()) @if($b->id == $user->branches->first()->id ) selected @endif @endif @endif >{{ $b->name }}</option>
          @endforeach         
        </select>
      </div>
      @endif
         </div>

         <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Year of Passing <i class="fa fa-check-circle year_of_passing @if($user->year_of_passing) text-success @else text-silver @endif"></i></label>

            <select class="form-control" name="year_of_passing">
            <option value="0" >None</option>
            @for($y=2015;$y<2025;$y++)
            <option value="{{$y}}" @if(isset($user)) @if($user->year_of_passing == $y) selected @endif @endif >{{ $y }}</option>
            @endfor        
            </select>
          </div>
        </div>
      </div>

     

     
    </div>

    <div class="mb-3">

      <div class="alert alert-warning alert-important">The academic percentage has to be between 30 to 100. If your university awards CPGA, then convert it to percentage and then enter. <br><b>Eg:</b> For 7.2 CGPA, you can enter 72.</div>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group ">
            <label for="formGroupExampleInput ">Class 10th Percentage <i class="fa fa-check-circle tenth @if($user->tenth) text-success @else text-silver @endif"></i></label><br>
            <input type="number" minlength="1" class="form-control" name="tenth" id="formGroupExampleInput" value="{{ $user->tenth }}" min="30" max="100">
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group ">
            <label for="formGroupExampleInput ">Class 12th Percentage  <i class="fa fa-check-circle twelveth @if($user->twelveth) text-success @else text-silver @endif"></i></label><br>
            <input type="number" minlength="1" class="form-control" name="twelveth" id="formGroupExampleInput" value="{{ $user->twelveth }}" min="30" max="100">
          </div>
         </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group ">
            <label for="formGroupExampleInput ">BTech Percentage  <i class="fa fa-check-circle bachelors @if($user->bachelors) text-success @else text-silver @endif"></i></label><br>
            <input type="number" minlength="1" class="form-control" name="graduation" id="formGroupExampleInput" value="{{ $user->bachelors }}" min="30" max="100">
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group ">
            <label for="formGroupExampleInput ">Masters Percentage (optional)</label><br>
            <input type="number" minlength="1" class="form-control" name="masters" id="formGroupExampleInput" value="{{ $user->masters }}" min="30" max="100">
          </div>
         </div>
      </div>
     
    </div>

     <div class="">

      

          <div class="form-group border p-3">
        <label for="formGroupExampleInput "><h3>Trained in (Optional)</h3></label><br>
        <div class="row">
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="18" @if($user->metrics->contains(18)) checked @endif> C   <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="19" @if($user->metrics->contains(19)) checked @endif> C++  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="20" @if($user->metrics->contains(20)) checked @endif> JAVA  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="21" @if($user->metrics->contains(21)) checked @endif> DotNET  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="22" @if($user->metrics->contains(22)) checked @endif> Python  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="23" @if($user->metrics->contains(23)) checked @endif> SQL <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="24" @if($user->metrics->contains(24)) checked @endif> PHP <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="25" @if($user->metrics->contains(25)) checked @endif> Networking <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="26" @if($user->metrics->contains(26)) checked @endif> AutoCAD <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="27" @if($user->metrics->contains(27)) checked @endif> Catia <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="28" @if($user->metrics->contains(28)) checked @endif> Ansys <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="29" @if($user->metrics->contains(29)) checked @endif> Solidworks <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="30" @if($user->metrics->contains(30)) checked @endif> Matlab <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="31" @if($user->metrics->contains(31)) checked @endif> Arduino <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="32" @if($user->metrics->contains([32])) checked @endif> Raspberry Pi <br>
          </div>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary btn-profile-save">Save</button>
    </div>


      <div class="form-group">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="client_slug" value="@if(isset($user->client_slug)) {{$user->client_slug}} @endif">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
      </div>
      
    </form>
    </div>
  </div>


@endsection