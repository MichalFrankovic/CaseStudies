<!doctype html>
<html lang="en">
<head>
	<base href="{{ URL::to('') }}"/>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Vydavkovač</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	@yield('styles')
	{{ HTML::style('assets/css/app.css') }}
	{{ HTML::script('assets/js/jquery.js') }}
	{{-- HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js') --}}
	{{ HTML::script('assets/js/bootstrap.min.js') }}
	{{ HTML::script('assets/js/app.js') }}
	@yield('scripts')
</head>
<body>
	<div class="wrapper">
		<div id="head">
			
			<div class="head">
				
				<h1>{{ HTML::link('', 'Výdavkovač'); }}</h1>
				<small>Systém na správu výdavkov pre jednotlivcov a rodiny</small>
				
				<div class="user">
@if (!Auth::guest())
					Prihlásený ako: <b title="{{ Auth::user()->t_email_login }}">{{ Auth::user()->t_nazov_domacnosti }}</b> | {{ HTML::link('user/logout', 'Odhlásiť'); }}
@endif
				</div>
				
			</div>
			
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
@if (Auth::guest())
						<li{{ isset($active) && $active=='about' ? ' class="active"' : ''; }}>{{ HTML::link('', 'Výdavkovač - čo je to?'); }}</li>
						<li{{ isset($active) && $active=='login' ? ' class="active"' : ''; }}>{{ HTML::link('user/login', 'Prihlásenie'); }}</li>
						<li{{ isset($active) && $active=='register' ? ' class="active"' : ''; }}>{{ HTML::link('user/register', 'Registrácia'); }}</li>
@else
	@if (Auth::user()->fl_admin == 'A')
					    <li{{ isset($active) && $active=='admin' ? ' class="active"' : ''; }}>{{ HTML::link('admin', 'Administrácia'); }}</li>
	@endif
						<li{{ isset($active) && $active=='prijmy' ? ' class="active"' : ''; }}>{{ HTML::link('/incomes', 'Príjmy'); }}</li>
						<li{{ isset($active) && $active=='vydavky' ? ' class="active"' : ''; }}>{{ HTML::link('spendings', 'Výdavky'); }}</li>
						<li{{ isset($active) && $active=='sporenie' ? ' class="active"' : ''; }}>{{ HTML::link('/savings', 'Sporenie'); }}</li>
						<li{{ isset($active) && $active=='nastavenia' ? ' class="active"' : ''; }}>{{ HTML::link('/settings', 'Nastavenia'); }}</li>
@endif
				    </ul>
			    </div>
			</div>
			
		</div>
		<div id="content">

			@yield('content')

		</div><!-- / content -->
		<div class="footer">
			Vytvorené ako projekt na prípadové študie, zimný semester 2012 / 2013.
		</div>
		<pre>{{ $sql_debug }}</pre>
	</div><!-- / wrapper -->
</body>
</html>