<?php

class Prijem extends Eloquent
{
    public static $table = 'F_PRIJEM';
    public static $timestamps = true;
	
    public function partner() {
    
    	return $this->belongs_to('Partner', 'id_zdroj_prijmu');
    }
    /**
     * Vyhladaj vsetky prijmy pre domacnost
     * @author Andreyco 
     */
    public static function get_incomes()
    {
    	$od=Input::get('od');
    	$do=Input::get('do');
    	$familyMembers = DB::table('D_OSOBA')
			->where('id_domacnost', '=', Auth::user()->id)
			->get(array('id'));
		foreach($familyMembers as &$fM)
		{
			$fM = $fM->id;
		}

		$query = DB::table(static::$table.' as P')
    		->join('D_OBCHODNY_PARTNER as Z', 'P.id_obchodny_partner', '=', 'Z.id')
    		->join('D_TYP_PRIJMU as T', 'P.id_typ_prijmu', '=', 'T.id')
    		->join('D_OSOBA as O', 'P.id_osoba', '=', 'O.id')
    		->where_in('P.id_osoba', $familyMembers)
    		->order_by('P.d_datum', 'DESC');

		if(Input::get('osoba') && Input::get('osoba') !== 'all'){
			$query->where('O.id', '=', Input::get('osoba'));
		}
		if(Input::get('typ_prijmu') && Input::get('typ_prijmu') !== 'all'){
			$query->where('T.id', '=', Input::get('typ_prijmu'));
		}
		if(Input::get('zdroj') && Input::get('zdroj') !== 'all'){
			$query->where('Z.id', '=', Input::get('zdroj'));
		}
		
		if($od!=''&&$do!=''){
			$query	->where('P.d_datum', '>=', date('Y-m-d', strtotime(Input::get('od'))))
					->where('P.d_datum', '<=', date('Y-m-d', strtotime(Input::get('do'))))
					->order_by('d_datum', 'DESC');
		}
		if($od==''&&$do!=''){
			$query	->where('P.d_datum', '<=', date('Y-m-d', strtotime(Input::get('do'))))
					->order_by('d_datum', 'DESC');
		}
		if($od!=''&&$do==''){
			$query	->where('P.d_datum', '>=', date('Y-m-d', strtotime(Input::get('od'))))
					->order_by('d_datum', 'DESC');
		}

		return $query->get(array(
    			'P.id',
    			'P.vl_suma_prijmu',
    			'P.d_datum',
    			'P.t_poznamka',
    			'O.t_meno_osoby',
    			'O.t_priezvisko_osoby',
    			'Z.t_nazov',
    			'T.t_nazov_typu'
			));
    }

	public static function get_reports()
	{
		$od=Input::get('od');
    	$do=Input::get('do');
    	$familyMembers = DB::table('D_OSOBA')
			->where('id_domacnost', '=', Auth::user()->id)
			->get(array('id'));
		foreach($familyMembers as &$fM)
		{
			$fM = $fM->id;
		}
		$query = DB::table(static::$table.' as P')
    		->join('D_TYP_PRIJMU as T', 'P.id_typ_prijmu', '=', 'T.id')
    		->join('D_OSOBA as O', 'P.id_osoba', '=', 'O.id')
    		->where_in('P.id_osoba', $familyMembers)
    		->order_by('P.d_datum', 'DESC');

		return $query->get(array(
    			'P.id',
    			'P.vl_suma_prijmu',
    			'P.d_datum',
    			'O.t_meno_osoby',
    			'O.t_priezvisko_osoby',
    			'T.t_nazov_typu'
			));
	}


    /**
     * Vyhladaj vsetky aktivne osoby patriace do domacnosti
     * @author Andreyco
     */
	public static function get_person()
	{
		$person = DB::table('D_OSOBA')
			->where_id_domacnost(Auth::user()->id)
			->where_fl_domacnost('N')->order_by('t_priezvisko_osoby')->order_by('t_meno_osoby')
			->get(array('id', 't_meno_osoby', 't_priezvisko_osoby'));

		return $person;
	}

    
	public static function get_person_for_list()
	{
		$person		= array();
		$person['']	= 'zvoľte osobu';
		foreach(self::get_person()  as $p):
			$person[$p->id]	= $p->t_priezvisko_osoby. ' ('.$p->t_meno_osoby.')';
		endforeach;
		return $person;
	}

//typ prijmu
	//author Alisher Israilov

public static function get_typ_prijmu()
	{
		$typ_prijmu = DB::table('D_TYP_PRIJMU')
			->where_id_domacnost(Auth::user()->id)
			->get(array('id', 't_nazov_typu'));

		return $typ_prijmu;
	}


