<?php

class Prijem extends Eloquent
{
    public static $table = 'F_PRIJEM';

    /**
     * Vyhladaj vsetky aktivne osoby patriace do domacnosti
     * @author Andreyco
     */
	public static function get_person()
	{
		$person = DB::table('d_osoba')
			->where_id_domacnost(Auth::user()->id)
			->where_fl_aktivna('A')
			->where_fl_domacnost('N')
			->get(array('id', 't_meno_osoby', 't_priezvisko_osoby'));

		return $person;
	}

    /**
     * @author: Andreyco
     */
	public static function get_person_for_list()
	{
		$person		= array();
		$person['']	= 'zvoľte osobu';
		foreach(self::get_person()  as $p):
			$person[$p->id]	= $p->t_priezvisko_osoby. ' ('.$p->t_meno_osoby.')';
		endforeach;
		return $person;
	}

	/**
	 * Vyhladaj vsetky zdroje prijmov pre konkretnu osobu
	 * @author Andreyco
	 */
	public static function get_source_list($person_id)
	{
		if(!$person_id){
			return array();
		}

		$source = DB::table('d_zdroj_prijmu')
			->where_id_osoba($person_id)
			->get();

		$source_html = count($source) > 1 ? '<option value="0">zvoľte zdroj príjmu</option>' : '';
		$source_html =  '<option value="0">zvoľte zdroj príjmu</option>';
		foreach($source as $s):
			$source_html .= "<option value='{$s->id}' data-sum='{$s->vl_zakladna_suma}' data-type='{$s->fl_pravidelny}'>{$s->t_popis}</option>";
		endforeach;

		return $source_html;
	}

}