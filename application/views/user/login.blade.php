@include('head')

<h2>Prihlásenie</h2>

{{ Form::open(null, 'POST', array('class' => 'side-by-side')); }}

@if (isset($error) && $error == true)
	<div class="alert alert-error">{{ $error }}</div>
@endif

@if (Session::get('msg') != '')
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{ Session::get('msg') }}
	</div>
@endif

<div class="alert alert-info"><b>Prihlasovacie udaje:</b> domacnost1@gmail.com / domacnost</div>

<div>
	{{ Form::label('email', 'E-mailová adresa') }}
	{{ Form::text('email', $email) }}
</div>

<div>
	{{ Form::label('password', 'Heslo') }}
	{{ Form::password('password') }}
</div>

<?php /*
<div>
	{{ Form::label('remember', 'Zapamätať') }}
	{{ Form::checkbox('remember', '1') }}
</div>
*/ ?>

@if (isset($show_captcha) && $show_captcha == true)
	@include('user/captcha')
@endif

<div class="submit">
	{{ Form::submit('Prihlásiť') }}
</div>


{{ Form::close() }}


{{ Html::link('user/recovery', 'Zabudli ste heslo?') }}

@include('foot');
