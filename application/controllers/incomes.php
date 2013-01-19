<?php

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
		);
		return View::make('incomes.index', $viewData);
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
			'partners'		=> Prijem::get_partners(),
			'incomes'		=> Prijem::get_incomes(),
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
				'partners'		=> Prijem::get_partners(),
				'prijmy'		=> Prijem::get_incomes(),
				'sources'		=> Prijem::get_sources(),
		);
		$vydajca = Input::get('vydajca');
		$view->partners = DB::table('D_OBCHODNY_PARTNER')	->where_in('id_osoba', $id_osob)
		->where('fl_typ','=','P' )->get();
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
			'id_zdroj_prijmu'	=> Input::get('id_zdroj_prijmu'),
			'vl_suma_prijmu'	=> Input::get('vl_suma_prijmu'),
			'd_datum'			=> date('Y-m-d', strtotime(Input::get('d_datum'))),
			't_poznamka'		=> Input::get('t_poznamka'),
		);
		
		$id = DB::table('F_PRIJEM')->insert_get_id($data);
		if($id)
		{
			return Redirect::to('incomes/form')
				->with('status', 'Nový Príjem bol úspešne uložený')
				->with('status_class', 'success');
		} else {
			return Redirect::to('incomes/form')
				->with('status', 'Pri ukladaní došlo k chybe')
				->with('status_class', 'error');
		}
	}

	public function get_partners()
	{
		$viewData = array(
			'partners'	=> Prijem::get_partners(Auth::user()->id),
		);
		return View::make('incomes.partners', $viewData);
	}



	/**
	 * Vyhladaj vsetky zdroje prijmov
	 * @author Andreyco
	 */
	public  function get_sources()
	{
		$viewData = array(
			'sources'	=> Prijem::get_sources(),
		);
		// print_r($viewData['sources']);
		return View::make('incomes.sources', $viewData);
	}


	public function get_delete($id)
	{
		if(DB::table('F_PRIJEM')->where('id', '=', $id)->delete())
		{
			return Redirect::to('incomes/form')
				->with('status', 'Príjem bol odstránený')
				->with('status_class', 'success');
		} else {
			return Redirect::to('incomes/form')
				->with('status', 'Pri vykonávaní operácie došlo k chybe')
				->with('status_class', 'error');
		}
	}



	/**
	 * AJAX actions
	 * @author Andreyco
	 */
	public function get_ajaxload($param, $id = false)
	{
		switch($param)
		{
			case 'partners':
				$partners = array();
				foreach(Prijem::get_partners() as $partner)
				{
					array_push($partners, array($partner->id => $partner->t_nazov) );
				}
				return Response::json($partners);
				break;

			case 'familymembers':
				$members = array();
				foreach(Prijem::get_person() as $member)
				{
					$members[$member->id] = $member->t_meno_osoby.' '.$member->t_priezvisko_osoby;
				}
				return Response::json($members);
				break;

			case 'incomesources':
				return Response::json(Prijem::get_source_list( $id ));
				break;
		}
	}

	public function post_ajaxsave($table)
	{
		$data = array(
			Input::get('name')	=> Input::get('value'),
			'id'	=> Input::get('pk'),
		);
		// Transform date into valid format
		if(Input::get('name') == 'd_datum')
		{
			$data['d_datum'] = date('Y-m-d', strtotime($data['d_datum']));
		}
		return Response::json(Prijem::ajaxsave($table, $data));
	}

	public function post_inline_edit()
	{
		return Response::json(Prijem::inline_save());
	}

}