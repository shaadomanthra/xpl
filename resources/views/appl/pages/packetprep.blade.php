@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">About</li>
      </ol>
    </nav>

<div class="card">

	<div class="card-body">
		<nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> About PacketPrep</a>
     	 </nav>
		<p class="card-text">
			<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/76r-BsW5l7I?rel=0" allowfullscreen></iframe>
			</div>
			<br>

			<dl class="row">
				<dt class="col-sm-3">Packetprep</dt>
				<dd class="col-sm-9">
					It will be the biggest repository of quality concept-wise video lectures hosted on youtube and supported with a synchronized study notes, solved examples, practice questions, then chapter wise as well as full length mock tests.  It will be the one stop platform for students who rely on self study.
					<br><br>
				</dd>

				<dt class="col-sm-3">Vision</dt>
				<dd class="col-sm-9">
					<p>To create a world-class learning platform for self study</p>
				</dd>

				<dt class="col-sm-3">Mission</dt>
				<dd class="col-sm-9">To develop comprehensive content that makes learning simple, interesting and effective.
					<br><br>
					<b>Strategy</b>

					<ul>
						<li>To create CRISS(Crisp, Relevant, Interesting, Simple and Systematic) content for learning </li>
						<li>To build clear, meaningful, and qualitative question bank for exercises and tests </li>
						<li>Informative blogs to inspire young minds</li>
					</ul>
				</dd>

				<dt class="col-sm-3 ">Values</dt>
				<dd class="col-sm-9">
					<ul>
						<li>Passion driven</li>
						<li>Creative work</li>
						<li>Original content</li>
						<li>Empower learners</li>
						<li>Customer support</li>
					</ul>
				</dd>
			</dl>

		</div>
	</div>
	@endsection           