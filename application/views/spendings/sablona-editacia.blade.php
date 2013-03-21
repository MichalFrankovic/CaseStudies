@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif

@include('spendings/sp-submenu')

<h2>Šablóna výdavkov - editácia</h2>

{{ Form::open('spendings/ulozsablonu?update=1', 'POST', array('class' => 'side-by-side','name' => 'tentoForm', 'id' => 'aktualnyformular')); }}
    <input type="hidden" name="hlavicka-id" id="hidden" value="{{ $editovana_sablona[0]->id }}"/>

    <div class="input-prepend">
        <label class="control-label">    Názov výdavku:  </label> 
        <input class="span4" type="text" name="nazov" value="{{ $editovana_sablona[0]->t_poznamka }}" />
    </div>

    <div class="input-prepend">
        <label class="control-label">   Príjemca platby:  </label>
          <select name="partner" class="span4">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}"{{ (($partner->id == $editovana_sablona[0]->id_obchodny_partner)? " selected" : "") }}> {{ $partner->t_nazov }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Pravidelnosť:    </label>  
        <select class="span4" name="pravidelnost">
            <option value="A"{{ (($editovana_sablona[0]->fl_pravidelny == 'A')? " selected" : "") }}>Pravidelný</option>
            <option value="N"{{ (($editovana_sablona[0]->fl_pravidelny == 'N')? " selected" : "") }}>Nepravidelný</option>
        </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Kategória:         </label>
          <select name="polozka-id" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
                  @foreach ($polozky as $polozka)
                      <option value="{{ $polozka->id }}"{{ (($polozka->id == $editovana_sablona[0]->id_kategoria_a_produkt)? " selected" : "") }}> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                 @endforeach
          </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Hodnota výdavku:  </label>
        <input name="hodnota" class="span4" type="text" value="{{ $editovana_sablona[0]->vl_jednotkova_cena }}" />
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
