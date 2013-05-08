@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

<style type="text/css">
  form.side-by-side > div > label {float:left;width:180px;}
</style>

@include('spendings/sp-submenu')

<h3> Editovanie šablóny <?php echo $editovana_sablona[0]->t_poznamka; ?> </h3>

{{ Form::open('spendings/ulozsablonu?update=1', 'POST', array('class' => 'side-by-side','name' => 'tentoForm', 'id' => 'aktualnyformular')); }}
    <input type="hidden" name="hlavicka-id" id="hidden" value="{{ $editovana_sablona[0]->id }}"/>

    <div {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Názov šablóny:   </label> 
        <input class="span3" type="text" name="nazov" value="{{ $editovana_sablona[0]->t_poznamka }}" />
        {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? '<span class="help-inline">'.$errors['nazov'].'</span>' : '' }}
    </div>

    <div class="input-prepend">
        <label class="control-label">   Príjemca platby - partner:  </label>
          <select name="partner" class="span3">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}"{{ (($partner->id == $editovana_sablona[0]->id_obchodny_partner)? " selected" : "") }}> {{ $partner->t_nazov }}</option>
            @endforeach
        </select>
    </div>

     <div class="input-prepend">
         <label class="control-label">   Zaplatil - osoba:      </label>
             <select name="osoba" class="span3">
             @foreach ($osoby as $osoba)
             <option value="{{ $osoba->id }}" {{ (($osoba->id == $editovana_sablona[0]->id_osoba)? " selected" : "") }}> {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }} </option>
            @endforeach
             </select>
      </div>

      <div class="input-prepend">
        <label class="control-label">   Typ výdavku:     </label>
        <select name="typ-vydavku" class="span3">
            @foreach ($typy_vydavkov as $typ)
            <option value="{{ $typ->id }}" {{ (($typ->id == $editovana_sablona[0]->id_typ_vydavku)? " selected" : "") }}> {{ $typ->t_nazov_typu_vydavku }} </option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Pravidelnosť:    </label>  
        <select class="span3" name="pravidelnost">
            <option value="A"{{ (($editovana_sablona[0]->fl_pravidelny == 'A')? " selected" : "") }}>Pravidelný</option>
            <option value="N"{{ (($editovana_sablona[0]->fl_pravidelny == 'N')? " selected" : "") }}>Nepravidelný</option>
        </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Kategória alebo produkt:         </label>
          <select name="polozka-id" class="span3">
                  @foreach ($polozky as $polozka)
                      <option value="{{ $polozka->id }}"{{ (($polozka->id == $editovana_sablona[0]->id_kategoria_a_produkt)? " selected" : "") }}> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                 @endforeach
          </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Hodnota výdavku:  </label>
        <input name="hodnota" class="span2" type="text" value="{{ $editovana_sablona[0]->vl_jednotkova_cena }}" />
        <span class="add-on" value=''>€</span>
    </div>



    <a  href="periodicalspending" class="btn btn-primary">
          <i class="icon-arrow-left icon-white"></i>
                Návrat
    </a>


    <button type="submit" class="btn btn-primary">
          <i class="icon-ok icon-white"></i>
              Uložiť
    </button>


{{ Form::close() }}


@include('foot')