	public static function get_typ_prijmu_for_list()
	{
		$typ_prijmu		= array();
		$typ_prijmu['']	= 'zvoľte typ prijmu';
		foreach(self::get_typ_prijmu()  as $t):
			$typ_prijmu[$t->id]	= ' ('.$t->t_nazov_typu.')';
		endforeach;
		return $typ_prijmu;
	}


	public static function get_zdroj_prijmu()
	{
		$zdroj_prijmu = DB::table('D_OBCHODNY_PARTNER')
			->where_fl_typ('Zdroj príjmu')
			->get(array('id',  't_nazov'));

		return $zdroj_prijmu;
	}


	public static function get_zdroj_prijmu_for_list()
	{
		$zdroj_prijmu		= array();
		$zdroj_prijmu['']	= 'zvoľte zdroj prijmu';
		foreach(self::get_zdroj_prijmu()  as $z):
			$zdroj_prijmu[$z->id]	=  '('.$z->t_nazov.')';
		endforeach;
		return $zdroj_prijmu;
	}
	
	/*public static function get_source_list($person_id)
	{
		if(!$person_id){
			return array();
		}

		$source = DB::table('D_ZDROJ_PRIJMU')
			->where_id_osoba($person_id)
			->get();

		$source_html =  '<option value="">zvoľte zdroj príjmu</option>';
		foreach($source as $s):
			$source_html .= "<option value='{$s->id}' data-sum='{$s->vl_zakladna_suma}' data-type='{$s->fl_pravidelny}'>{$s->t_popis}</option>";
		endforeach;

		return $source_html;
	}*/
	
	/**
	 * Vyhladaj typy prijmov
	 * @author AnkhaaS
	 */
	public static function get_typy()
	{
		return DB::table('D_TYP_PRIJMU')
			->where('id_domacnost', '=', Auth::user()->id)->order_by('t_nazov_typu')
			->get();
	}
	/**
	 * Vyhladaj vsetky zdroje prijmov pre konkretnu osobu
	 * @author Andreyco
	 */
	
	/**
	 * Vyhladaj zdroj prijmu 
	 * @author AnkhaaS
	 */
	public static function get_partners()
	{
		return DB::table('D_OBCHODNY_PARTNER')
			->where('id_domacnost', '=', Auth::user()->id)
			->where('fl_typ','=','Zdroj príjmu')->or_where('fl_typ','=','Príjemca platby aj zdroj príjmu')
			->order_by('t_nazov')
			->get();
	}


public static function get_sources()
	{
		$familyMembers = DB::table('D_OSOBA')
			->where('id_domacnost', '=', Auth::user()->id)
			->get(array('id'));
		foreach($familyMembers as &$fM)
		{
			$fM = $fM->id;
		}

		return DB::table('D_OBCHODNY_PARTNER as Z')
			->left_join('D_OSOBA as O', 'O.id', '=', 'Z.id')
			->left_join('F_PRIJEM as P', 'Z.id', '=', 'P.id')
			->where_in('Z.id', $familyMembers)
			->get(array(
				'Z.id',
				'P.vl_suma_prijmu',
				'O.t_meno_osoby',
				'O.t_priezvisko_osoby',
				'P.t_poznamka',
			));
	}

	/**
	 * Vyhladaj vsetky zdroje prijmov pre prihlaseneho pouzivatela
	 * a vsetkych clenov domacnosti
	 * @author Andreyco
	 */
	

	/**
	 * Ajax ukladanie dat z tabulky
	 * @author Andreyco
	 */
	public static function inline_save()
	{
		$query = DB::table('D_OBCHODNY_PARTNER');

		// vloz novy zaznam a vrat ID noveho riadku
		if(Input::get('pk') === 'new'){
			$data = array(
				Input::get('name')	=> Input::get('value'),
				'id_osoba'	=> (int)Auth::user()->id
			);
			$id = $query->insert_get_id($data);
			return array('id' => $id);

		// aktualizuj existujuci zaznam
		} else {
			return $query->where('id', '=', Input::get('pk'))->update(array(
				Input::get('name')	=> Input::get('value')
			));
		}
	}


	public static function ajaxsave($table, $data)
	{
		if($data['id'] == 'new')
		{
			unset($data['id']);
			$id = DB::table($table)->insert_get_id($data);
			return array('id' => $id);
		} else {
			if($data['vl_zakladna_suma']){
				$data['vl_zakladna_suma'] = preg_replace('/\s+/', '', $data['vl_zakladna_suma']);
			}
			return DB::table($table)
				->where('id', '=', $data['id'])
				->update($data);
		}
	}
	

	
}
