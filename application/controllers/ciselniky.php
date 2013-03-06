<?php

class Ciselniky_Controller extends Base_Controller {

// ZAčIATOK --- VYTVORENIE PODSTRÁNOK: ---

	public function action_index()
	{
        $active='ciselniky';
        echo $active;
        return Redirect::to('ciselniky/sprava_partnerov')->with('active', 'ciselniky')->with('subactive', 'x');;
	}


  public function action_sprava_partnerov()
    {
       $view = View::make('ciselniky.sprava-partnerov')->with('active', 'ciselniky')->with('subactive', 'podmenu-sprava-partnerov');
       return $view;   
    }


  public function action_sprava_kategorii()
    {
       $subactive = 'podmenu-sprava-kategorii';

        $view = View::make('ciselniky.sprava-kategorii')
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->message = Session::get('message');
        return $view;
    }


  public function action_sprava_typu_prijmu()
    {
       $view = View::make('ciselniky.sprava-typu-prijmu')->with('active', 'ciselniky')->with('subactive', 'podmenu-sprava-typu-prijmu');
       return $view;
    }


   public function action_sprava_typu_vydavku()
    {
       $view = View::make('ciselniky.sprava-typu-vydavku')->with('active', 'ciselniky')->with('subactive', 'podmenu-sprava-typu-vydavku');
       return $view; 
    }


     public function action_sprava_osob()
    {
       $subactive = 'podmenu-sprava-osob';

        $view = View::make('ciselniky.sprava-osob') ->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();
        
        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->message = Session::get('message');
        return $view;
    }


    public function action_sprava_produktov()
    {
        $subactive = 'podmenu-sprava-produktov';

        $view = View::make('ciselniky.sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->message = Session::get('message');

        $view->produkty = Kategoria::where('id_domacnost','=',Auth::user()->id)->get();
        return $view;
    }

// KONIEC --- VYTVORENIE PODSTRÁNOK ---



// TU ZAČÍNAJÚ FUNKCIE PRE PRÁCU NA PODSTRÁNKACH:


// *********** --- PODSEKCIA 1 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU PARTNEROV ********************************
  //@Juraj Zbojan


// *********** --- PODSEKCIA 1 (KONIEC) --- FUNKCIE PRE SPRÁVU PARTNEROV ********************************



// *********** --- PODSEKCIA 2 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU KATEGÓRIÍ ********************************
    //@Veronika Študencová

public function action_pridajkategoriu()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov = Input::get('nazov');
        $id_kategoria_parent = Input::get('category-id');
       //xxecho "call kategoria_insert('$id_kategoria_parent', $id_domacnost, '$t_nazov')";
       
       DB::query("call kategoria_insert('$id_kategoria_parent', $id_domacnost, '$t_nazov')");

       return Redirect::to('ciselniky/pridanie')->with('message', 'Kategória bola pridaná!');
    }


