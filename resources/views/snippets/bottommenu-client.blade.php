<div class="row d-print-none">
	<div class="col-12 col-md-6">
		Copyright &copy; {{ date('Y') }} | {{ request()->session()->get('client')->name }}
	</div>
	<div class="col-12 col-md-6">
		<div class=" float-md-right text-light" style="color:#495f73">
		  powered by <a href="{{ env('APP_URL')}}" class="text-white">{{domain()}}</a>
		</div>
	</div>
</div>

