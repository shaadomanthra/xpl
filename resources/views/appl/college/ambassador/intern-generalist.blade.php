@extends('layouts.nowrap-product')
@section('title', 'Intern Generalist | Internship | PacketPrep')
@section('description', 'A Paid Internship opportunity for packetprep campus ambassadors')
@section('keywords', 'internship, campus ambassador, packetprep')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-trophy"></i> &nbsp;Intern Generalist
			
			</h1>
      <p>A Paid Internship opportunity for campus ambassadors</p>
      <p> 
        <b> Prerequisite :</b> <ul>
            <li>You have to be selected as Campus Ambassador and have a minimum score of 100</li>
            <li> Strong Network among students</li>
            <li> Ability to conduct telephonic interview</li>
          </ul>


		</div>
		<div class="col-12 col-md-4">

       <div class="float-right ">
          <img src="{{ asset('/img/ambassador.jpg')}}" class="w-100 p-3 pt-0"/>    
      </div>
    

  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  
   
	   <div class="bg-white p-4 border mb-3">
      <div class="row">

        <div class="col-12 col-md-6">
          <h1 class="mb-4"> Job Description</h1>
      <ul>
            <li>Promote campus ambassador program to your friends in other colleges </li>
            <li>Conduct telephonic interview to the deserving candidates</li>
            <li>Pick up the best candidates as campus ambassadors </li>
            <li>Stay connected with them over WhatsApp</li>
            <li>Follow up with them for the referral registration</li>

          </ul>
        </div>

        <div class="col-12 col-md-6">
          <h1 class="mb-4"> Benefits</h1>
          <ul>
            <li>You will be paid equivalent to the coins earned</li>
            <li> Top 3 Intern Generalists in level B and above, will be updated to Intern Specialist Position</li>
            <li> Cash Awards for Level B and above
                <ul>
                  <li>Top Performer with Highest Coins : Rs. 2000</li>
                  <li>Runner up with Second Highest Coins : Rs. 1000</li>
                </ul>
            </li>

          </ul>

        </div>

     </div>

   </div>

 

   

   
      <div class="row">
        
        <div class="col-12 col-md-4">
          <div class="bg-white p-4 border ">
          <h1> Understanding Coins</h1>
          <ul>
          	<li>You will earn coins for your referrals as well as the one made by campus ambassadors under you.</li>
            <li>Eg: If you have score 120 then you earn 120 coins, and if an ambassador under you makes score 50 then you get 50 coins.</li>
            <li>One coin is equivalent to One Rupee</li>
          </ul>
        </div>

        </div>

        <div class="col-12 col-md-8">
          <div class="bg-white p-4 border ">
          <h1> Understanding Levels </h1>
          <div class="table-responsive table-bordered">
                  <table class="table  mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Level </th>
                        <th scope="col">Coins </th>
                      </tr>
                    </thead>
                    <tbody class="">
                      <tr>
                        <td>D</td>
                        <td>0 to 299 coins</td>
                      </tr>
                      <tr>
                        <td>C</td>
                        <td>300 to 599 coins</td>
                      </tr>
                      <tr>
                        <td>B</td>
                        <td>600 to 999 coins</td>
                      </tr>
                      <tr>
                        <td>A</td>
                        <td>1000 coins and above</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          
        </div>

        </div>
        
      </div>
 
      
   </div>


     </div>   
</div>

@endsection           