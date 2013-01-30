@include('head')
@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif
<h2>Výdavky </h2>
@include('foot');
