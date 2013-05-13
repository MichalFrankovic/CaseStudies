<?php

use Laravel\Input;

class Incomes_Controller extends Base_Controller {

	public $restful = true;
	public $do = '';
	public $od = '';

	public function __construct()
	{
		
		View::share('active', 'incomes');
	}

	/**
	 * Zobrazenie prijmov a ich inline editacia.
	 * @author Andreyco (zobrazenie prijmov a inline editacia)
	 */
	public function get_index()
	{	
	
		
		$viewData = array(
			'incomes'		=> Prijem::get_incomes(),
			//'sources'		=> Prijem::get_sources(),
			'typy'			=> Prijem::get_typy(),
			'persons'		=> Prijem::get_person(),
			'partners'		=> Prijem::get_partners(),
			'reports'		=> Prijem::get_reports(),
		);
		
		return View::make('incomes.index', $viewData)
						->with('od', Input::get('od'))
						->with('do', Input::get('do'))
						->with('source->id', Input::get('zdroj'));
		
	}
	
	// public function get_index()
	// {

		
	// 	$view = View::make('incomes.main')
	// 		->with('active', 'prijmy')->with('subactive', 'incomes/form')->with('secretword', md5(Auth::user()->t_heslo));
	// 	$view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
	// 	$view->message = Session::get('message');
	// 	foreach ($view->osoby as $osoba)
	// 	{ 
	// 		$id_osob[] = $osoba->id;
	// 	}
	// 	$viewData = array(
	// 			'list_person'	=> Prijem::get_person_for_list(),
	// 			'partners'		=> Prijem::get_partners(),
	// 			'prijmy'		=> Prijem::get_incomes(),
	// 			'sources'		=> Prijem::get_sources(),
	// 			);
	// 	$view->prijmy = Prijem::where_in('id',$id_osob)->get();
	// 	$view->partners = DB::table('D_OBCHODNY_PARTNER')	->where_in('id_osoba', $id_osob)
	// 														->where('fl_typ','=','P' )->get();
	// 	$view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
	// 	$view->do = '';
	// 	$view->od = '';
		
	// 	return $view;
	// }
		
	

	/**
	 * Pridanie prijmu
	 * @author Andreyco
	 */
	public function get_form()
	{	
		
		 $x = Input::get('id');
          if (isset($x)) {
               $id = Input::get('id');
                        }
                          else {
                            $id = Session::get('id');     // ak v editácii nezadali nejaké pole
                        }


		if (isset($id))
		{
			$idprijmu=$id;
			
			$view = View::make('incomes.form')
							->with('active', 'prijmy')
							->with('subactive', 'incomes/form')
							->with('secretword', md5(Auth::user()->t_heslo));

			$editacia = DB::table('F_PRIJEM as P')
    		->join('D_OBCHODNY_PARTNER as Z', 'P.id_obchodny_partner', '=', 'Z.id')
    		->join('D_TYP_PRIJMU as T', 'P.id_typ_prijmu', '=', 'T.id')
    		->join('D_OSOBA as O', 'P.id_osoba', '=', 'O.id')
    		->where('P.id','=', $idprijmu)
    		->get();

    		$editacia[0]->id = $idprijmu;

		}

		$viewData = array(
				'list_person'	=> Prijem::get_person_for_list(),
				'list_typ_prijmu'=> Prijem::get_typ_prijmu_for_list(),
				'list_zdroj_prijmu'	=> Prijem::get_zdroj_prijmu_for_list()
			);

		$osoby = DB::table('D_OSOBA')
			->where_id_domacnost(Auth::user()->id)
			->where_fl_domacnost('N')
			->get(array('id', 't_meno_osoby', 't_priezvisko_osoby'));

		$typ_prijmu = DB::table('D_TYP_PRIJMU')
			->where_id_domacnost(Auth::user()->id)
			->get(array('id', 't_nazov_typu'));

		$zdroj_prijmu = DB::table('D_OBCHODNY_PARTNER')
			->where_fl_typ('Zdroj príjmu')
			->where_id_domacnost(Auth::user()->id)
			->get(array('id',  't_nazov'));

	if (isset($editacia)) { $uprava = 'ano';}
		else { $uprava = 'nie';
			    $editacia = ' '; }

			$view = View::make('incomes.form', $viewData)
			->with('editacia',$editacia)
			->with('osoby',$osoby)
			->with('typ_prijmu',$typ_prijmu)
			->with('zdroj_prijmu',$zdroj_prijmu)
			->with('uprava',$uprava);
			
	    $view->errors = Session::get('errors');
        $view->error = Session::get('error');
 $view->meneny_osoba = Session::get('meneny_osoba');
        $view->meneny_typ = Session::get('meneny_typ');
        $view->meneny_suma = Session::get('meneny_suma');
		$view->meneny_zdroj = Session::get('meneny_zdroj');    		
		$view->meneny_datum = Session::get('meneny_datum');    		
		return $view;

	}
	

