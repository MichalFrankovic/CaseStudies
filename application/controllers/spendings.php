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
        $kategoria = Input::all();
        //print_r($kategoria);
        $view = View::make('spendings.main')
            ->with('active', 'vydavky')->with('subactive', 'admin/settings');
        $view->vydavky = Vydavok::all();
        $view->partneri = Partner::All();
        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->get();
        //$p = Partner::all();
        //print_r($view->kategorie);
        //$view->p = Vydavok::where('id_obchodny_partner' ,'=', '4')->join('phone', 'users.id', '=', 'phone.user_id') ;
        $view->do = '';
        $view->od = '';
        return $view;
	}

    public function action_filter()
    {
        $kategoria = Input::get('category');
        $view = View::make('spendings.main')
            ->with('active', 'vydavky')->with('subactive', 'admin/settings');
        $od = Input::get('od');
        $od = ($od!='') ? $od : '';

        $do = Input::get('do');
        $do = ($do!='') ? $do : date('Y-m-d');

        $prijemca = Input::get('prijemca');

        $view->partneri = Partner::All();
        $view->kategorie = Kategoria::where('id', 'LIKE','%K%')->get();
        $view->vydavky = Vydavok::where('d_datum', '>=', $od)->where('d_datum', '<=', $do);
        if ($prijemca != 'all') $view->vydavky->where("id_obchodny_partner",'=',$prijemca);
        $view->do = $do;
        $view->od = $od;
        $view->vydavky = $view->vydavky->get();
        return $view;
    }

    public function action_periodicalspending()
    {
        return View::make('spendings.periodicalspending')->with('active', 'vydavky')->with('subactive', 'spendings/periodicalspending');
    }
    public function action_simplespending()
    {
        return View::make('spendings.simplespending')->with('active', 'vydavky')->with('subactive', 'spendings/simplespending');
    }
    public function action_templatespending()
    {
        return View::make('spendings.templatespending')->with('active', 'vydavky')->with('subactive', 'spendings/templatespending');
    }

}