@include('head')

<h2>Zabudnuté heslo</h2>

@if (isset($sent))
	
	<div class="alert">
		{{ $sent }}
	</div>
	
@else

	{{ Form::open(null, 'POST', array('class' => 'side-by-side')); }}
	
	@if (isset($error) && $error == true)
		<div class="alert alert-error">{{ $error }}</div>
	@endif
	
	<div>
		{{ Form::label('email', 'E-mailová adresa') }}
		{{ Form::text('email', $email) }}
	</div>
	
	@include('user/captcha')
	
	<div class="submit">
		{{ Form::submit('Pokračovať') }}
	</div>
	
	
	{{ Form::close() }}

@endif


@include('foot');