    public function action_pridanie()
    {
        $subactive = 'ciselniky/sprava-kategorii';

        $view = View::make('ciselniky.sprava-kategorii')
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->message = Session::get('message');

        return $view;

    }

// *********** --- PODSEKCIA 2 (KONIEC) --- FUNKCIE PRE SPRÁVU KATEGÓRIÍ ********************************



// *********** --- PODSEKCIA 3 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU TYPU PRÍJMU ********************************
   //@Ankhbayar Sukhee


// *********** --- PODSEKCIA 3 (KONIEC) --- FUNKCIE PRE SPRÁVU TYPU PRÍJMU ********************************



// *********** --- PODSEKCIA 4 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU TYPU VÝDAVKU ********************************
    //@Alisher Bek


// *********** --- PODSEKCIA 4 (KONIEC) --- FUNKCIE PRE SPRÁVU TYPU VÝDAVKU ********************************



// *********** --- PODSEKCIA 5 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU OSOB ********************************
    //@Adriána Gogoľáková

public function action_pridajosobu()
    {
        $id_domacnost = Auth::user()->id;
        $t_meno_osoby = Input::get('meno');
        $t_priezvisko_osoby = Input::get('priezvisko');
        IF( Input::get('aktivna') == "A") { $fl_aktivna = "A";} else { $fl_aktivna = "N"; }
        $fl_dom = "N";
        
        DB::query("INSERT INTO  `web`.`D_OSOBA` (`id` ,`id_domacnost` ,`t_meno_osoby` ,`fl_aktivna` ,`fl_domacnost` ,`t_priezvisko_osoby`)
                   VALUES (NULL ,  '$id_domacnost',  '$t_meno_osoby',  '$fl_aktivna',  'N',  '$t_priezvisko_osoby');");
        
        return Redirect::to('ciselniky/sprava_osob')->with('message', 'Osoba bola pridaná!');
    }


public function action_zmazatosobu()
    {
        $secretword = md5(Auth::user()->t_heslo);
        $osoba_id = Input::get('osoba');

        DB::query('DELETE FROM D_OSOBA WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$osoba_id.'\''); //mazanie hlavicky
        return Redirect::to('ciselniky/sprava_osob')->with('message', 'Osoba bola vymazaná!'); 
    }
    

public function action_multizmazanieosob()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $osoba_ids = Input::get('osoba');

      if (is_array($osoba_ids))
      {
        foreach ($osoba_ids as $osoba_id)
        {
          DB::query('DELETE FROM D_OSOBA WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$osoba_id.'\''); //mazanie poloziek
        }
      }

      return Redirect::to('ciselniky/sprava_osob')->with('message', 'Osoby boli vymazané!');
    }


//--- ADA ------>EDITOVANIE UZIVATELA  --- * este treba upravit, stale mi to hadze vsetky a zmeny neuklada
        public function action_upravitosobu()
        {
            $view = View::make('ciselniky.editovanie-osoby')->with('active', 'ciselniky')->with('subactive', 'podmenu-sprava-osob');
            $id = Input::get('id');

            //$view->osoby = DB::table('D_OSOBA')->where('id', '=',Auth::user()->id)->get();
           
            $echo_domac = Auth::user()->t_nazov_domacnosti;
            $view->osoby = DB::table('D_OSOBA')
            ->where_id_domacnost(Auth::user()->id)
            ->get(array('id', 't_meno_osoby', 't_priezvisko_osoby', 'fl_aktivna'));

            return $view;   
        }

          public function action_editUserDone(){                                   
   
            $id = Input::get('id');
            $meno = Input::get('t_meno_osoby');
            $priezvisko = Input::get('t_priezvisko_osoby');
            $aktivna = Input::get('fl_aktivna');
            $objekt = DB::first("SELECT id, t_meno_osoby, t_priezvisko_osoby, fl_aktivna FROM D_OSOBA WHERE id= " . $id); 
           
            
    
              DB::query("UPDATE D_OSOBA SET t_meno_osoby = '$meno', t_priezvisko_osoby = '$priezvisko', fl_aktivna = '$aktivna' WHERE id = " . $id);
                               
                return Redirect::to('ciselniky/sprava_osob')->with('message', 'Zmeny boli uložené');
            }

// *********** --- PODSEKCIA 5 (KONIEC) --- FUNKCIE PRE SPRÁVU OSOB ********************************



// *********** --- PODSEKCIA 6 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU PRODUKTOV ********************************
    //@Michal Frankovič

public function action_pridajprodukt()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov = Input::get('nazov');
        $cena = floatval(str_replace(',', '.',Input::get('cena')));
        $id_kategoria_parent = Input::get('category-id');

        DB::query("call produkt_insert($id_domacnost,'$t_nazov', 'kus',$cena, '$id_kategoria_parent')");
        
        return Redirect::to('ciselniky/sprava_produktov')->with('message', 'Produkt bol pridaný!');
    }


public function action_zmazatprodukt()
    {
        $secretword = md5(Auth::user()->t_heslo);
        $produkt_id = Input::get('produkt');

        DB::query('DELETE FROM D_KATEGORIA_A_PRODUKT WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$produkt_id.'\''); //mazanie hlavicky
        return Redirect::to('ciselniky/sprava_produktov')->with('message', 'Produkt bol vymazaný!'); 
    }
    

public function action_multizmazanie()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $produkt_ids = Input::get('produkt');

      if (is_array($produkt_ids))
      {
        foreach ($produkt_ids as $produkt_id)
        {
          DB::query('DELETE FROM D_KATEGORIA_A_PRODUKT WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$produkt_id.'\''); //mazanie poloziek
        }
      }

      return Redirect::to('ciselniky/sprava_produktov')->with('message', 'Produkty boli vymazané!');
    }

// *********** --- PODSEKCIA 6 (KONIEC) --- FUNKCIE PRE SPRÁVU PRODUKTOV ********************************



  }
  

