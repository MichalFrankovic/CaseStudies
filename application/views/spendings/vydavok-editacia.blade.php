@include('head')

<script>var js_polozky = {{ $dzejson }}</script>
<h3 style="color: #bc2834;">{{ $message }}</h3>

@include('spendings/sp-submenu')

<h2>Jednoduchý výdavok - editácia</h2>

{{ Form::open('spendings/savespending?update=1', 'POST', array('class' => 'side-by-side')); }}

<input type="hidden" name="hlavicka-id" id="idhidden" value="{{ $vydavky[0]->id }}"/>

<div class="thumbnail">
    <h4>Parametre:</h4>
    <div class="input-prepend" style="float:left;width:295px">
        <span class="add-on"> Dátum:          </span>
        <input name="datum" class="span3 datepicker" type="text" placeholder="Deň.Mesiac.Rok" value="{{ date('d.m.Y', strtotime($vydavky[0]->d_datum)) }}">
    </div>

    <div class="input-prepend" style="float:left;width:350px">
            <span class="add-on"> Dodávateľ:  </span>
          <select name="dodavatel" class="span3">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}" @if ($vydavky[0]->id_obchodny_partner ==  $partner->id) selected="selected" @endif> {{ $partner->t_nazov }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
            <span class="add-on"> Zaplatil:   </span>
        <select name="osoba" class="span3">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" @if ($vydavky[0]->id_osoba ==  $osoba->id) selected="selected" @endif> {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
            <span class="add-on"> Poznámka:   </span>
            <input name="poznamka" class="span9" type="text" value="{{ $vydavky[0]->t_poznamka }}">
    </div>

  <HR>

  <h4>Položky výdavku</h4>
  <table id="tbl-vydavky" class="table table-bordered">
    <tr>
      <th scope="col">                        </th>
      <th scope="col">  Položka               </th>
      <th scope="col">  Cena / ks (bez zľavy) </th>
      <th scope="col">  Počet                 </th>
      <th scope="col">  Zľava                 </th>
    </tr>
    @foreach ($polozky_vydavku as $polozka_vydavku)
    <input type="hidden" name="vydavok-id[]" id="id-hidden" value="{{ $polozka_vydavku->id }}"/>
  <tr>
      <td><a class="btn" href="deletepolozka?pol={{ md5($polozka_vydavku->id).$secretword }}&vydavokid={{ $vydavky[0]->id }}"><i class="icon-remove"></i></a></td>
    <td>
      <select name="polozka-id[]" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
              @foreach ($polozky as $polozka)
                  <option value="{{ $polozka->id }}" @if ($polozka->id == $polozka_vydavku->id_kategoria_a_produkt)
                                                          selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
             @endforeach
      </select>
  </td>
    <td>
        <div class="input-append">
      <input name="cena[]" class="span2" type="text" value="{{ number_format(round($polozka_vydavku->vl_jednotkova_cena,2),2) }}" />
      <span class="add-on">€</span>
     </div>
    </td>
    <td>
      <div class="input-append">
      <input name="mnozstvo[]" class="span1" type="text" value="{{ $polozka_vydavku->num_mnozstvo }}" />
      <span class="add-on">m.j.</span>
       </div>
     </td>
    <td>
      <input name="zlava[]" class="span1" type="text" value="{{ $polozka_vydavku->vl_zlava }}" />
      <select name="typ-zlavy[]" class="span2">
        <option value="0" @if ($polozka_vydavku->fl_typ_zlavy == '') selected="selected" @endif >Bez z&lcaron;avy</option>
        <option value="P" @if ($polozka_vydavku->fl_typ_zlavy == 'P') selected="selected" @endif >Z&lcaron;ava v %</option>
        <option value="A" @if ($polozka_vydavku->fl_typ_zlavy == 'A') selected="selected" @endif >Z&lcaron;ava v EUR</option>
      </select>
    </td>
  </tr>
    @endforeach
  </table>

    <button type="button" class="btn btn-primary" onclick="pridaj_riadok_do_vydavkov()">
        <i class=" icon-edit icon-white"></i>
            Pridaj položku
    </button>

    <HR>

    <div>
         <p>Celková zľava</p>
    </div>
    <div class="input-prepend" style="float:left; width:185px;" >
         <span class="add-on">  Hodnota zľavy:        </span>
        <input name="celkova-zlava" class="span1" type="text" value="{{ $vydavky[0]->vl_zlava }}" />
    </div>
    <div class="input-prepend" >
            <span class="add-on"> Typ zľavy:          </span>
        <select name="celkovy-typ-zlavy" class="span2">
            <option value="0" @if ($vydavky[0]->fl_typ_zlavy == NULL) selected="selected" @endif >  Bez zľavy   </option>
            <option value="P" @if ($vydavky[0]->fl_typ_zlavy == 'P') selected="selected" @endif >   Zľava v %   </option>
            <option value="A" @if ($vydavky[0]->fl_typ_zlavy == 'A') selected="selected" @endif >   Zľava v EUR </option>
        </select>
    </div>

    <div class="input-prepend">
         <span class="add-on">  Celková suma:         </span>
         <input class="span3" type="text"  disabled="disabled" value="{{ number_format(round($vydavky[0]->suma_vydavku_po_celk_zlave,2),2) }}">
    </div>
    <div class="input-prepend">
         <span class="add-on">  Celková zľava:        </span>
         <input class="span3" type="text" disabled="disabled" value="{{ number_format(round($vydavky[0]->celkova_zlava,2),2) }}">
    </div>
    <hr>
    <div>
         <input type="submit" class="btn" value="Aktualizovať produkt" />
    </div>

{{ Form::close() }}

</div>


@include('foot')
