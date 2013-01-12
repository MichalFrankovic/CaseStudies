<?php

class Admin_Controller extends Base_Controller {

	public function action_index() {
		$view = View::make('admin.index')
                ->with('active', 'list')->with('subactive', 'admin/users');
                $view->domacnosti = DB::table('D_DOMACNOST')->get();
                $view->message = Session::get('message');
                
                return $view;			
	}
        
        //--- PRIDANIE UZIVATELA --- 
	public function action_addUser(){
            
            $domacnost = ($_POST['domacnost']);
            $email = ($_POST['email']);
            $heslo = ($_POST['heslo']);
            $heslo2 = ($_POST['heslo2']);
            $uroven = ($_POST['uroven']);
            
            if($domacnost == '' || $email == '' || $heslo == '' || $heslo2 == '' || $uroven == '' && $heslo != $heslo2) {
                return Redirect::to('admin')->with('message', 'Našli sa chyby vo vstupe!');                 
            }
            $Hheslo = Hash::make($heslo);
            DB::query("INSERT INTO D_DOMACNOST(t_nazov_domacnosti, t_email_login, t_heslo, fl_aktivna, fl_admin) VALUES('$domacnost','$email','$Hheslo','A','$uroven')");
            
            return Redirect::to('admin')->with('message', 'Užívateľ pridaný');

	}
        
        //--- EDITOVANIE UZIVATELA --- 
        public function action_editUser(){
            $view = View::make('admin.eUser')->with('active', 'list')->with('subactive', 'admin/users');
            $id = Input::get('id');
            $view->domacnosti = DB::table('D_DOMACNOST')->where('id', '=', $id)->get();
            
            return $view;		
	}
        public function action_editUserDone(){
            
            $id = ($_POST['id']); 
            $domacnost = ($_POST['domacnost']);
            $email = ($_POST['email']);
            $stav = ($_POST['stav']);
            $uroven = ($_POST['uroven']);
            
            if($domacnost == '' || $email == '' || $stav== '' || $uroven == '') {
                return Redirect::to('admin')->with('message', 'Našli sa chyby vo vstupe!');                 
            }
//            $Hheslo = Hash::make($heslo);
            DB::query("UPDATE D_DOMACNOST SET t_nazov_domacnosti = '$domacnost', t_email_login = '$email', fl_aktivna = '$stav', fl_admin = '$uroven' WHERE id = " . $id);            
           
            return Redirect::to('admin')->with('message', 'Úpravy boli uložené!');	
	}
        
        //--- ZMENA STAVU UZIVATELA (A/N) --- 
        public function action_disableUser(){
            $id = Input::get('id');
            $objekt = DB::first("SELECT fl_aktivna FROM D_DOMACNOST WHERE id= " . $id); 
           
            if ($objekt->fl_aktivna == 'A'){
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'N' WHERE id = " . $id);
                return Redirect::to('admin')->with('message', 'Užívateľ deaktivovaný!');
            }
            else{
                DB::query("UPDATE D_DOMACNOST SET fl_aktivna = 'A' WHERE id = " . $id);
                
                return Redirect::to('admin')->with('message', 'Užívateľ aktivovaný!');
            }
            
        }
        
        //--- MAZANIE UZIVATELA --- 
        public function action_deleteUser(){
            $id = Input::get('id');
            try {
                DB::query('DELETE FROM D_DOMACNOST WHERE id = "' . $id  . '"');
                return Redirect::to('admin')->with('message', 'Domácnosť bola úspešne vymazaná');
            }
            catch (Exception $e){
                $e->getMessage();
                
                return Redirect::to('admin')->with('message', 'Danú domácnosť nieje možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB!');
            }
            
        }
}