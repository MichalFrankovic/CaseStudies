<?php

class Incomes_Controller extends Base_Controller {

	public $restful = true;
	public $do = '';
	public $od = '';

	public function get_main()
	{

		
		$view = View::make('incomes.main')
			->with('active', 'prijmy')->with('subactive', 'admin/settings');
		$view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
		$view->message = Session::get('message');
		foreach ($view->osoby as $osoba)
		{
			$id_osob[] = $osoba->id;
		}
		$view->prijmy = Prijem::where_in('id',$id_osob)->get();
		$view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
		$view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
		$view->do = '';
		$view->od = '';
		return $view;
		}
		
		public function action_filter()
		{
			//Auth::user()->id = 2;
			$view = View::make('incomes.main')
			->with('active', 'prijmy')->with('subactive', 'admin/settings');
			$view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
			foreach ($view->osoby as $osoba)
			{
				$id_osob[] = $osoba->id;
			}
			$od = Input::get('od');
			$od = ($od!='') ? $od : '';
		
			$do = Input::get('do');
			$do = ($do!='') ? $do : date('Y-m-d');
		
			$vydajca = Input::get('vydajca');
			$view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
			$view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
			$view->prijmy = Prijem::where_in('id',$id_osob)->where('d_datum', '>=', $od)->where('d_datum', '<=', $do);
			if ($vydajca != 'all') $view->prijmy->where("id_zdroj_prijmu",'=',$vydajca);
			$view->do = $do;
			$view->od = $od;
			$view->prijmy = $view->prijmy->get();
		
			return $view;
		}
		
	}

	

