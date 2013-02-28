<?php

class Ciselniky_Controller extends Base_Controller {

/*	public function action_index(){
       
	return View::make('ciselniky.index')->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov');
      //  return Redirect::to('ciselniky');
 
        
	}*/

	public function action_index()
	{
        return Redirect::to('ciselniky/sprava_produktov')->with('subactive', 'x');;
	}



	public function action_sprava_produktov()
    {
       $view = View::make('ciselniky.sprava-produktov')->with('subactive', 'ciselniky/sprava-produktov');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }




    public function action_sprava_prijemcu_platby()
    {
       $view = View::make('ciselniky.sprava-prijemcu-platby')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }




	 public function action_sprava_kategorii()
    {
       $view = View::make('ciselniky.sprava-kategorii')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }



         public function action_sprava_typu_prijmu()
    {
       $view = View::make('ciselniky.sprava-typu-prijmu')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }


         public function action_sprava_zdroju_prijmu()
    {
       $view = View::make('ciselniky.sprava-zdroju-prijmu')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }



         public function action_sprava_poplatkov()
    {
       $view = View::make('ciselniky.sprava-poplatkov')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }


         public function action_sprava_setriacich_uctov()
    {
       $view = View::make('ciselniky.sprava-setriacich-uctov')->with('subactive', 'x');
       return $view;
          //  ->with('active', 'ciselniky')->with('subactive', 'ciselniky/sprava-produktov')->with('secretword', md5(Auth::user()->t_heslo));
        }




}

