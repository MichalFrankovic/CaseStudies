<?php

class Admin_Controller extends Base_Controller {
    
        //--- LISTING ---
	public function action_index() {
		$view = View::make('admin.index')
                ->with('active', 'admin')->with('subactive', 'admin/users');
                $view->domacnosti = DB::table('D_DOMACNOST')->get();
                $view->message = Session::get('message');
                
                return $view;			
	}
        
        //--- PRIDANIE UZIVATELA ---        
	public function action_adduser(){
            $view = View::make('admin.adduser')->with('active', 'admin')->with('subactive', 'admin/adduser');
		
            $view->email = isset($_GET['email']) ? $_GET['email'] : '';
            $view->name = '';
            $errors = array();
            
            if (!empty($_POST)) {
			
                $view->name = Input::get('name');
		$view->email = Input::get('email');			
		$password = Input::get('password');
		$password_repeat = Input::get('password_repeat');
                $status = Input::Get('status');
                
                if (empty($view->name)) {	//nazov domacnosti
			$errors['name'] = 'Zadajte prosím názov domácnosti';
		}
		
		if (!preg_match('/(.*)@(.*)\.[a-z]+/', $view->email)) {
				$errors['email'] = 'Nesprávny formát e-mailovej adresy';
		}	
			
		$duplicate = Domacnost::where('t_email_login', '=', $view->email)->first();
		if (!empty($duplicate)) {
			$errors['email'] = 'Táto e-mailová adresa už je zaregistrovaná. ';
		}
		
		if (mb_strlen($password) < 8) {
			$errors['password'] = 'Heslo musí byť dlhé aspoň 8 znakov';
		}
		
		if ($password != $password_repeat) {
			$errors['password_repeat'] = 'Heslá sa nezhodujú';
		}
                
                if ($status != 'A'){
                    
                    if ($status != 'N') {
                        $errors['status'] = 'Zlá hodnota úrovne domácnosti, spravna hodnota je "A" alebo "N"';
                    }
		}
                    
                
			
		if (!empty($errors)) {
			$view->error = 'Opravte chyby vo formulári';
			$view->errors = $errors;
			return $view;
		}
			
		//DB save 
		{
			$user = new Domacnost;
			$user->t_nazov_domacnosti = $view->name;
			$user->t_email_login = $view->email;
			$user->t_heslo = Hash::make($password);
			$user->fl_aktivna = 'A';
			$user->fl_admin = $status;
			$user->save();
		}
                $view->errors = $errors;
                return Redirect::to('admin')->with('message', 'Domácnosť pridaná');
            }
            return $view;
        }
        
        //--- EDITOVANIE UZIVATELA --- 
        public function action_editUser(){
            $view = View::make('admin.euser')->with('active', 'admin')->with('subactive', 'admin/eUser');
            $id = Input::get('id');
            $view->domacnosti = DB::table('D_DOMACNOST')->where('id', '=', $id)->get();
            
            return $view;		
	}
        
        public function action_editUserDone(){                                   
            $errors = array();          
            
            if (!empty($_POST)) {
                
                $id = ($_POST['id']); 
                $domacnost = ($_POST['domacnost']);
                $email = ($_POST['email']);
                $status = ($_POST['status']);
                $uroven = ($_POST['uroven']);
			
                if (empty($domacnost)) {	//nazov domacnosti
			$errors['name'] = 'Zadajte prosím názov domácnosti';
		}
		
		if (!preg_match('/(.*)@(.*)\.[a-z]+/', $email)) {
				$errors['email'] = 'Nesprávny formát e-mailovej adresy';
		}	
			
		$duplicate = Domacnost::where('t_email_login', '=', $email)->first();
		if (!empty($duplicate)) {
			$errors['email'] = 'Táto e-mailová adresa už je zaregistrovaná. ';
		}
                
                if ($status != 'A'){
                    
                    if ($status != 'N') {
                        $errors['status'] = 'Nesprávna hodnota, spravna hodnota je "A" alebo "N"';
                    }
		}
                
                if ($uroven != 'A'){
                    
                    if ($uroven != 'N') {
                        $errors['uroven'] = 'Nesprávna hodnota, spravna hodnota je "A" alebo "N"';
                    }
		} 
                
			
//		if (!empty($errors)) {
//			$view->error = 'Opravte chyby vo formulári';
//			$view->errors = $errors;
//			return $view;
//		}
			
		//DB save 
		{
                    DB::query("UPDATE D_DOMACNOST SET t_nazov_domacnosti = '$domacnost', t_email_login = '$email', fl_aktivna = '$status', fl_admin = '$uroven' WHERE id = " . $id);
//			$user = new Domacnost;
//			$user->t_nazov_domacnosti = $view->name;
//			$user->t_email_login = $view->email;
//			$user->t_heslo = Hash::make($password);
//			$user->fl_aktivna = 'A';
//			$user->fl_admin = $status;
//			$user->save();
                }
                
                return Redirect::to('admin')->with('message', 'Úpravy uložené');
            }
            
//            $id = ($_POST['id']); 
//            $domacnost = ($_POST['domacnost']);
//            $email = ($_POST['email']);
//            $stav = ($_POST['stav']);
//            $uroven = ($_POST['uroven']);
//            
//            if($domacnost == '' || $email == '' || $stav== '' || $uroven == '') {
//                
//                return Redirect::to('admin')->with('message', 'Našli sa chyby vo vstupe!');                 
//            }
////            $Hheslo = Hash::make($heslo);
//            DB::query("UPDATE D_DOMACNOST SET t_nazov_domacnosti = '$domacnost', t_email_login = '$email', fl_aktivna = '$stav', fl_admin = '$uroven' WHERE id = " . $id);            
//           
//            return Redirect::to('admin')->with('message', 'Úpravy boli uložené');
//            return $view;
	}
        
