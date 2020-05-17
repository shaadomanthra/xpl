<div class="row">
	<div class="col-12 col-md-6">
		Copyright &copy; {{ date('Y') }} | {{ request()->session()->get('client')->name }}
	</div>
	<div class="col-12 col-md-6">
		<div class=" float-md-right text-light" style="color:#495f73">
		  powered by <a href="https://{{get_tld(request()->server("HTTP_HOST"))}}" class="text-white">{{get_tld(request()->server("HTTP_HOST"))}}</a>
		</div>
	</div>
</div>

