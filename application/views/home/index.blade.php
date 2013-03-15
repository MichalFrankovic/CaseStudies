@include('head')

@if (Session::get('msg') != '')
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{ Session::get('msg') }}
	</div>
@endif

<h2>Výdavkovač - čo je to?</h2>

<p>Príjmovo výdavkový systém pre domácnosti</p>


@include('foot')
