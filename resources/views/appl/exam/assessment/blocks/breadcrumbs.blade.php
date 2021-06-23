@if(request()->get('student'))
	<nav class="mb-0" data-html2canvas-ignore="true">
	  <ol class="breadcrumb p-0 " style="background: transparent;">
	    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
	    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
	    <li class="breadcrumb-item">{{$student->name}} - Report </li>
	  </ol>
	</nav>
	<hr>
@else
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb border">
	    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
	    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} - Analysis  </li>
	  </ol>
	</nav>

@endif