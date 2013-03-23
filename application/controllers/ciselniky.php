<?php

class Ciselniky_Controller extends Base_Controller {



	public function action_index() 
	{
        $active='ciselniky';
        echo $active;
        return Redirect::to('ciselniky/sprava_osob')->with('active', 'ciselniky')->with('subactive', 'x');;
	}


// *********** --- PODSEKCIA 1 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU OSOB ********************************
    //@Adriána Gogoľáková

public function action_sprava_osob()
    {


        $subactive = 'podmenu-sprava-osob';

        $id = Input::get('id');

        if (isset($id)) {       

          $editovany_zaznam = DB::table('D_OSOBA')->where('id', '=', $id)->get();

            $view = View::make('ciselniky.sprava-osob')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id)
            ->with('editovany_zaznam',$editovany_zaznam);

        } 
          else {

          $view = View::make('ciselniky.sprava-osob')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

          }

        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->produkty = Kategoria::where('id_domacnost','=',Auth::user()->id)->get();

        $view->message = Session::get('message');
        
        return $view;
    }


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

      
        $id = Input::get('id');
            try {

                DB::query('DELETE FROM D_OSOBA WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$osoba_id.'\''); //mazanie hlavicky
              
        return Redirect::to('ciselniky/sprava_osob')->with('message', 'Osoba bola vymazaná!'); 
            }
            catch (Exception $e){
                $e->getMessage();
                
                return Redirect::to('ciselniky/sprava_osob')->with('message', 'Danú osobu nie je možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
            }

    }
    

public function action_multizmazanieosob()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $osoba_ids = Input::get('osoba');

      if (count($osoba_ids) > 0){
      if (is_array($osoba_ids))
      {
            foreach ($osoba_ids as $osoba_id)
            {
            try
              {
              DB::query('DELETE FROM D_OSOBA WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$osoba_id.'\''); //mazanie poloziek
              
            }
            catch (Exception $e){
                                $e->getMessage();
                                return Redirect::to('ciselniky/sprava_osob')->with('message', 'Nemozno zmazat osobu');
                              }           
            }
      }
    return Redirect::to('ciselniky/sprava_osob')->with('message', 'Osoby boli vymazané.');
    }


      return Redirect::to('ciselniky/sprava_osob')->with('message', 'Nebola zvolená ziadna osoba!');
    }


        public function action_upravitosobu()
        {

        $id = Input::get('id');
        $t_meno_osoby = Input::get('meno');
        $t_priezvisko_osoby = Input::get('priezvisko');
        $fl_aktivna = Input::get('aktivna');
        if (isset($_POST['aktivna'])){
        $fl_aktivna = 'A';
        }    else 
        $fl_aktivna='N';
          
        if(($fl_aktivna==(isset($_POST['aktivna']))) OR ($t_meno_osoby==(isset($_POST['meno']))) OR ($t_priezvisko_osoby==(isset($_POST['priezvisko']))))
        {
         

          DB::query("UPDATE D_OSOBA SET t_meno_osoby = '$t_meno_osoby', t_priezvisko_osoby = '$t_priezvisko_osoby', fl_aktivna = '$fl_aktivna' WHERE id = '$id'");
            
        return Redirect::to('ciselniky/sprava_osob')->with('message', 'Zmeny osoby boli uložené.');
        }
        else
        {
         return Redirect::to('ciselniky/sprava_osob')->with('message', 'Žiadne zmeny sa neuskutočnili!');
         
        }
      }

// *********** --- PODSEKCIA 1 (KONIEC) --- FUNKCIE PRE SPRÁVU OSOB ********************************



// *********** --- PODSEKCIA 2 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU PARTNEROV ********************************
  //@Juraj Zbojan

public function action_sprava_partnerov()
    {

        $id = Input::get('id');

        if (isset($id)) { 

           $editovany_zaznam = Partner::where('id','=',$id)->get();

           $view = View::make('ciselniky.sprava-partnerov')
            ->with('active', 'ciselniky')
            ->with('subactive', 'podmenu-sprava-partnerov')
            ->with('secretword', md5(Auth::user()->t_heslo))
            ->with('editovany_zaznam',$editovany_zaznam);

        } else {

       $view = View::make('ciselniky.sprava-partnerov')
       ->with('active', 'ciselniky')
       ->with('subactive', 'podmenu-sprava-partnerov')
       ->with('secretword', md5(Auth::user()->t_heslo));

     }

        $view->partneri = Partner::where('id_domacnost','=',Auth::user()->id)->get();

        $view->message = Session::get('message');

       return $view;   
    }

