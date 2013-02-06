<?php

class User_Controller extends Base_Controller {

	public function action_login() {
		
		if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('home');
			}
		}
		
		$view = View::make('user.login')
				->with('active', 'login');
		
		$view->email = '';
		
		//count login attemps
		{
			if (!empty($_POST)) {
				$attemps = Session::get('login_attemps') > 0 ? Session::get('login_attemps') : 0;
				Session::put('login_attemps', $attemps+1);
			}
						
			if (Session::get('login_attemps') >= 3) {	//too many login attemps (possible attack?), show captcha
				$view->show_captcha = true;
			}
		}
		
		if (!empty($_POST)) {	//form submited
			
			//var_dump($view->show_captcha); exit;
			
			if (isset($view->show_captcha) && $view->show_captcha == true) {
				if (mb_strtolower(Input::get('captcha')) != mb_strtolower(Session::get('user_captcha'))) {	//check captcha
					$view->error = 'Nesprávne zadaná CAPTCHA';
					return $view;
				}
			}
			
			$view->email = Input::get('email');
			$remember = Input::get('remember');
			$password = Input::get('password');
			
			$auth = Auth::attempt(array('username' => $view->email, 'password' => $password));	//check email & password
			
			if ($auth) {	//auth succesfull, redirect
				
				Session::put('login_attemps', 0);
				
				if (Auth::user()->fl_aktivna != 'A') {	//inactive account
					
					$view->error = 'Váš účet bol zablokovaný';
					
				} else {
					
					/*if (isset($remember) && $remember == 1) {
						Laravel\Cookie::put('remember_login', md5(Auth::user()->id . Auth::user()->t_email_login . Auth::user()->t_heslo), 3600*24*30);
					}*/
					
					if (Auth::user()->fl_admin == 'A') {	//admin account
						return Redirect::to('admin');
					} else {	//ordinary account
						return Redirect::to('home');
					}
					
				}
				
			} else {	//auth failed, display error
				
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
		$view->name = '';
		$view->person_name = '';
		$view->person_surname = '';
		$errors = array();
		
		if (!empty($_POST)) {
			
			$view->email = Input::get('email');
			$view->name = Input::get('name');
			$view->person_name = Input::get('person_name');
			$view->person_surname = Input::get('person_surname');
			$password = Input::get('password');
			$password_repeat = Input::get('password_repeat');
			
			if (!Session::get('captcha_valid')) {
				if (mb_strtolower(Input::get('captcha')) != mb_strtolower(Session::get('user_captcha'))) {	//check captcha
					$view->error = 'Nesprávne zadaná CAPTCHA';
					return $view;
				}
			}
			
			Session::flash('captcha_correct', true);
			
			if (!preg_match('/(.*)@(.*)\.[a-z]+/', $view->email)) {	//check email format
				$errors['email'] = 'Nesprávny formát e-mailovej adresy';
			}
			
			if (empty($view->name)) {	//nazov domacnosti
				$errors['name'] = 'Zadajte prosím názov domácnosti';
			}
			
			if (empty($view->person_name)) {	//nazov domacnosti
				$errors['person_name'] = 'Zadajte prosím Vaše meno';
			}
			
			if (empty($view->person_surname)) {	//nazov domacnosti
				$errors['person_surname'] = 'Zadajte prosím Vaše priezvisko';
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
				$user->t_nazov_domacnosti = $view->name;
				$user->t_email_login = $view->email;
				$user->t_heslo = Hash::make($password);
				$user->fl_aktivna = 'A';
				$user->fl_admin = 'N';
				$user->save();
				
				$person = new Osoba;
				$person->id_domacnost = $user->id;
				$person->t_meno_osoby = $view->person_name;
				$person->t_priezvisko_osoby = $view->person_surname;
				$person->fl_aktivna = 'A';
				$person->fl_domacnost = 'A';
				$person->save();
				
			}
			
			
			$this->send_mail($user->t_email_login, 'Výdavkovač - nová registrácia', "Dobrý deň " . $user->t_nazov_domacnosti . ",
			
gratulujeme Vám k registrácii v systéme Výdavkovač.

Prihlásiť sa môžete na nasledovnej adrese:
" . Laravel\URL::to('user/login') . "

Pre prihlásenie použite prosím Vášu e-mailovú adresu " . $user->t_email_login . " a heslo zadaná pri registrácii.
			
V prípade zabudnutého hesla si ho môžte obnoviť tu:
" . Laravel\URL::to('user/recovery') . "
			
--
S pozdravom
Tím Výdavkovač
");
			
			Session::flush('captcha_correct');
			Session::flash('msg', 'Registrácia úspešná, môžete sa prihlásiť');
			
			return Redirect::to('user/login');
			
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
			
			$view->sent = 'Na Vašu e-mailovú adresu sme odoslali ďalšie pokyny pre zmenu Vášho zabudnutého hesla. Skontrolujte si prosím aj priečinok s nevyžiadanou poštou (spam).';
			
		} elseif (!empty($_POST)) {	//submited form
				
			$view->email = Input::get('email');
			
			if (mb_strtolower(Input::get('captcha')) != mb_strtolower(Session::get('user_captcha'))) {	//check captcha
				$view->error = 'Nesprávne zadaná CAPTCHA';
				return $view;
			}
				
			//find email
			$user = Domacnost::where('t_email_login', '=', $view->email)->first();
			if (empty($user)) {
				$view->error = 'Zadaná e-mailová adresa nie je zaregistrovaná. ' . Laravel\Html::link('user/register?email='.$view->email, 'Vytvorte si nový účet');
				return $view;
			}
				
			//send email
			{
				$user->t_recovery_hash = Hash::make( $user->email . microtime() . uniqid() );
				$user->save();
				
				
				$sent = $this->send_mail($user->t_email_login, 'Výdavkovač - zabudnuté heslo', "Dobrý deň " . $user->t_nazov_domacnosti . ",

na základe Vašej žiadosti o zmenu zabudnutého hesla do webovej aplikácie Výdavkovač Vám posielame odkaz na ktorom si môžete zmeniť Vaše heslo:

" . Laravel\URL::to('user/password?hash='.substr($user->t_recovery_hash, 7)) . "

Ak ste nežiadali o zmenu hesla, ignorujte prosím túto správu.

-- 
S pozdravom
Tím Výdavkovač
");
				if ($sent) {
					return Redirect::to('user/recovery?sent=' . $user->id);
				} else {
					$view->error = 'Bohužiaľ z technických príčin sa nám nepodarilo odoslať e-mail s pokynmi pre zmenu hesla.';
				}
				
			}
				
		}
		
		return $view;
		
	}
	
	public function action_password() {
	
		/*if (!Auth::guest()) {
			if (Auth::user()->fl_admin == 'A') {	//admin account
				return Redirect::to('admin');
			} else {	//ordinary account
				return Redirect::to('spendings');
			}
		}*/
		
		$hash = isset($_GET['hash']) ? $_GET['hash'] : ( isset($_POST['hash']) ? $_POST['hash'] : '' );
		
		if (Auth::guest()) {
			
			if (!empty($hash)) {
				$user = Domacnost::where('t_recovery_hash', 'LIKE', '%'.$hash)->first();
				$recovery = true;
			}
			
		} else {
			
			$hash = true;
			$user = Domacnost::where('id', '=', Auth::user()->id)->first();
			$recovery = false;
			
		}
		
		if (!isset($user) || empty($user)) {
			
			return View::make('error')
			->with('title', 'Chyba')
			->with('message', 'Neplatná adresa, ' . Laravel\Html::link('user/recovery', 'vygenrujte si nový odkaz na zmenu hesla'));
			
		} else {
			
			$view = View::make('user.password')
			->with('active', false)
			->with('recovery', $recovery)
			->with('hash', $hash);
		
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
					
		
					if (Auth::guest()) {
						Session::flash('msg', 'Vaše heslo bolo úspešne zmenené. Môžete sa prihlásiť s novým heslom.');
						return Redirect::to('user/login');
					} else {
						Session::flash('msg', 'Vaše heslo bolo úspešne zmenené.');
						return Redirect::to('/');
					}
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
	
	private function send_mail($to, $body) {
		
		$headers = 	"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=utf-8\r\n".
					"Content-Transfer-Encoding: 8bit\r\n";
		
		return mail($to, $body, $headers);
		
	}

}