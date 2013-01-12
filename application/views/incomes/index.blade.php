@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif
<h2>Prijmy</h2>

<h2>Filter Prijmov</h2>
{{ Form::open('spendings/filter', 'POST', array('class' => 'side-by-side')); }}

@include('foot');