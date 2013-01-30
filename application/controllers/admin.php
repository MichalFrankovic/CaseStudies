<?php

class Admin_Controller extends Base_Controller {

        
	public function action_index(){
        return Redirect::to('admin/list');
	}
	
	//--- LISTING ---
	public function action_list() {
	    $view = View::make('admin.index')->with('active', 'admin')->with('subactive', 'admin/users');
	    $view->domacnosti = DB::table('D_DOMACNOST')->get();
	    $view->message = Session::get('message');
	    
            return $view;			
	}
	// --- FILTER ---
	public function action_filter(){
	    $view = View::make('admin.index')->with('active', 'admin')->with('subactive', 'admin/users');
	    
	    $vyraz = Input::get('vyraz');
	    $view->domacnosti = DB::query('SELECT * FROM D_DOMACNOST WHERE t_email_login LIKE "%' . $vyraz . '%" OR t_nazov_domacnosti LIKE "%' . $vyraz . '%"');
	    
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
//                $status = Input::Get('status');
                
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
		
		if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)){
		    $errors['password'] = 'Heslo musí obsahovať písmena aj čísla';
		} 
		if (mb_strlen($password) < 8) {
			$errors['password'] = 'Heslo musí byť dlhé aspoň 8 znakov';
		}
		
		if ($password != $password_repeat) {
			$errors['password_repeat'] = 'Heslá sa nezhodujú';
		}
		
                if (isset($_POST['status'])){
		    $stav = 'A';
		} else 
		    $stav='N';    
			
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
			$user->fl_admin = $stav;
			$user->save();
		}
                $view->errors = $errors;
                return Redirect::to('admin/list')->with('message', 'Domácnosť pridaná');
            }
            return $view;
        }
        
        //--- EDITOVANIE UZIVATELA --- 
        public function action_editUser(){
            $view = View::make('admin.eUser')->with('active', 'admin')->with('subactive', 'admin/eUser');
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
//                $status = ($_POST['status']);
//                $uroven = ($_POST['uroven']);
			
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
		
		if (isset($_POST['status'])){
		    $stav = 'A';
		} else 
		    $stav='N';

		if (isset($_POST['uroven'])){
		    $admin = 'A';
		} else 
		    $admin='N';                
			
//		if (!empty($errors)) {
//			$view->error = 'Opravte chyby vo formulári';
//			$view->errors = $errors;
//			return $view;
//		}
			
		//DB save 
		{
                    DB::query("UPDATE D_DOMACNOST SET t_nazov_domacnosti = '$domacnost', t_email_login = '$email', fl_aktivna = '$stav', fl_admin = '$admin' WHERE id = " . $id);
                }                
                return Redirect::to('admin/list')->with('message', 'Zmeny boli uložené');
            }
	}
        
        //--- ZMENA STAVU UZIVATELA (A/N) --- 
        public function action_disableUser(){
            $id = Input::get('id');
            $objekt = DB::first("SELECT fl_aktivna FROM D_DOMACNOST WHERE id= " . $id); 
           
            if ($objekt->fl_aktivna == 'A'){
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'N' WHERE id = " . $id);
                return Redirect::to('admin/list')->with('message', 'Užívateľ deaktivovaný');
            }
            else{
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'A' WHERE id = " . $id);
                
                return Redirect::to('admin/list')->with('message', 'Užívateľ aktivovaný');
            }
            
        }
        
        //--- MAZANIE UZIVATELA --- 
        public function action_deleteUser(){
            $id = Input::get('id');
            try {
                DB::query('DELETE FROM D_DOMACNOST WHERE id = "' . $id  . '"');
                return Redirect::to('admin/list')->with('message', 'Domácnosť bola vymazaná');
            }
            catch (Exception $e){
                $e->getMessage();
                
                return Redirect::to('admin/list')->with('message', 'Danú domácnosť nieje možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
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
                
                                return Redirect::to('admin/list')->with('message', 'Dané domácnosti nieje možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
                            }
                        }    
                    }
                    return Redirect::to('admin/list')->with('message', 'Domácnosti boli vymazané');
                    }
                return Redirect::to('admin/list')->with('message', 'Nebola zvolená ziadna domácnosť');
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
                    return Redirect::to('admin/list')->with('message', 'Domácnosti boli aktivované');
                }
                return Redirect::to('admin/list')->with('message', 'Nebola zvolená ziadna domácnosť');
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
                    return Redirect::to('admin/list')->with('message', 'Domácnosti boli deaktivované');
                }
                return Redirect::to('admin/list')->with('message', 'Nebola zvolená ziadna domácnosť');
            }
        }
}
