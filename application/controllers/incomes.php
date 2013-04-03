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
		
		
		
		$view = View::make('incomes.main')
						->with('active', 'prijmy')->with('subactive', 'incomes/form')->with('secretword', md5(Auth::user()->t_heslo));
		$viewData = array(
			'list_person'	=> Prijem::get_person_for_list(),
			'list_typ_prijmu'=> Prijem::get_typ_prijmu_for_list(),
			'list_zdroj_prijmu'	=> Prijem::get_zdroj_prijmu_for_list()
		);
		return View::make('incomes.form', $viewData);
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
	 * Ulozenie zmien v prijme
	 * @author Andreyco
	 */
	public function post_form()
	{	
		
		$data = array(
			'id_osoba'	        => Input::get('id_osoba'),
			'id_typ_prijmu'	    => Input::get('id_typ_prijmu'),
			'd_datum'			=> date('Y-m-d', strtotime(Input::get('d_datum'))),
			'vl_suma_prijmu'	=> Input::get('vl_suma_prijmu'),
			'id_obchodny_partner'	=> Input::get('id_zdroj_prijmu'),
			't_poznamka'		=> Input::get('t_poznamka'),
		);
		
		  $id = DB::table('F_PRIJEM')->insert_get_id($data);
		if($id)
		{
			return Redirect::to('incomes')
				->with('status', 'Nový Príjem bol úspešne uložený')
				->with('status_class', 'success');
		} else {
			return Redirect::to('incomes')
				->with('status', 'Pri ukladaní došlo k chybe')
				->with('status_class', 'error');
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
				->with('status_class', 'success');
		} else {
			return Redirect::to('incomes/index')
				->with('status', 'Pri vykonávaní operácie došlo k chybe')
				->with('status_class', 'error');
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
      		->with('status_class', 'success');
      }
      else{
      return Redirect::to('incomes/index')
			->with('status', 'Pri vykonávaní operácie došlo k chybe')
			->with('status_class', 'error');
      }
    }
}

	
