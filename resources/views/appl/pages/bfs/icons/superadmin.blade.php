
<div class="row">
	<div class="col-12 col-md-4">
            <div class="   p-4 rounded mb-3 mr-2" style="background: #fffdf9;border:1px solid #f1e8d6">
                <div class="">
                    <div class=""><i class="fa fa-user"></i> Students</div>
                    <div class="display-2">12</div>
                </div>
            </div>
        
	</div>
	<div class="col-12 col-md-4">
            <div class="   p-4 rounded mb-3 mr-2" style="background: #fffdf9;border:1px solid #f1e8d6">
                <div class="">
                    <div class=""><i class="fa fa-university"></i> Colleges</div>
                    <div class="display-2">5</div>
                </div>
            </div>
        
	</div>
	<div class="col-12 col-md-4 mb-2">
            <div class="   p-4 rounded mb-4 mr-2" style="background: #fffdf9;border:1px solid #f1e8d6">
                <div class="">
                    <div class=""><i class="fa fa-desktop"></i> Trainers</div>
                    <div class="display-2">2</div>
                </div>
            </div>
        
	</div>
</div>

<div class="row">
	<div class="col-6 col-md-3">
		<a href="{{ route('user.list') }}">
            <div class="   p-4 rounded mb-3 mr-2" style="background: #fff9fb;border:1px solid #f1d6e0">
                <div class="">
                    <img src="{{ asset('img/admin/class.png') }}" class="w-100 mb-3" >
                    <div class="text-center">Users</div>
                </div>
            </div>
        </a>
	</div>
	<div class="col-6 col-md-3">
		<a href="{{ route('exam.index') }}">
            <div class=" p-4 rounded mb-3 mr-2" style="background: #fff9fb;border:1px solid #f1d6e0">
                <div class="">
                    <img src="{{ asset('img/admin/online-test.png') }}" class="w-100 mb-3" >
                    <div class="text-center">Tests</div>
                </div>
            </div>
        </a>
	</div>
	<div class="col-6 col-md-3">
		<a href="{{ route('training.index') }}">
            <div class=" p-4 rounded mb-3 mr-2" style="background: #fff9fb;border:1px solid #f1d6e0">
                <div class="">
                    <img src="{{ asset('img/admin/professor.png') }}" class="w-100 mb-3" >
                    <div class="text-center">Trainings</div>
                </div>
            </div>
        </a>
	</div>
	<div class="col-6 col-md-3">
		<a href="{{ route('training.index') }}">
            <div class="p-4 rounded mb-3 mr-2" style="background: #fff9fb;border:1px solid #f1d6e0">
                <div class="">
                    <img src="{{ asset('img/admin/assignment.png') }}" class="w-100 mb-3" >
                    <div class="text-center">Surveys</div>
                </div>
            </div>
        </a>
	</div>

</div>	