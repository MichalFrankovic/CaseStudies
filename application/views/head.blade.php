<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Laravel: A Framework For Web Artisans</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/app.css') }}
</head>
<body>
	<div class="wrapper">
		<div id="head">
			
			<div class="head">
				
				<h1>{{ HTML::link('', 'Výdavkovač'); }}</h1>
				<small>Systém na správu výdavkov pre jednotlivcov a rodiny</small>
				
				<div class="user">
					Prihlásený ako: <b>user1</b> | <a href="#">Odhlásiť</a>
				</div>
				
			</div>
			
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
					    <li<?php echo $active=='admin' ? ' class="active"' : ''; ?>>{{ HTML::link('admin', 'Administrácia'); }}</li>
						<li<?php echo $active=='prijmy' ? ' class="active"' : ''; ?>>{{ HTML::link('/incomes', 'Príjmy'); }}</li>
						<li<?php echo $active=='vydavky' ? ' class="active"' : ''; ?>>{{ HTML::link('/spendings', 'Výdavky'); }}</li>
						<li<?php echo $active=='sporenie' ? ' class="active"' : ''; ?>>{{ HTML::link('/savings', 'Sporenie'); }}</li>
						<li<?php echo $active=='nastavenia' ? ' class="active"' : ''; ?>>{{ HTML::link('/settings', 'Nastavenia'); }}</li>
				    </ul>
			    </div>
			</div>
			
		</div>
		<div id="content">
