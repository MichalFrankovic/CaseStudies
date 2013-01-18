@include('head')

<h2>Registrácia</h2>

{{ Form::open(null, 'POST', array('class' => 'side-by-side')); }}

@if (isset($error) && $error == true)
	<div class="alert alert-error">{{ $error }}</div>
@endif

<div {{ isset($errors->name) ? ' class="control-group error"' : '' }}>
	{{ Form::label('name', 'Názov domácnosti', array('class' => 'control-label')) }}
	{{ Form::text('name', $name) }}
	{{ isset($errors->name) ? '<span class="help-inline">'.$errors['name'].'</span>' : '' }}
</div>

<div {{ isset($errors->email) ? ' class="control-group error"' : '' }}>
	{{ Form::label('email', 'E-mailová adresa', array('class' => 'control-label')) }}
	{{ Form::text('email', $email) }}
	{{ isset($errors->email) ? '<span class="help-inline">'.$errors['email'].'</span>' : '' }}
</div>

<div {{ isset($errors->password) ? ' class="control-group error"' : '' }}>
	{{ Form::label('password', 'Heslo', array('class' => 'control-label')) }}
	{{ Form::password('password') }}
	{{ isset($errors->password) ? '<span class="help-inline">'.$errors['password'].'</span>' : '' }}
</div>

<div {{ isset($errors->password_repeat) ? ' class="control-group error"' : '' }}>
	{{ Form::label('password_repeat', 'Potvrď heslo', array('class' => 'control-label')) }}
	{{ Form::password('password_repeat') }}
	{{ isset($errors->password_repeat) ? '<span class="help-inline">'.$errors['password_repeat'].'</span>' : '' }}
</div>

@if (isset($hide_captcha) && $hide_captcha == true)
	<div class="alert alert-info">CAPTCHA kód si už raz správne opísal, tak na čo ho opisovať znova, že?</div>
@else
	@include('user/captcha')
@endif

<div class="submit">
	{{ Form::submit('Registrovať') }}
	{{ Form::reset('Zrušiť', array('onclick' => 'document.location.href=\'' . URL::home() . '\';')); }}
</div>

{{ Form::close() }}


@include('foot')