	public function action_filter()
	{
	
		//$view = View::make('incomes.main')
		//->with('active', 'prijmy')->with('subactive', 'incomes/list')->with('secretword', md5(Auth::user()->t_heslo));
		$view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
		foreach ($view->osoby as $osoba)
		{
			$id_osob[] = $osoba->id;
		}
		$od = Input::get('od');
		$od = ($od!='') ? $od : '';
	
		$do = Input::get('do');
		$do = ($do!='') ? $do : date('Y-m-d');
		$viewData = array(
				'list_person'	=> Prijem::get_person_for_list(),
			'list_typ_prijmu'=> Prijem::get_typ_prijmu_for_list(),
				'prijmy'		=> Prijem::get_incomes(),
				'zdroj_prijmu'		=> Prijem::get_zdroj_prijmu(),
				'sources'		=> Prijem::get_sources(),
		);
		$vydajca = Input::get('vydajca');
		$view->partners = DB::table('D_OBCHODNY_PARTNER')	->where_in('id_domacnost', $id_osob)
		->where('fl_typ','=','Príjemca platby' )->get();
		$view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
	
		$view->prijmy = Prijem::where_in('id',$id_osob)->where('d_datum', '>=', $od)->where('d_datum', '<=', $do);
		if ($vydajca != 'all') $view->prijmy->where("id_obchodny_partner",'=',$vydajca);
		$view->do = $do;
		$view->od = $od;
		$view->prijmy = $view->prijmy->get();
	
	
		return View::make('incomes.form', $viewData);
		return $view;
	}



