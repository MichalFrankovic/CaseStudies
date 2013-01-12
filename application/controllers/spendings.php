<?php

class Spendings_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/
        public $do = '';
        public $od = '';

	public function action_index()
	{

        $view = View::make('spendings.main')
          ->with('active', 'vydavky')->with('subactive', 'admin/settings');
        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
        $view->message = Session::get('message');
        foreach ($view->osoby as $osoba)
        {
            $id_osob[] = $osoba->id;
        }
        $view->vydavky = Vydavok::where_in('id_osoba',$id_osob)->get();
        $view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
        //$p = Partner::all();
        //print_r($view->kategorie);
        //$view->p = Vydavok::where('id_obchodny_partner' ,'=', '4')->join('phone', 'users.id', '=', 'phone.user_id') ;
        $view->do = '';
        $view->od = '';
        return $view;
	}

    public function action_filter()
    {
        //Auth::user()->id = 2;
        $view = View::make('spendings.main')
            ->with('active', 'vydavky')->with('subactive', 'admin/settings');
        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
        foreach ($view->osoby as $osoba)
        {
            $id_osob[] = $osoba->id;
        }
        $od = Input::get('od');
        $od = ($od!='') ? $od : '';

        $do = Input::get('do');
        $do = ($do!='') ? $do : date('Y-m-d');

        $prijemca = Input::get('prijemca');
        $view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
        $view->vydavky = Vydavok::where_in('id_osoba',$id_osob)->where('d_datum', '>=', $od)->where('d_datum', '<=', $do);
        if ($prijemca != 'all') $view->vydavky->where("id_obchodny_partner",'=',$prijemca);
        $view->do = $do;
        $view->od = $od;
        $view->vydavky = $view->vydavky->get();

        return $view;
    }

    public function action_periodicalspending()
    {
        $view = View::make('spendings.periodicalspending')->with('active', 'vydavky')->with('subactive', 'spendings/periodicalspending');

        $view->message = Session::get('message');
        
        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
     foreach ($view->osoby as $osoba)
     {
     $id_osob[] = $osoba->id;
     }

     $view->polozky = DB::query("select
                                  a.id,
                                  concat(
                                  case when a.typ = 'K' then concat(space(length(a.id_kategoria)-4), substr(a.id_kategoria, 4))
                                  else space(length(a.id_kategoria)-4)
                                  end,
                                  ' ',
                                  a.nazov
                                  ) nazov
                                  from
                                  (
                                  select
                                  kategoria.id id,
                                  kategoria.id id_kategoria,
                                  kategoria.t_nazov nazov,
                                  kategoria.fl_typ typ
                                  from D_KATEGORIA_A_PRODUKT kategoria
                                  where kategoria.fl_typ = 'K'
                                  and kategoria.id_domacnost = ". Auth::user()->id ."

                                  union all

                                  select
                                  produkt.id id,
                                  produkt.id_kategoria_parent id_kategoria,
                                  produkt.t_nazov nazov,
                                  produkt.fl_typ typ
                                  from D_KATEGORIA_A_PRODUKT produkt
                                  where produkt.fl_typ = 'P'
                                  and produkt.id_domacnost = ". Auth::user()->id ."
                                  ) a
                                  order by a.id_kategoria,a.typ
                                  ");
        $view->dzejson = Response::json($view->polozky);
        $view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
        $view->message = Session::get('message');
        return $view;
    }
    public function action_saveperiodical() {
    	$data = Input::All() ;

    	return Redirect::to('spendings/periodicalspending')->with('message', 'Pravideln&yacute; v&yacute;davok bol ulo&zcaron;en&yacute;!');
    }
    
    public function action_simplespending()
    {
        //Auth::user()->id = 1;
        $id = Input::get('id');
        //if (!isset($id)) $id = Session::get('id');

        if (!isset($id))
        {
            $view = View::make('spendings.newspending')
                ->with('active', 'vydavky')->with('subactive', 'admin/settings')->with('secretword', md5(Auth::user()->t_heslo));
        }else
        {
            $view = View::make('spendings.simplespending')
                ->with('active', 'vydavky')->with('subactive', 'admin/settings')->with('secretword', md5(Auth::user()->t_heslo));
            $view->vydavky = Vydavok::where('id', '=', $id);
            $view->polozky_vydavku = DB::table('R_VYDAVOK_KATEGORIA_A_PRODUKT')->where('id_vydavok','=', $id)->get();
            $view->celkova_suma = 0;
            foreach ($view->polozky_vydavku as $polozka_vydavku)
            {
                $view->celkova_suma += $polozka_vydavku->vl_jednotkova_cena * $polozka_vydavku->num_mnozstvo;
                if ($polozka_vydavku->fl_typ_zlavy == 'A') $view->celkova_suma -= $polozka_vydavku->vl_zlava;
                if ($polozka_vydavku->fl_typ_zlavy == 'P') $view->celkova_suma -= ($polozka_vydavku->vl_jednotkova_cena * $polozka_vydavku->num_mnozstvo) * $polozka_vydavku->vl_zlava/100;

            }
            $view->vydavky = $view->vydavky->get();
            if ($view->vydavky[0]->fl_typ_zlavy == 'A') $view->celkova_suma -= $view->vydavky[0]->vl_zlava;
            if ($view->vydavky[0]->fl_typ_zlavy == 'P') $view->celkova_suma -= $view->celkova_suma * $view->vydavky[0]->vl_zlava/100;



        }
        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
        foreach ($view->osoby as $osoba)
        {
            $id_osob[] = $osoba->id;
        }

        $view->polozky = DB::query("select
                                      a.id,
                                      concat(
                                    case when a.typ =  'K' then concat(space(length(a.id_kategoria)-4), substr(a.id_kategoria, 4))
                                    else space(length(a.id_kategoria)-4)
                                    end,
                                    ' ',
                                    a.nazov
                                    ) nazov
                                    from
                                    (
                                    select
                                    kategoria.id id,
                                    kategoria.id id_kategoria,
                                    kategoria.t_nazov nazov,
                                    kategoria.fl_typ typ
                                    from D_KATEGORIA_A_PRODUKT kategoria
                                    where kategoria.fl_typ = 'K'
                                    and kategoria.id_domacnost = ". Auth::user()->id ."

                                    union all

                                    select
                                    produkt.id id,
                                    produkt.id_kategoria_parent id_kategoria,
                                    produkt.t_nazov nazov,
                                    produkt.fl_typ typ
                                    from D_KATEGORIA_A_PRODUKT produkt
                                    where produkt.fl_typ = 'P'
                                    and produkt.id_domacnost = ". Auth::user()->id ."
                                    ) a
                                    order by a.id_kategoria,a.typ
                                   ");
        $view->dzejson = Response::json($view->polozky);
        $view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
        $view->message = Session::get('message');
        return $view;

    }

    public function action_savespending()
    {
        $data = Input::All() ;
        $data_for_sql['id_osoba'] = $data['osoba'];
        $data_for_sql['id_obchodny_partner'] =  $data['dodavatel'];
        $data_for_sql['d_datum'] =  date('Y-m-d',strtotime($data['datum']));
        $data_for_sql['t_poznamka'] =  $data['poznamka'];
        $data_for_sql['vl_zlava'] =  $data['celkova-zlava'];
        $data_for_sql['fl_typ_zlavy'] =  $data['celkovy-typ-zlavy'];
        if (isset($data['update']))
        {
            /*
             * UPDATE HLAVICKY
             */

            $aktualizacia = DB::table('F_VYDAVOK')
                ->where('id', '=', $data['hlavicka-id'])
                ->update($data_for_sql);

          /*
           * UPDATE POLOZIEK
           */
            for ( $i = 0 ;$i < count($data['vydavok-id']);$i++)
            {
              $polozky_for_sql['id_kategoria_a_produkt'] = $data['polozka-id'][$i];
              $polozky_for_sql['vl_jednotkova_cena'] =$data['cena'][$i];
              $polozky_for_sql['num_mnozstvo'] = $data['mnozstvo'][$i];
              $polozky_for_sql['vl_zlava'] = $data['zlava'][$i];
              $polozky_for_sql['fl_typ_zlavy'] = $data['typ-zlavy'][$i];

           //vydavok sa nerovna N bude sa updatovat
            if ($data['vydavok-id'][$i] != 'N')
            {
                //echo "UPDATE";
                DB::table('R_VYDAVOK_KATEGORIA_A_PRODUKT')
                 ->where('id', '=', $data['vydavok-id'][$i])
                 ->update($polozky_for_sql);
            }
           //vydavok sa rovna N bude nova polozka
            if ($data['vydavok-id'][$i] == 'N')
            {
                //echo "INSERT";
                $polozky_for_sql['id_vydavok'] = $data['hlavicka-id'];
                DB::table('R_VYDAVOK_KATEGORIA_A_PRODUKT')->insert($polozky_for_sql);
            }
              unset($polozky_for_sql);
            }
            return Redirect::to_action('spendings@simplespending?id='.$data['hlavicka-id'])->with("message", 'Výdavok bol aktualizovaný');

        /*
         * INSERT NOVEHO VYDAVKU
         */
        }else{
                 $idvydavku = DB::table('F_VYDAVOK')
                       ->insert_get_id($data_for_sql);

                //echo "INSERT";
                for ( $i = 0 ;$i < count($data['vydavok-id']);$i++)
                    {
                        $polozky_for_sql['id_kategoria_a_produkt'] = $data['polozka-id'][$i];
                        $polozky_for_sql['vl_jednotkova_cena'] =$data['cena'][$i];
                        $polozky_for_sql['num_mnozstvo'] = $data['mnozstvo'][$i];
                        $polozky_for_sql['vl_zlava'] = $data['zlava'][$i];
                        $polozky_for_sql['fl_typ_zlavy'] = $data['typ-zlavy'][$i];
                        //echo "INSERT";
                        $polozky_for_sql['id_vydavok'] = $idvydavku;
                        DB::table('R_VYDAVOK_KATEGORIA_A_PRODUKT')->insert($polozky_for_sql);
                        unset($polozky_for_sql);
                    }

                return Redirect::to('spendings')->with('message', 'Výdavok bol úspešne pridaný!');

                }


     }
    public function action_deletepolozka()
    {
        $secretword = md5(Auth::user()->t_heslo);
        $pol = Input::get('pol');
       DB::query('DELETE FROM R_VYDAVOK_KATEGORIA_A_PRODUKT WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$pol.'\'');

        return Redirect::to_action('spendings@simplespending?id='.Input::get('vydavokid'))->with("message", 'Položka bola vymazaná');
    }
    public function action_deletespending()
    {
        return View::make('spendings.templatespending')->with('active', 'vydavky')->with('subactive', 'spendings/templatespending');
    }
    
    public function action_templatespending() {
    	$view = View::make('spendings.templatespending')->with('active', 'vydavky')->with('subactive', 'spendings/templatespending');
    	
    	$view->message = Session::get('message');
    	
    	$view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();
    	foreach ($view->osoby as $osoba)
    	{
    		$id_osob[] = $osoba->id;
    	}
    	
    	$view->polozky = DB::query("select
                                      a.id,
                                      concat(
                                    case when a.typ =  'K' then concat(space(length(a.id_kategoria)-4), substr(a.id_kategoria, 4))
                                    else space(length(a.id_kategoria)-4)
                                    end,
                                    ' ',
                                    a.nazov
                                    ) nazov
                                    from
                                    (
                                    select
                                    kategoria.id id,
                                    kategoria.id id_kategoria,
                                    kategoria.t_nazov nazov,
                                    kategoria.fl_typ typ
                                    from D_KATEGORIA_A_PRODUKT kategoria
                                    where kategoria.fl_typ = 'K'
                                    and kategoria.id_domacnost = ". Auth::user()->id ."
    	
                                    union all
    	
                                    select
                                    produkt.id id,
                                    produkt.id_kategoria_parent id_kategoria,
                                    produkt.t_nazov nazov,
                                    produkt.fl_typ typ
                                    from D_KATEGORIA_A_PRODUKT produkt
                                    where produkt.fl_typ = 'P'
                                    and produkt.id_domacnost = ". Auth::user()->id ."
                                    ) a
                                    order by a.id_kategoria,a.typ
                                   ");
    	
    	$view->partneri = DB::table('D_OBCHODNY_PARTNER')->where_in('id_osoba', $id_osob)->get();
    	return $view;
    }

    public function action_savetemplate() {
    	$data = Input::All() ;

    	return Redirect::to('spendings/templatespending')->with('message', 'Šablóna bola úspešne pridaná!');
    }

    public function  getVydavok($id){
        return null;


    }
}
