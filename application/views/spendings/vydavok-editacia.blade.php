@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@include('spendings/sp-submenu')

<?php /*KVOLI ZADÁVANIU DÁTUMOV CEZ JAVASCRIPT ZA VYUŽITIA CSS ŠTÝLU */ ?>
{{ HTML::script('assets/js/bootstrap-editable.js') }}
{{ HTML::style('assets/css/bootstrap-editable.css') }}


{{ Form::open('spendings/savespending?update=1', 'POST', array('class' => 'side-by-side')); }}
<input type="hidden" name="hlavicka-id" id="idhidden" value="{{ $vydavky[0]->id }}"/>

<div class="thumbnail" style="margin-bottom:20px;">
  <h4> Editácia výdavku z dňa {{ date('d.m.Y', strtotime($vydavky[0]->d_datum)) }} </h4>
    
    <div class="input-prepend" style="float:left;width:295px">
        <span class="add-on" style="width:83px"> Dátum:          </span>
        <input name="datum" class="span2 datepicker" type="text" placeholder="Deň.Mesiac.Rok" value="{{ date('d.m.Y', strtotime($vydavky[0]->d_datum)) }}">
    </div>

    <div class="input-prepend" style="float:left;width:350px">
            <span class="add-on"> Partner:    </span>
          <select name="partner" class="span3">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}" @if ($vydavky[0]->id_obchodny_partner ==  $partner->id) selected="selected" @endif> {{ $partner->t_nazov }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
            <span class="add-on"> Zaplatila osoba:   </span>
        <select name="osoba" class="span2">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" @if ($vydavky[0]->id_osoba ==  $osoba->id) selected="selected" @endif> {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <span class="add-on">   Typ výdavku:   </span>
        <select name="typ-vydavku" class="span2">
            @foreach ($typy_vydavkov as $typ)
            <option value="{{ $typ->id }}"  @if ($vydavky[0]->id_typ_vydavku == $typ->id) selected="selected" @endif> {{ $typ->t_nazov_typu_vydavku }} </option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
            <span class="add-on" style="width:83px"> Poznámka:   </span>
            <input name="poznamka" class="span10" type="text" value="{{ $vydavky[0]->t_poznamka }}">
    </div>

  
</div>

  <h4> Položky výdavku: </h4>
  <table id="tbl-vydavky" class="table table-bordered">
    <thead>
      <tr>
          <th>                        </th>
          <th>    Položka             </th>
          <th>    Cena /ks (bez zľavy)</th>
          <th>    Počet               </th>
          <th>    Total               </th>
          <th>    Zľava               </th>
      </tr>
    </thead>

@foreach ($polozky_vydavku as $polozka_vydavku)
<tr>
 <input type="hidden" name="vydavok-id[]" id="id-hidden" value="{{ $polozka_vydavku->id }}"/>
 
  <td><a class="btn" href="deletepolozka?pol={{ md5($polozka_vydavku->id).$secretword }}&vydavokid={{ $vydavky[0]->id }}"><i class="icon-remove"></i></a></td>
    <td>
      <select name="polozka-id[]" class="span3">
              @foreach ($polozky as $polozka)
                  <option value="{{ $polozka->id }}" @if ($polozka->id == $polozka_vydavku->id_kategoria_a_produkt)
                                                          selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}
                  </option>
              @endforeach
      </select>
  </td>

  <td>
    <div class="input-append">
      <input id="cena" name="cena[]" class="span2" type="text" value="{{ number_format(round($polozka_vydavku->vl_jednotkova_cena,2),2) }}" />
      <span class="add-on">€</span>
    </div>
  </td>

  <td>
    <div class="input-append">
      <input id="mnozstvo" name="mnozstvo[]" class="span1" type="text" value="{{ $polozka_vydavku->num_mnozstvo }}" />
      <span class="add-on">m.j.</span>
    </div>
  </td>

  <td>
    <div class="input-append">
      <input id="cenapolozkykratpocet" name="cenapolozkykratpocet[]" class="span1" type="text" value="" />
      <span class="add-on">€</span>
    </div>
  </td>

  <td>
      <input name="zlava[]" class="span1" type="text" value="{{ $polozka_vydavku->vl_zlava }}" />
      <select name="typ-zlavy[]" class="span2">
        <option value="0" @if ($polozka_vydavku->fl_typ_zlavy == '') selected="selected" @endif >Bez zlavy</option>
        <option value="P" @if ($polozka_vydavku->fl_typ_zlavy == 'P') selected="selected" @endif >Zlava v %</option>
        <option value="A" @if ($polozka_vydavku->fl_typ_zlavy == 'A') selected="selected" @endif >Zlava v EUR</option>
      </select>
  </td>

 </tr>