        //--- ZMENA STAVU UZIVATELA (A/N) --- 
        public function action_disableUser(){
            $id = Input::get('id');
            $objekt = DB::first("SELECT fl_aktivna FROM D_DOMACNOST WHERE id= " . $id); 
           
            if ($objekt->fl_aktivna == 'A'){
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'N' WHERE id = " . $id);
                return Redirect::to('admin')->with('message', 'Užívateľ deaktivovaný');
            }
            else{
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'A' WHERE id = " . $id);
                
                return Redirect::to('admin')->with('message', 'Užívateľ aktivovaný');
            }
            
        }
        
        //--- MAZANIE UZIVATELA --- 
        public function action_deleteUser(){
            $id = Input::get('id');
            try {
                DB::query('DELETE FROM D_DOMACNOST WHERE id = "' . $id  . '"');
                return Redirect::to('admin')->with('message', 'Domácnosť bola vymazaná');
            }
            catch (Exception $e){
                $e->getMessage();
                
                return Redirect::to('admin')->with('message', 'Danú domácnosť nieje možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
            }
            
        }
        
        //--- HROMADNY EDIT ---
        public function action_editMore(){            
            //MAZANIE
            if (isset($_POST['Submit']) && $_POST['Submit'] == 'Zmaž'){
                $id = array();
                if(!empty ($_POST['polozka'])){
                    $id = $_POST['polozka'];
            
                    if (count($id) > 0){
                        foreach ($id as $polozka){
                            try{
                                DB::query('DELETE FROM D_DOMACNOST WHERE id = "' . $polozka  . '"');
                            }
                            catch (Exception $e){
                                $e->getMessage();
                
                                return Redirect::to('admin')->with('message', 'Dané domácnosti nieje možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
                            }
                        }    
                    }
                    return Redirect::to('admin')->with('message', 'Domácnosti vymazané');
                    }
                return Redirect::to('admin')->with('message', 'Nebola zvolená ziadna domácnosť');
            }            
            //AKTIVOVANIE
            if (isset($_POST['Submit']) && $_POST['Submit'] == 'Aktivuj'){
                $id = array();
                if(!empty ($_POST['polozka'])){
                    $id = $_POST['polozka'];
            
                    if (count($id) > 0){
                        foreach ($id as $polozka){
                            DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'A' WHERE id = " . $polozka);
                        }
                    }
                    return Redirect::to('admin')->with('message', 'Domácnosti aktivované');
                }
                return Redirect::to('admin')->with('message', 'Nebola zvolená ziadna domácnosť');
            }            
            //DEAKTIVOVANIE
            if (isset($_POST['Submit']) && $_POST['Submit'] == 'Deaktivuj'){
                $id = array();
                if(!empty ($_POST['polozka'])){
                    $id = $_POST['polozka'];
            
                    if (count($id) > 0){
                        foreach ($id as $polozka){
                            DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'N' WHERE id = " . $polozka);
                        }
                    }
                    return Redirect::to('admin')->with('message', 'Domácnosti deaktivované');
                }
                return Redirect::to('admin')->with('message', 'Nebola zvolená ziadna domácnosť');
            }
        }
}