public function action_pridatpartnera()
    {
     $id_domacnost = Auth::user()->id;
     $t_nazov = Input::get('nazov');
     $t_adresa = Input::get('adresa');
     $fl_typ = Input::get('typ');

   DB::query("INSERT INTO `web`.`D_OBCHODNY_PARTNER` (`id` ,`id_domacnost` ,`t_nazov` ,`t_adresa` ,`fl_typ` )
   VALUES (NULL , '$id_domacnost', '$t_nazov', '$t_adresa', '$fl_typ');");
        
  return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Partner bol pridaný!');
    }
  

public function action_upravitpartnera()
    {
     $id = Input::get('id');
     $t_nazov = Input::get('nazov');
     $t_adresa = Input::get('adresa');
     $fl_typ = Input::get('typ');

   DB::query("UPDATE D_OBCHODNY_PARTNER SET t_nazov = '$t_nazov', t_adresa = '$t_adresa', fl_typ = '$fl_typ' WHERE id = '$id'");
  
   
   return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Zmeny boli uložené.');
    } 


public function action_zmazatpartnera()
    {
     $id = Input::get('id');
     $secretword = md5(Auth::user()->t_heslo);

       try 
     {
             DB::query('DELETE FROM D_OBCHODNY_PARTNER WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$id.'\'');
              
             return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Partner bol vymazaný!');
         }
         catch (Exception $e)
     {
             $e->getMessage();
             return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Daného partnera nie je možné vymazať, <br />nakolko by bola narušená konzistencia dát v DB');
         }

    }
  

public function action_multizmazaniepartnerov()
    {
     $partner_ids = Input::get('par');
     $secretword = md5(Auth::user()->t_heslo);
   if (count($partner_ids) > 0)
    {
         if (is_array($partner_ids))
      {
       foreach ($partner_ids as $par)
        {
         try
          {
           DB::query('DELETE FROM D_OBCHODNY_PARTNER WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$par.'\'');     
          }
                 catch (Exception $e)
          {
           $e->getMessage();
           return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Nie je možné zmazať partnera');
          }
        }
      }
     return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Partneri boli vymazaní.');
    }
     else return Redirect::to('ciselniky/sprava_partnerov')->with('message', 'Nebola zvolená žiadna osoba!');
    }



// *********** --- PODSEKCIA 2 (KONIEC) --- FUNKCIE PRE SPRÁVU PARTNEROV ********************************



// *********** --- PODSEKCIA 3 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU KATEGÓRIÍ ********************************
    //@Veronika Študencová

    public function action_sprava_kategorii()
    {
       $subactive = 'podmenu-sprava-kategorii';

               $id = Input::get('id');

        if (isset($id)) {       // Buď sa stránka načíta normálne alebo sa načíta s editovaným záznamom

          $editovany_zaznam = Kategoria::where('id','=',$id)->get();

            $view = View::make('ciselniky.sprava-kategorii')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id)
            ->with('editovany_zaznam',$editovany_zaznam);

        } 
          else {

          $view = View::make('ciselniky.sprava-kategorii')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

          }



        $view->kategorie = DB::query("SELECT
                                      a.id,
                                      a.nazov AS t_nazov,
                                      concat(
                                    case when a.typ =  'K' then concat(space(length(a.id_kategoria)-4), substr(a.id_kategoria, 4))
                                    else space(length(a.id_kategoria)-4)
                                    end,
                                    ' ',
                                    a.nazov
                                    ) AS nazov
                                      FROM
                                      (
                                      SELECT
                                      kategoria.id id,
                                      kategoria.id id_kategoria,
                                      kategoria.t_nazov nazov,
                                      kategoria.fl_typ typ
                                      FROM D_KATEGORIA_A_PRODUKT kategoria
                                      WHERE kategoria.fl_typ = 'K'
                                      AND kategoria.id_domacnost = ". Auth::user()->id ." 
                                      ORDER BY id_kategoria           
                                      ) AS a
                                    
                                   ");
       // $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

       /* $view->kategorie2 = DB::query("SELECT
                                      a.id,
                                      a.nazov AS t_nazov,
                                      concat(
                                    case when a.typ =  'K' then concat( substr(a.id_kategoria,4,3))
                                    end
                                    ) AS nazov
                                      FROM
                                      (
                                      SELECT
                                      kategoria.id id,
                                      kategoria.id id_kategoria,
                                      kategoria.t_nazov nazov,
                                      kategoria.fl_typ typ
                                      FROM D_KATEGORIA_A_PRODUKT kategoria
                                      WHERE kategoria.fl_typ = 'K'
                                      AND kategoria.id_domacnost = ". Auth::user()->id ." 
                                      ORDER BY nazov
                                      ) AS a
                                     
                                   "); */
        $view->kategorie2 = Kategoria::where('id_domacnost','=',Auth::user()->id)
                                  ->order_by('t_nazov','ASC')
                                  ->where('fl_typ','=','K')->get();

        $view->message = Session::get('message');
        return $view;
    }


    public function action_pridajkategoriu()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov = Input::get('nazov');
        $id_kategoria_parent = Input::get('Nadkategoria-id');
       //xxecho "call kategoria_insert('$id_kategoria_parent', $id_domacnost, '$t_nazov')";
       
       DB::query("call kategoria_insert('$id_kategoria_parent', $id_domacnost, '$t_nazov')");

       return Redirect::to('ciselniky/sprava_kategorii')->with('message', 'Kategória bola pridaná!');
    }


    public function action_zmazatkategoriu()
    {
        $secretword = md5(Auth::user()->t_heslo);
        $kat_id = Input::get('kat');

        DB::query('DELETE FROM D_KATEGORIA_A_PRODUKT WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$kat_id.'\''); //mazanie hlavicky
        return Redirect::to('ciselniky/sprava_kategorii')->with('message', 'Kategória bola vymazaná!'); 
    }


    public function action_multizmazaniekat()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $kat_ids = Input::get('kat');

      if (is_array($kat_ids))
      {
        foreach ($kat_ids as $kat_id)
        {
          DB::query('DELETE FROM D_KATEGORIA_A_PRODUKT WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$kat_id.'\''); //mazanie poloziek
        }
      }

      return Redirect::to('ciselniky/sprava_kategorii')->with('message', 'Kategorie boli vymazané!');
    }

    public function action_upravkat(){ 
      
        $id = Input::get('id');
        $t_nazov = Input::get('nazov');
        $nadkategoria = Input::get('Nadkategoria-id');
       
          
        DB::query("UPDATE D_KATEGORIA_A_PRODUKT 
                    SET t_nazov = '$t_nazov',
                        id_kategoria_parent = '$nadkategoria'
                         
                    WHERE id = '$id'");
            
        return Redirect::to('ciselniky/sprava_kategorii')->with('message', 'Zmeny boli uložené.');
      }

// *********** --- PODSEKCIA 3 (KONIEC) --- FUNKCIE PRE SPRÁVU KATEGÓRIÍ ********************************


// *********** --- PODSEKCIA 4 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU PRODUKTOV ********************************
    //@Michal Frankovič

public function action_sprava_produktov()
    {
        $subactive = 'podmenu-sprava-produktov';

        $id = Input::get('id');

        if (isset($id)) {       // Buď sa stránka načíta normálne alebo sa načíta s editovaným záznamom

          $editovany_zaznam = Kategoria::where('id','=',$id)->get();

            $view = View::make('ciselniky.sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id)
            ->with('editovany_zaznam',$editovany_zaznam);

        } 
          else {

          $view = View::make('ciselniky.sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

          }

        $view->kategorie = DB::query("select
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

                                    ) a
                                    order by a.id_kategoria,a.typ
                                   ");
       // $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->where('id_domacnost','=',Auth::user()->id)->get();

        $view->osoby = DB::table('D_OSOBA')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->produkty = Kategoria::where('id_domacnost','=',Auth::user()->id)
                            ->order_by('t_nazov','ASC')
                            ->where('fl_typ','=','P')->get();

        $view->message = Session::get('message');
        
        return $view;
    }


public function action_pridajprodukt()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov = Input::get('nazov');
        $cena = floatval(str_replace(',', '.',Input::get('cena')));
        $id_kategoria_parent = Input::get('kategoria-id');
        $t_merna_jednotka = Input::get('jednotka');

        DB::query("call produkt_insert($id_domacnost,
                                      '$t_nazov', 
                                      '$t_merna_jednotka',
                                       $cena,
                                      '$id_kategoria_parent')");
        
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



    public function action_upravprodukt(){ 

        $id = Input::get('id');
        $t_nazov = Input::get('nazov');
        $cena = Input::get('cena');
        $jednotka = Input::get('jednotka');
        $idkategoria = Input::get('kategoria-id');
          
        DB::query("UPDATE D_KATEGORIA_A_PRODUKT 
                    SET t_nazov = '$t_nazov', 
                        vl_zakladna_cena = '$cena', 
                        t_merna_jednotka = '$jednotka',
                        id_kategoria_parent = '$idkategoria'  
                    WHERE id = '$id'");
            
        return Redirect::to('ciselniky/sprava_produktov')->with('message', 'Zmeny boli uložené.');
      }

// *********** --- PODSEKCIA 4 (KONIEC) --- FUNKCIE PRE SPRÁVU PRODUKTOV ********************************


// *********** --- PODSEKCIA 5 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU TYPU PRÍJMU ********************************
   //@Ankhbayar Sukhee

public function action_sprava_typu_prijmu()
    {
       $subactive = 'podmenu-sprava-typu-prijmu';
       $id = Input::get('id');

       if (isset($id)) {       // Buď sa stránka načíta normálne alebo sa načíta s editovaným záznamom

        $editovany_zaznam = Typyprijmu::where('id','=',$id)->get();

        $view = View::make('ciselniky.sprava-typu-prijmu')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id)
            ->with('editovany_zaznam',$editovany_zaznam);

        } 
        
        else {

        $view = View::make('ciselniky.sprava-typu-prijmu')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id); 
             }

        $view->typy = Typyprijmu::where('id_domacnost','=',Auth::user()->id)->get();
        $view->message = Session::get('message');
        return $view;

    }


public function action_pridajtypprijmu()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov_typu = Input::get('nazov_typu');
        $errors ='';
        $duplicate = Typyprijmu::where('t_nazov_typu', '=', $t_nazov_typu)->first();
        if (!empty($duplicate)) {
            $errors= 'Tento názov typu už je pridaný. ';
        return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', $errors);
        }
         else {
       DB::query("INSERT INTO `web`.`D_TYP_PRIJMU` (`t_nazov_typu`, `id_domacnost`) VALUES('$t_nazov_typu', '$id_domacnost');");

       return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', 'Typ prijmu bol pridaný!');
         }
    }

    public function action_zmazattypprijmu()
    {
        $secretword = md5(Auth::user()->t_heslo);
        $typ_id = Input::get('typ');

        $id = Input::get('id');
        try {
            DB::query('DELETE FROM D_TYP_PRIJMU WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$typ_id.'\''); //mazanie hlavicky
            return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', 'Typ prijmu bol vymazaný!');
            }
        catch (Exception $e){
                $e->getMessage();
                
            return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', 'Daný typ prijmu nie je možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
            }

    }

    public function action_multitypzmazat()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $typ_ids = Input::get('typ');

      if (is_array($typ_ids))
      {
        foreach ($typ_ids as $typ_id)
        {
          DB::query('DELETE FROM D_TYP_PRIJMU WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$typ_id.'\''); //mazanie poloziek
        }
      }

      return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', 'Typy prijmu boli vymazané!');
    }
    public function action_upravtypprijmu(){

        $id = Input::get('id');
        $t_nazov_typu = Input::get('nazov_typu');
                  
        DB::query("UPDATE D_TYP_PRIJMU SET t_nazov_typu = '$t_nazov_typu' WHERE id = '$id'");
            
        return Redirect::to('ciselniky/sprava_typu_prijmu')->with('message', 'Zmeny boli uložené.');
      }
