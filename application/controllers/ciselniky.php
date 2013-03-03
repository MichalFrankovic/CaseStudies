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
       $view = View::make('ciselniky.sprava-osob')->with('active', 'ciselniky')->with('subactive', 'podmenu-sprava-osob');
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


// ********************************** ZAČIATOK: FUNKCIE PRE SPRÁVU KATEGÓRIÍ *****************************************

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


// ********************************** KONIEC: FUNKCIE PRE SPRÁVU KATEGÓRIÍ *****************************************


// ********************************** ZAČIATOK: FUNKCIE PRE SPRÁVU PRODUKTOV *****************************************

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
    
// ********************************** KONIEC: FUNKCIE PRE SPRÁVU PRODUKTOV *****************************************


}

