@extends('layouts.nowrap-product')
@section('title', 'Ambassador Onboarding | PacketPrep')
@section('description', 'Details on the task to be completed by the ambassador')
@section('keywords', 'college,packetprep,campus connect,campus ambassador')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-user" ></i> &nbsp; Ambassadors Onboarding Instructions 
			</h1>
      <a href="{{ route('ambassador.connect') }}"><i class="fa fa-angle-double-left"></i> return to campus connect</a>

		</div>
		<div class="col-12 col-md-4">
      
  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  
      <div class="row">
     
        <div class="col-12 col-md-12">
            

            <div class="card mb-3">
              <div class="card-body " >
                <h2> Welcome Message</h2>
                <div class="row mb-5">
                    <div class="col-12 col-md-8">
                      <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
                          <iframe src="//player.vimeo.com/video/317457163" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                      <p class="border bg-light p-3 mb-3"> This video gives a brief introduction about packetprep, its mission, details on 100 day Target TCS program, the role of campus ambassador and finally reasons to register. </p>
                    </div>
                </div>
                <h2> About Campus Connect</h2>
                <div class="row mb-5 ">
                    <div class="col-12 col-md-8">
                        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
                          <iframe src="//player.vimeo.com/video/317457145" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">
                        <p class="bg-light border p-3"> This video is an introduction to campus connect, score, levels, appreciation and the most important one 'Referral Link'</p>
                    </div>
                </div>
                <h2> About Scores - Levels and Appreciation</h2>
                <div class="table-responsive mb-5">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">Score</th>
                <th scope="col">Level</th>
                <th scope="col">Appreciation</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> 100+ </td>
                <td> <div class="text-primary"><i class ="fa fa-trophy"></i> Platinum</div></td>
                <td> Appreciation Letter  & <br>
                    Internship Certificate & <br>
                    Name inclusion in the website
                </td>
              </tr>
               <tr>
                <td> 80 to 99</td>
                <td> <div class="text-success"><i class ="fa fa-graduation-cap"></i> Gold</div> </td>
                <td> Appreciation Letter  & <br>
                    Internship Certificate</td>
              </tr> 
              <tr>
                <td> 50 to 79</td>
                <td> <div class="text-secondary"><i class ="fa fa-shield"></i> Silver</div> </td>
                <td> Appreciation Letter </td>
              </tr> 
              <tr>
                <td> less than 50</td>
                <td> - </td>
                <td> - </td>
              </tr>  
              
             
              
            </tbody>
          </table>
        </div>

            <h2 class="mb-3"> Message to Share with friends</h2>
            <p class="border p-3 mb-3"><b> Video Link</b><br>
              <a href="https://youtu.be/5PvwhtYAdgk">https://youtu.be/5PvwhtYAdgk</a>
            </p>

            <p class="border p-3"><b>Message</b><br>
              Hi friends,<br>
              Great Opportunity for all of us to get prepared for TCS exam.<br><br>
              PacketPrep, a training company is starting a free online course from 15th May. Also they are giving 3 month access to their high quality video lectures and practice questions.<br><br>
              You can use the following link to register<br>
              <a href="{{ route('student.eregister') }}?code={{\auth::user()->username}}">{{ route('student.eregister') }}?code={{ \auth::user()->username }}</a>
            </p>

              </div>
            </div>
        </div>
      </div>
     </div>   
</div>

@endsection           