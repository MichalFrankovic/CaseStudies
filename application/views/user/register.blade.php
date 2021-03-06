@include('head')

<h2>Registrácia</h2>

{{ Form::open(null, 'POST', array('class' => 'side-by-side')); }}

@if (isset($error) && $error == true)
	<div class="alert alert-error">{{ $error }}</div>
@endif

<div {{ isset($errors->name) || (is_array($errors) && isset($errors['name'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('name', 'Názov domácnosti', array('class' => 'control-label')) }}
	{{ Form::text('name', $name) }}
	{{ isset($errors->name) || (is_array($errors) && isset($errors['name'])) ? '<span class="help-inline">'.$errors['name'].'</span>' : '' }}
</div>

<div {{ isset($errors->person_name) || (is_array($errors) && isset($errors['person_name'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('person_name', 'Meno', array('class' => 'control-label')) }}
	{{ Form::text('person_name', $person_name) }}
	{{ isset($errors->person_name) || (is_array($errors) && isset($errors['person_name'])) ? '<span class="help-inline">'.$errors['person_name'].'</span>' : '' }}
</div>

<div {{ isset($errors->person_surname) || (is_array($errors) && isset($errors['person_surname'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('person_surname', 'Priezvisko', array('class' => 'control-label')) }}
	{{ Form::text('person_surname', $person_surname) }}
	{{ isset($errors->person_surname) || (is_array($errors) && isset($errors['person_surname'])) ? '<span class="help-inline">'.$errors['person_surname'].'</span>' : '' }}
</div>

<div {{ isset($errors->email) || (is_array($errors) && isset($errors['email'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('email', 'E-mailová adresa', array('class' => 'control-label')) }}
	{{ Form::text('email', $email) }}
	{{ isset($errors->email) || (is_array($errors) && isset($errors['email'])) ? '<span class="help-inline">'.$errors['email'].'</span>' : '' }}
</div>

<div {{ isset($errors->password) || (is_array($errors) && isset($errors['password'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('password', 'Heslo', array('class' => 'control-label')) }}
	{{ Form::password('password') }}
	{{ isset($errors->password) || (is_array($errors) && isset($errors['password'])) ? '<span class="help-inline">'.$errors['password'].'</span>' : '' }}
</div>

<div {{ isset($errors->password_repeat) || (is_array($errors) && isset($errors['password_repeat'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('password_repeat', 'Potvrď heslo', array('class' => 'control-label')) }}
	{{ Form::password('password_repeat') }}
	{{ isset($errors->password_repeat) || (is_array($errors) && isset($errors['password_repeat'])) ? '<span class="help-inline">'.$errors['password_repeat'].'</span>' : '' }}
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
