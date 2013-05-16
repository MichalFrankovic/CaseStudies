@include('head')

@if (Session::get('msg') != '')
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{ Session::get('msg') }}
	</div>
@endif


<h2 style="color:white;"> 	Výdavkovač - čo je to? </h2>

<p style="color:white;">	Príjmovo výdavkový systém pre domácnosti </p>


<style type="text/css">
	body { 
	  background: url({{URL::to('../application/obrazky/obr.jpg')}}) no-repeat fixed 100% 100%; 
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	  position:absolute; width:100%;
	}

	.navbar-inner {background: transparent !important;}

	.logo{opacity: 0;}

	.wrapper{background: transparent !important;}

	small{color: white !important;}

	a{color: white;}
	a:hover{color: white;}

</style>

{{ HTML::script('assets/js/jquery.js') }}

<script type="text/javascript">

$(document).ready(function(){

	$('#head').slideDown('fast');
	$('#content').slideDown('slow');

});

</script>