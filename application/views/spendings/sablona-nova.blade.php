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

<h3> Parametre novej šablóny výdavkov: </h3>

{{ Form::open('spendings/ulozsablonu', 'POST', array('class' => 'side-by-side','name' => 'tentoForm', 'id' => 'aktualnyformular')); }}
      <div {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Názov šablóny:  </label>         
          <input class="span3" type="text" name="nazov">
        {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? '<span class="help-inline">'.$errors['nazov'].'</span>' : '' }}
      </div>

      <div class="input-prepend">
        <label class="control-label">   Príjemca platby - partner: </label>
            <select name="partner" class="span3">
              @foreach ($partneri as $partner)
              <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
              @endforeach
          </select>
      </div>

      <div class="input-prepend">
         <label class="control-label">   Zaplatil - osoba:      </label>
             <select name="osoba" class="span3">
             @foreach ($osoby as $osoba)
             <option value="{{ $osoba->id }}"> {{$osoba->t_priezvisko_osoby }} {{ $osoba->t_meno_osoby }} </option>
            @endforeach
             </select>
      </div>

      <div class="input-prepend">
        <label class="control-label">   Typ výdavku:     </label>
        <select name="typ-vydavku" class="span3">
            @foreach ($typy_vydavkov as $typ)
            <option value="{{ $typ->id }}"> {{ $typ->t_nazov_typu_vydavku }} </option>
            @endforeach
        </select>
    </div>

      <div class="input-prepend">
        <label class="control-label">    Pravidelnosť:    </label>      
          <select class="span3" name="pravidelnost">
              <option value="A">  Pravidelný    </option>
              <option value="N">  Nepravidelný  </option>
          </select>
      </div>

      <div class="input-prepend">
        <label class="control-label">    Kategória alebo produkt:  </label>
            <select name="polozka-id" class="span3">
                    @foreach ($polozky as $polozka)
                        <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                   @endforeach
            </select>
      </div>

      <div class="input-prepend">
         <label class="control-label">    Hodnota výdavku:         </label>
          <input name="hodnota" class="span2" type="text">
          <span class="add-on" value=''>€</span>
      </div>
      


      <a href="../spendings/sablona" class="btn btn-primary"> 
         <i class="icon-remove icon-white"> </i> 
              Zruš 
      </a> 

      <button type="submit" class="btn btn-primary">
            <i class="icon-ok icon-white"></i>
                Pridaj šablónu
      </button>

{{ Form::close() }}


@include('foot')