// *********** --- PODSEKCIA 5 (KONIEC) --- FUNKCIE PRE SPRÁVU TYPU PRÍJMU ********************************



// *********** --- PODSEKCIA 6 (ZAČIATOK) --- FUNKCIE PRE SPRÁVU TYPU VÝDAVKU ********************************
    //@Alisher Bek

public function action_sprava_typu_vydavku()
    {
       $subactive = 'podmenu-sprava-typu-vydavku';
	   
	    $id = Input::get('id');

        if (isset($id)) {      

          $editovany_zaznam = DB::table('D_TYP_VYDAVKU')->where('id', '=', $id)->get();

        $view = View::make('ciselniky.sprava-typu-vydavku')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id)
			   ->with('editovany_zaznam', $editovany_zaznam);
			} 
          else {
			  
			  

          $view = View::make('ciselniky.sprava-typu-vydavku')->with('secretword', md5(Auth::user()->t_heslo))
            ->with('active', 'ciselniky')->with('subactive', $subactive)->with('uid', Auth::user()->id);

          }
		
        $view->typy = DB::table('D_TYP_VYDAVKU')->where('id_domacnost', '=',Auth::user()->id)->get();

        $view->message = Session::get('message');
        return $view;
    }


public function action_pridajtypvydavku()
    {
        $id_domacnost = Auth::user()->id;
        $t_nazov_typu_vydavku = Input::get('nazov_typu_vydavku');
        
       
       
      DB::query("INSERT INTO  `web`.`D_TYP_VYDAVKU` (`t_nazov_typu_vydavku`, `id_domacnost`)
                   VALUES ('$t_nazov_typu_vydavku' , '$id_domacnost');");
        
       return Redirect::to('ciselniky/sprava_typu_vydavku')->with('message', 'Typ vydavku bol pridaný!');
    }
  
public function action_zmazattypvydavku()
    {
        $secretword = md5(Auth::user()->t_heslo);
    $typvydavku_id = Input::get('typvydavku');

        $id = Input::get('id');
            try {
        DB::query('DELETE FROM D_TYP_VYDAVKU WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$typvydavku_id.'\''); 
        return Redirect::to('ciselniky/sprava_typu_vydavku')->with('message', 'Typ vydavku bol vymazaný!'); 
    }
  catch (Exception $e){
                $e->getMessage();
				  return Redirect::to('ciselniky/sprava_osob')->with('message', 'Danú osobu nie je možné vymazať, <br />nakoľko by bola narušená konzistencia dát v DB');
            }

    }
  public function action_multizmazattypy()
    {
      $secretword = md5(Auth::user()->t_heslo);
      $typvydavku_ids = Input::get('typvydavku');
        if (count($typvydavku_ids) > 0){
      if (is_array($typvydavku_ids))
      {
        foreach ($typvydavku_ids as $typvydavku_id)
		 {
            try
        {
          DB::query('DELETE FROM D_TYP_VYDAVKU WHERE CONCAT(md5(id),\''.$secretword.'\') = \''.$typvydavku_id.'\''); 
        }
		catch (Exception $e){
                                $e->getMessage();
                                return Redirect::to('ciselniky/sprava_typu_vydavku')->with('message', 'Nemozno zmazat osobu');
      }
	   }
 }
      return Redirect::to('ciselniky/sprava_typu_vydavku')->with('message', 'Typy vydavku boli vymazané!!');
    }
    return Redirect::to('ciselniky/sprava_typu_vydavku');//->with('message', 'Nebola označena ziadna osoba!');
    }

  public function action_upravittypvydavku()
  { 

        $id = Input::get('id');
        $t_nazov_typu_vydavku = Input::get('nazov_typu_vydavku');


  
 

        DB::query("UPDATE D_TYP_VYDAVKU SET t_nazov_typu_vydavku = '$t_nazov_typu_vydavku' WHERE id = '$id'");
  


        return Redirect::to('ciselniky/sprava_typu_vydavku')->with('message', 'Zmeny boli uložené.');
		
  }


// *********** --- PODSEKCIA 6 (KONIEC) --- FUNKCIE PRE SPRÁVU TYPU VÝDAVKU ********************************


 

	  } 

