@include('head')
@include('admin/submenu')

{{ Form::open(null, 'POST', array('class' => 'side-by-side')); }}

@if (isset($error) && $error == true)
	<div class="alert alert-error">{{ $error }}</div>
@endif

<div {{ isset($errors->name) || (is_array($errors) && isset($errors['name'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('name', 'Názov domácnosti', array('class' => 'control-label')) }}
	{{ Form::text('name', $name) }}
	{{ isset($errors->name) || (is_array($errors) && isset($errors['name'])) ? '<span class="help-inline">'.$errors['name'].'</span>' : '' }}
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

<div {{ isset($errors->status) || (is_array($errors) && isset($errors['status'])) ? ' class="control-group error"' : '' }}>
	{{ Form::label('status', 'Admin práva', array('class' => 'control-label')) }}
	{{ Form::checkbox('status') }}
	{{ isset($errors->status) || (is_array($errors) && isset($errors['status'])) ? '<span class="help-inline">'.$errors['status'].'</span>' : '' }}
</div>

<div class="submit">
	{{ Form::submit('Pridať') }}
<!--	{{ Form::reset('Návrat', array('onclick' => 'document.location.href=\'' . URL::home() . '\';')); }}-->
</div>

{{ Form::close() }}


<!--<h2>Pridanie užívateľa (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="addUserDone">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Názov domácnosti*</th>
            <th>E-mail*</th>
            <th>Heslo*</th>
            <th>Zopakovať heslo*</th>
            <th>Úroveň účtu*</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>            
            <td><div class="input-append">
                <input name="name" class="span2" type="text" value="" placeholder="Novákovci" />
            </div></td>
            
            <td><div class="input-append">
                <input name="email" class="span2" type="text" value="" placeholder="novak@mail.com"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="password" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="password-repeat" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="uroven" class="span2" type="text" value="" placeholder="A/N"/>
            </div></td>
            
            <td><input type="submit" name="Submit" value="Pridaj používateľa"/></td>
            
        </tr>
        </tbody>
    </table>
</form>-->

@include('foot')
