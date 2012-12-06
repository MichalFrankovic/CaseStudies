<?php

class User_Controller extends Base_Controller {

	public function action_login() {
		
		if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('spendings');
			}
		}
		
		$view = View::make('user.login')
				->with('active', 'login');
		
		$view->email = '';
		
		if (Session::get('login_attemps') > 3) {	//too many login attemps (possible attack?), show captcha
			$view->show_captcha = true;
		}
		
		if (!empty($_POST)) {	//form submited
			
			if (isset($view->show_captcha) && $view->show_captcha == true) {
				if (Input::get('captcha') != Session::get('user_captcha')) {	//check captcha
					$view->error = 'Nesprávne zadaná CAPTCHA';
					return $view;
				}
			}
			
			$view->email = Input::get('email');
			$password = Input::get('password');
			
			$auth = Auth::attempt(array('username' => $view->email, 'password' => $password));	//check email & password
			
			if ($auth) {	//auth succesfull, redirect
				
				Session::put('login_attemps', 0);
				
				if (Auth::user()->fl_aktivna != 'A') {	//inactive account
					$view->error = 'Váš účet bol zablokovaný';
				} elseif (Auth::user()->fl_admin == 'A') {	//admin account
					return Redirect::to('admin');
				} else {	//ordinary account
					return Redirect::to('spendings');
				}
				
			} else {	//auth failed, display error
				
				//count login attemps
				$attemps = Session::get('login_attemps') > 0 ? Session::get('login_attemps') : 0;
				Session::put('login_attemps', $attemps+1);
				
				$view->error = 'Nesprávna e-mailová adresa alebo heslo';
				
			}
			
		}	//end - form submited
		
		return $view;;
		
	}
	
	public function action_logout() {
		
		Auth::logout();	//do the logout
		
		Session::flash('msg', 'Odhlásenie úspešné');
		return Redirect::to('user/login');
		
	}
	
	public function action_register() {
		
		if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('spendings');
			}
		}
		
		$view = View::make('user.register')
				->with('active', 'register');
		
		$view->email = isset($_GET['email']) ? $_GET['email'] : '';
		$errors = array();
		
		if (!empty($_POST)) {
			
			$view->email = Input::get('email');
			$password = Input::get('password');
			$password_repeat = Input::get('password_repeat');
			
			if (!Session::get('captcha_valid')) {
				if (Input::get('captcha') != Session::get('user_captcha')) {	//check captcha
					$view->error = 'Nesprávne zadaná CAPTCHA';
					return $view;
				}
			}
			
			Session::flash('captcha_correct', true);
			
			if (!preg_match('/(.*)@(.*)\.[a-z]+/', $view->email)) {	//check email format
				$errors['email'] = 'Nesprávny formát e-mailovej adresy';
			}
			
			//check email duplicity
			$duplicate = Domacnost::where('t_email_login', '=', $view->email)->first();
			if (!empty($duplicate)) {
				$errors['email'] = 'Táto e-mailová adresa už je zaregistrovaná. ' . Laravel\Html::link('user/recovery?email='.$view->email, 'Zabudli ste heslo?');
			}
			
			if (mb_strlen($password) < 8) {	//check password length
				$errors['password'] = 'Heslo musí byť dlhé aspoň 8 znakov';
			}
			
			if ($password != $password_repeat) {	//check if passwords match
				$errors['password_repeat'] = 'Heslá sa nezhodujú';
			}
			
			if (!empty($errors)) {	//we have errors in form - display
				$view->hide_captcha = Session::get('captcha_correct');
				$view->error = 'Opravte chyby vo formulári';
				$view->errors = $errors;
				return $view;
			}
			
			//save to DB
			{
				$user = new Domacnost;
				$user->t_email_login = $view->email;
				$user->t_heslo = Hash::make($password);
				$user->fl_aktivna = 'A';
				$user->fl_admin = 'N';
				$user->save();
			}
			
			Session::flush('captcha_correct');
			Session::flash('msg', 'Registrácia úspešná, môžete sa prihlásiť');
			
			Redirect::to('user/login');
			
		}
		
		$view->hide_captcha = Session::get('captcha_correct');
		$view->errors = $errors;
		
		return $view;
		
	}
	
	public function action_recovery() {
		
		if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('spendings');
			}
		}
		
		$view = View::make('user.recovery')
		->with('active', false);
		
		$view->email = isset($_GET['email']) ? $_GET['email'] : '';
		$errors = array();
		
		if (isset($_GET['sent'])) {	//display success message
			
			$view->sent = 'Na Vašu e-mailpvú adresu sme odoslali ďalšie pokyny pre zmenu Vášho zabudnutého hesla';

			//temp solution till email is not being send
			{
				$user = Domacnost::find( $_GET['sent'] );
				$view->sent .= '<br /><b>Toto akože prišlo v e-maily:</b> Bla, bla ... '.Laravel\Html::link('user/password?hash='.substr($user->t_recovery_hash, 7), 'Klikni sem pre zmenu hesla').'. Bla, bla, bla.';
			}
			
		} elseif (!empty($_POST)) {	//submited form
				
			$view->email = Input::get('email');
			
			if (Input::get('captcha') != Session::get('user_captcha')) {	//check captcha
				$view->error = 'Nesprávne zadaná CAPTCHA';
				return $view;
			}
				
			//find email
			$user = Domacnost::where('t_email_login', '=', $view->email)->first();
			if (empty($user)) {
				$view->error = 'Zadaná e-mailová adresa nie je zaregistrovaná.' . Laravel\Html::link('user/register?email='.$view->email, 'Vytvorte si nový účet');
				return $view;
			}
				
			//send email
			{
				$user->t_recovery_hash = Hash::make( $user->email . microtime() . uniqid() );
				$user->save();
				
				//TODO: send email
				
				return Redirect::to('user/recovery?sent=' . $user->id);
			}
				
		}
		
		return $view;
		
	}
	
	public function action_password() {
	
		if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('spendings');
			}
		}
		
		$hash = isset($_GET['hash']) ? $_GET['hash'] : '';
		$user = Domacnost::where('t_recovery_hash', 'LIKE', '%'.$hash)->first();
		
		if (empty($user)) {
			
			return View::make('error')
			->with('title', 'Chyba')
			->with('message', 'Neplatná adresa, ' . Laravel\Html::link('user/recovery', 'vygenrujte si nový odkaz'));
			
		} else {
			
			$view = View::make('user.password')
			->with('active', false);
		
			$errors = array();
		
			if (!empty($_POST)) {	//submited form
			
				$password = Input::get('password');
				$password_repeat = Input::get('password_repeat');
				
				if (mb_strlen($password) < 8) {	//check password length
					$errors['password'] = 'Heslo musí byť dlhé aspoň 8 znakov';
				}
				
				if ($password != $password_repeat) {	//check if passwords match
					$errors['password_repeat'] = 'Heslá sa nezhodujú';
				}
				
				if (!empty($errors)) {	//we have errors in form - display
					$view->hide_captcha = Session::get('captcha_correct');
					$view->error = 'Opravte chyby vo formulári';
					$view->errors = $errors;
					return $view;
				}
		
				//change password
				{
					$user->t_recovery_hash = '';
					$user->t_heslo = Hash::make( $password );
					$user->save();
		
					return Redirect::to('user/login');
				}
		
			}
			
		}
	
		return $view;
	
	}
	
	public function action_captcha() {
		
		$image = imagecreate(260, 80);
		
		$bg = imagecolorallocate($image, mt_rand(240, 255), mt_rand(240, 255), mt_rand(240, 255));
		$textcolor = array(
			imagecolorallocate($image, 0, 0, 200),
			imagecolorallocate($image, 0, 150, 0),
			imagecolorallocate($image, 225, 0, 0),
			imagecolorallocate($image, 255, 0, 255),
			imagecolorallocate($image, 255, 160, 0),
			imagecolorallocate($image, 100, 160, 255),
			imagecolorallocate($image, 220, 50, 100),
		);
		$noisecolor = array(
			imagecolorallocate($image, 200, 200, 200),
			imagecolorallocate($image, 180, 220, 150),
			imagecolorallocate($image, 225, 200, 150),
			imagecolorallocate($image, 215, 200, 225),
			imagecolorallocate($image, 255, 210, 230),
			imagecolorallocate($image, 190, 210, 245),
			imagecolorallocate($image, 220, 220, 100),
		);
		
		$chars = 'abcdefghij23456789kmnprstuvwxyz23456789';
		$font = path('base') . 'assets/fonts/SomeLines.ttf';
		
		//noise
		for($i=0; $i<10; $i++) {
			for($j=0; $j<3; $j++) {
				$char = $chars[ mt_rand(0, strlen($chars)-1) ];
				imagettftext($image, 50, 0, -10+mt_rand(0, 15)+$i*30, mt_rand(20, 30)+$j*30, $noisecolor[ mt_rand(0, 6) ], $font, $char);
			}
		}
		
		$text = '';
		
		//captcha
		for($i=0; $i<5; $i++) {
			$text .= $char = $chars[ mt_rand(0, strlen($chars)-1) ];
			$color = $textcolor[ mt_rand(0, 6) ];
			$y = 45+mt_rand(0, 25);
			$x = 10+($i*50);
			imagettftext($image, 50, 0, $x, $y, $color, $font, $char);
			imagettftext($image, 50, 0, $x+1, $y+1, $color, $font, $char);
		}
		
		Session::flash('user_captcha', $text);
		
		imagepng($image);
		imagedestroy($image);
		
		$response = Response::make('', 200, array(
			'Cache-Control' => 'no-cache, must-revalidate',
			'Content-Type' => 'image/png',
			'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT'
		));
		
		return $response;
		
	}

}