<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Výdavkovač</title>
	<LINK REL="icon" HREF="{{ URL::to('../application/obrazky/mesec.ico') }}" TYPE="image/x-icon">
	
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/jquery-ui-1.9.2.custom.css') }}
	{{ HTML::style('assets/css/app.css') }}
	@yield('styles')
	{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}
	{{ HTML::script('assets/js/jquery-ui-1.9.2.custom.js') }}
	@yield('scripts')
	{{ HTML::script('assets/js/app.js') }}

	<style type="">
		.navbar-inner{background-image:url({{ URL::to('../application/obrazky/modra.jpg') }}) !important; border: 1px !important; z-index:5 !important; opacity:10; filter:alpha(opacity=40);}
	</style>

</head>
<body>

	<div id="head">
		<div class="head">
				<img class="logo" src="{{ URL::to('../application/obrazky/money.png') }}" width="100" height="140" />
				
				<h1>{{ HTML::link('', 'VÝDAVKOVAČ'); }}</h1>
				<small>Systém na správu výdavkov pre jednotlivcov a rodiny</small>
				
			@if (!Auth::guest())
				<div class="user btn-group">
					<button class="btn" title="{{ Auth::user()->t_email_login }}"><i class="icon-user"></i> {{ Auth::user()->t_nazov_domacnosti }}</button>
					<button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					    <ul class="dropdown-menu">
					    	<li><a href="{{ URL::to('user/password') }}"><i class="icon-edit"></i> Zmeniť heslo</a></li>
					    	<li><a href="{{ URL::to('user/logout') }}" onclick="if(!confirm('Naozaj odhlásiť?'))return false;"><i class="icon-off"></i> Odhlásiť sa</a></li>
					    </ul>
				</div>
			@endif
		</div>
				
		
	<div class="wrapper">
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
						<li{{ isset($active) && $active=='incomes' ? ' class="active"' : ''; }}>{{ HTML::link('incomes', 'Príjmy'); }}</li>
						<li{{ isset($active) && $active=='vydavky' ? ' class="active"' : ''; }}>{{ HTML::link('spendings', 'Výdavky'); }}</li>
						<li{{ isset($active) && $active=='ciselniky' ? ' class="active"' : ''; }}>{{ HTML::link('ciselniky', 'Číselníky'); }}</li>
						<li{{ isset($active) && $active=='reporting' ? ' class="active"' : ''; }}>{{ HTML::link('reporting', 'Reporting'); }}</li>
<!--
						<li{{ isset($active) && $active=='sporenie' ? ' class="active"' : ''; }}>{{ HTML::link('/savings', 'Sporenie'); }}</li>
						<li{{ isset($active) && $active=='nastavenia' ? ' class="active"' : ''; }}>{{ HTML::link('/settings', 'Nastavenia'); }}</li>
-->
@endif
				    </ul>
			    </div>
			</div>
			
		
		<div id="content">