	/**
	 * Ulozenie noveho prijmu
	 * @author Andreyco
	 */
	public function post_form()
	{	
	
	$idecko = Input::get('id');	
	$editacia = Input::get('editacia');
	$id_osoba=Input::get('id_osoba');
	$id_typ_prijmu=Input::get('id_typ_prijmu');
	$vl_suma_prijmu=Input::get('vl_suma_prijmu');
	$id_obchodny_partner=Input::get('id_zdroj_prijmu');
	$d_datum=Input::get('d_datum');

if ($id_osoba == 'Nezaradený') {  
      $errors['id_osoba'] = 'Vyberte prosím osobu';
    }	
if ($id_typ_prijmu == 'Nezaradený') {  
      $errors['id_typ_prijmu'] = 'Vyberte prosím typ príjmu';
    }
if (empty($d_datum)) {  
           $errors['d_datum'] = 'Zadajte prosím dátum';
        }	

if (!preg_match('/[1-9]|[1-9]./', $vl_suma_prijmu)) 
{  
      $errors['vl_suma_prijmu'] = 'Suma musí obsahovať číslo';
    }

if ($id_obchodny_partner == 'Nezaradený') 
{  
      $errors['id_obchodny_partner'] = 'Vyberte prosím zdroj príjmu';
    }
    
	if (!empty($errors)) {
      $error = 'Opravte chyby vo formulári';

      $view = Redirect::to('incomes/form')
                        ->with('error', $error)
                        ->with('errors',$errors)
                        ->with('meneny_osoba',$id_osoba)
                        ->with('meneny_typ',$id_typ_prijmu)
                        ->with('meneny_suma',$vl_suma_prijmu)
                        ->with('meneny_zdroj',$id_obchodny_partner)
					    ->with('meneny_datum',$d_datum)
					    ->with('id',$idecko);

						return $view;
    }  
		$data = array(
			'id_osoba'	        => Input::get('id_osoba'),
			'id_typ_prijmu'	    => Input::get('id_typ_prijmu'),
			'd_datum'			=> date('Y-m-d', strtotime(Input::get('d_datum'))),
			'vl_suma_prijmu'	=> Input::get('vl_suma_prijmu'),
			'id_obchodny_partner'	=> Input::get('id_zdroj_prijmu'),
			't_poznamka'		=> Input::get('t_poznamka'),
		);
		
		
	if ($editacia == 'nie') 
		{
		$id = DB::table('F_PRIJEM')->insert_get_id($data);

			if($id)
			{
				return Redirect::to('incomes')
					->with('status', 'Nový príjem bol úspešne uložený')
					->with('status_class', 'sprava-uspesna');
			} else {
				return Redirect::to('incomes')
					->with('status', 'Pri ukladaní došlo k chybe')
					->with('status_class', 'sprava-chyba');
			}

		} else { /*$aktualizacia = DB::table('F_PRIJEM')
					->where('id','=',$idecko)
					->update($data);*/

				$aktualizacia = DB::query("UPDATE F_PRIJEM
											SET 
											id_obchodny_partner = '$data[id_obchodny_partner]',
											vl_suma_prijmu = '$data[vl_suma_prijmu]',
											id_osoba = '$data[id_osoba]',
											id_typ_prijmu = '$data[id_typ_prijmu]',
											d_datum = '$data[d_datum]',
											t_poznamka = '$data[t_poznamka]'
											WHERE id= '$idecko'");

				return Redirect::to('incomes')
					->with('status', 'Údaje boli aktualizované')
					->with('status_class', 'sprava-uspesna');
				}

	}
	

	/**
	 * Zobraz zoznam partnerov
	 * @author Andreyco
	 */



	/**
	 * Vyhladaj vsetky zdroje prijmov
	 * @author Andreyco
	 */
	//public  function get_sources()
	//{
		//$viewData = array(
		//	'sources'	=> Prijem::get_sources(),
	//	);
		// print_r($viewData['sources']);
	//	return View::make('incomes.sources', $viewData);
//	}



	/**
	 * Odstran prijem
	 * @author Andreyco
	 */
	public function get_delete($id)
	{
		if(DB::table('F_PRIJEM')->where('id', '=', $id)->delete())
		{
			return Redirect::to('incomes/index')
				->with('status', 'Príjem bol odstránený')
				->with('status_class', 'sprava-uspesna');
		} else {
			return Redirect::to('incomes/index')
				->with('status', 'Pri vykonávaní operácie došlo k chybe')
				->with('status_class', 'sprava-chyba');
		}
	}

	/**
	 * multizmazanie prijmu
	 * @author AnkhaaS
	 */
	
	public function get_multideleteincomes()
    {
      $deleted = 0;
      $income_ids = Input::get('income');

      if (is_array($income_ids))
      {
        foreach ($income_ids as $income_id)
        {
           DB::table('F_PRIJEM')->where('id', '=', $income_id)->delete();//mazanie poloziek
           $deleted = $deleted + 1;
        }
      }
      if($deleted > 0){
      return Redirect::to('incomes/index')
      		->with('status', 'Prijmy boli vymazané!')
      		->with('status_class', 'sprava-uspesna');
      }
      else{
      return Redirect::to('incomes/index')
			->with('status', 'Pri vykonávaní operácie došlo k chybe')
			->with('status_class', 'sprava-chyba');
      }
    }
}

	
