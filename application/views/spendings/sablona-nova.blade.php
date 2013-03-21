@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif

@include('spendings/sp-submenu')

<h2>Šablóna výdavkov - pridaj novú</h2>

{{ Form::open('spendings/ulozsablonu', 'POST', array('class' => 'side-by-side','name' => 'tentoForm', 'id' => 'aktualnyformular')); }}
      <div class="input-prepend">
        <label class="control-label">    Názov výdavku:  </label>         
          <input class="span4" type="text" name="nazov">
      </div>

      <div class="input-prepend">
        <label class="control-label">   Príjemca platby:  </label>
            <select name="partner" class="span4">
              @foreach ($partneri as $partner)
              <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
              @endforeach
          </select>
      </div>

      <div class="input-prepend">
        <label class="control-label">    Pravidelnosť:    </label>      
          <select class="span4" name="pravidelnost">
              <option value="A">Pravidelný</option>
              <option value="N">Nepravidelný</option>
          </select>
      </div>

      <div class="input-prepend">
        <label class="control-label">    Kategória:         </label>
            <select name="polozka-id" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
                    @foreach ($polozky as $polozka)
                        <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                   @endforeach
            </select>
      </div>

      <div class="input-prepend">
         <label class="control-label">    Hodnota výdavku:  </label>
          <input name="hodnota" class="span4" type="text">
      </div>
      


      <button type="reset" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš
      </button>

      <button type="submit" class="btn btn-primary">
            <i class="icon-ok icon-white"></i>
                Pridaj
      </button>

{{ Form::close() }}


@include('foot')
