@extends('layouts.none')
@section('title', 'Eamcet Layout')
@section('content')

<style>
.t_header{
	text-align: center;
/* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#2989d8+36,7db9e8+100,207cca+100 */
background: #2989d8; /* Old browsers */
background: -moz-linear-gradient(top,  #2989d8 36%, #7db9e8 100%, #207cca 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #2989d8 36%,#7db9e8 100%,#207cca 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #2989d8 36%,#7db9e8 100%,#207cca 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2989d8', endColorstr='#207cca',GradientType=0 ); /* IE6-9 */

color:white;
font-size: 20px;
	padding:20px;
}
.t_section_block{
	border:1px solid #cccccc;
	padding:10px 10px 15px;
	margin: 10px 5px;

}
.t_section{
	background: #f2f6fa;
	border:1px solid #d0cccc;
	padding:8px 15px;
	border-radius: 5px;
	margin-bottom:5px;
}
.sections_name{
	margin-top: -20px;
	background: white;
	width:80px;
	padding:0px 10px 5px;
}
</style>
<div class="t_header">
	TCS End test
</div>
<div class="row">
	<div class="col-12 col-md-9">
		<div class="t_section_block">
			<h5 class="sections_name ">Sections</h5>
			<div class="t_section d-inline">
				sample
			</div>
		</div>
	</div>
	<div class="col-12 col-md-3">

	</div>

</div>

@endsection