@endforeach
  </table>

    <button type="button" class="btn btn-primary" onclick="pridaj_riadok_do_vydavkov()">
        <i class=" icon-plus icon-white"></i>
            Pridaj položku
    </button>

<HR>

    <div class="input-prepend" style="float:left; width:185px;" >
         <span class="add-on">  Hodnota zľavy:        </span>
        <input name="celkova-zlava" class="span2" type="text" value="{{ $vydavky[0]->vl_zlava }}" />
    </div>

    <div class="input-prepend" >
            <span class="add-on" style="width:93px;text-align:left;"> Typ zľavy:          </span>
        <select name="celkovy-typ-zlavy" class="span2">
            <option value="0" @if ($vydavky[0]->fl_typ_zlavy == NULL) selected="selected" @endif >  Bez zľavy   </option>
            <option value="P" @if ($vydavky[0]->fl_typ_zlavy == 'P') selected="selected" @endif >   Zľava v %   </option>
            <option value="A" @if ($vydavky[0]->fl_typ_zlavy == 'A') selected="selected" @endif >   Zľava v EUR </option>
        </select>
    </div>

    <div class="input-prepend">
         <span class="add-on">  Celková suma:         </span>
         <input id="total" class="span2" type="text"  disabled="disabled" value="{{ $vydavky[0]->suma_vydavku_po_celk_zlave }} €">
    </div>

    <div class="input-prepend">
         <span class="add-on">  Celková zľava:        </span>
         <input class="span2" type="text" disabled="disabled" value="{{ number_format(round($vydavky[0]->celkova_zlava,2),2) }}">
    </div>
    

    <button type="submit" class="btn btn-primary">
          <i class=" icon-edit icon-white"></i>
              Aktualizuj výdavok
    </button>


{{ Form::close() }}

<script>

  var js_polozky = {{ $dzejson }}

// Vypisovanie ceny pre produkt vybraný zo selectu
    $('table#tbl-vydavky').on('change', 'select.span3', function(){

        var x = $('option:selected',$(this)).attr('value');
        var sel = $(this);
        //alert('ID vybraného produktu je: ' +x);

        $.get('vyber_cenu_pre_produkt?id='+x,
            function(data) {    

    //console.log( $('input.span2', sel.closest('tr')) );

                $('#cena', sel.closest('tr')).val(data);
                //alert('Cena produktu vybraná z databázy pre tento produkt je: ' +data);
                });
    });


// ------- AK SA ZMENÍ INPUT CENA ALEBO MNOŽSTVO, TAK PREPOČÍTAJ ------- ZAČIATOK
    $('table#tbl-vydavky').on('change', '#cena', function(){
        var sel = $(this);

        var cena = $(this).val();
        var mnozstvo = $('#mnozstvo').val();

        var vysledok = (0-0);

        vysledok = ((cena*1)*(mnozstvo*1));

        $('#cenapolozkykratpocet', sel.closest('tr')).val(vysledok);
        
    });

    $('table#tbl-vydavky').on('change', '#mnozstvo', function(){
        var sel = $(this);

        var mnozstvo = $(this).val();
        var cena = $('#cena').val();
        
        var vysledok = (0-0);

        vysledok = ((cena*1)*(mnozstvo*1));

        $('#cenapolozkykratpocet', sel.closest('tr')).val(vysledok);
        
    });
// ------- AK SA ZMENÍ INPUT CENA ALEBO MNOŽSTVO, TAK PREPOČÍTAJ ------- KONIEC


// Spočítavanie celkovej ceny (total) pridaných produktov
    $('table#tbl-vydavky').live('change',function() {
        var total = 0;

          $('input#cenapolozkykratpocet').each(function () {
            var pripocitaj = $(this).val();
            total = (total-0) + (pripocitaj-0);
          });

          $('#total').val(total+" €");   // Zapíše sa do inputu s id názvom total
    });
    
</script>

@include('foot')