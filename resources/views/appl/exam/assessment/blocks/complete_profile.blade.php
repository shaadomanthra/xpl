<div class="mt-4 alert alert-warning alert-important">
	<h3><i class="fa fa-user"></i> Incomplete Profile</h3> 
	<p>Your profile is not updated. Kindly complete the profile to access this test. Also, note that the profile information is shared 
	with the HR team, and any discrepancies in the information submitted will lead to cancellation of the application.</p>
	
	<a href="{{route('profile.edit','@'.auth::user()->username)}}?complete_profile=1&redirect={{url()->current()}}" >
				       	<button class="btn btn-lg btn-outline-primary  btn-sm" > Edit Profile </button>
		</a>
</div>