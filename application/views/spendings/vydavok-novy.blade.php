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

{{ Form::open('spendings/savespending', 'POST', array('class' => 'side-by-side')); }}
<input type="hidden" name="hlavicka-id" id="hidden" value="N"/>

<div class="thumbnail" style="margin-bottom:20px;">
    <h4>Parametre:</h4>

    <div class="input-prepend" style="float:left;width:295px">
        <span class="add-on" style="width:83px">   Dátum:            </span>
        <input name="datum" class="span2 datepicker" type="text" placeholder="Deň.Mesiac.Rok" value="{{ date('d.m.Y') }}">
    </div>

    <div class="input-prepend" style="float:left;width:350px">
        <span class="add-on">   Partner - príjemca:          </span>
        <select name="partner" class="span2">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}"> {{ $partner->t_nazov }} </option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <span class="add-on">   Zaplatila osoba:   </span>
        <select name="osoba" class="span2">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" > {{$osoba->t_priezvisko_osoby }} {{ $osoba->t_meno_osoby }} </option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <span class="add-on">   Typ výdavku:   </span>
        <select name="typ-vydavku" class="span2">
            @foreach ($typy_vydavkov as $typ)
            <option value="{{ $typ->id }}" > {{ $typ->t_nazov_typu_vydavku }} </option>
            @endforeach
        </select>
    </div>

    <div class="input-prepend">
        <span class="add-on" style="width:83px">   Poznámka:   </span>
        <input name="poznamka" class="span10" type="text" value="">
    </div>
</div>
    

    <h4> Položky výdavku: </h4>

    <table id="tbl-vydavky" class="table table-bordered" >
        <thead>
            <tr>
                <th>                        </th>
                <th>    Položka             </th>
                <th>    Cena /ks (bez zľavy)</th>
                <th>    Množstvo            </th>
                <th>    Zľava               </th>
                <th>    Total               </th>
            </tr>
        </thead>

        <input type="hidden" name="vydavok-id[]" id="hidden" value="N"/>

        <tr>
            <td><a class="btn" href=""><i class="icon-remove"></i></a></td>
            
            <td>
                <select name="polozka-id[]" class="span3 trieda_polozky">
                    @foreach ($polozky as $polozka)
                    <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <div class="input-append">
                    <input name="cena[]" class="span2 trieda_cena" type="text" value="" />
                    <span class="add-on">€</span>
                </div>
            </td>

            <td>
                <div class="input-append">
                    <input name="mnozstvo[]" class="span1 trieda_mnozstvo" type="text" value="1" />
                    <span class="add-on">m.j.</span>
                </div>
            </td>

            <td>
                <input name="zlava[]" class="span1  trieda_zlava" type="text" value="0" />
                <select name="typ-zlavy[]" class="span2">
                    <option value="0" > Bez zlavy   </option>
                    <option value="P">  Zlava v %   </option>
                    <option value="A">  Zlava v EUR </option>
                </select>
            </td>

            <td>
                <div class="input-append">
                    <input name="total[]" class="span1 trieda_total" type="text" value="" />
                    <span class="add-on">€</span>
                </div>
            </td>
        </tr>
    </table>

    <button type="button" class="btn btn-primary" onclick="pridaj_riadok_do_vydavkov()">
        <i class=" icon-plus icon-white"></i>
            Pridaj položku
    </button>


    <HR>

        <div class="input-prepend">
            <span class="add-on">Hodnota zľavy: </span>
            <input name="celkova-zlava" class="span2" type="text" value="0" />
        </div>

        <div class="input-prepend">
            <span class="add-on" style="width:93px;text-align:left;">Typ zľavy: </span>
            <select name="celkovy-typ-zlavy" class="span2">
                <option value="0" >Bez zľavy</option>
                <option value="P" >Zľava v %</option>
                <option value="A" >Zľava v EUR</option>
            </select>
        </div>
       
        <div class="input-prepend">
            <span class="add-on">Celková suma: </span>
            <input id="celkova_suma" class="span2" type="text"  disabled="disabled">
        </div>

        <div class="input-prepend">
            <span class="add-on">Celková zľava: </span>
            <input class="span2" type="text" disabled="disabled">
        </div>


    <button type="submit" class="btn btn-primary">
        <i class=" icon-edit icon-white"></i>
            Ulož výdavok
    </button>


{{ Form::close() }}

<script>

    var js_polozky = {{ $dzejson }}

// Vypisovanie ceny pre produkt vybraný zo selectu
    $('table#tbl-vydavky').on('change', 'select.trieda_polozky', function(){

        var x = $('option:selected',$(this)).attr('value');
        var sel = $(this);
        //alert('ID vybraného produktu je: ' +x);

        $.get('vyber_cenu_pre_produkt?id='+x,
            function(data) {    

    //console.log( $('input.span2', sel.closest('tr')) );

                $('input.trieda_cena', sel.closest('tr')).val(data);
                //alert('Cena produktu vybraná z databázy pre tento produkt je: ' +data);
                });
    });


// ------- AK SA ZMENÍ INPUT CENA, MNOŽSTVO ALEBO ZĽAVA, TAK PREPOČÍTAJ ------- ZAČIATOK
    $('table#tbl-vydavky').on('change', 'input.trieda_cena', function(){
        var sel = $(this);

        var cena = $(this).val();
        var mnozstvo = $('input.trieda_mnozstvo', $(this).closest('tr')).val();
        var zlava = $('input.trieda_zlava', $(this).closest('tr')).val();
   
        var vysledok = (0-0);

        vysledok = ((cena*1)*(mnozstvo*1) - zlava);

        console.log(vysledok);

        $('input.trieda_total', sel.closest('tr')).val(vysledok);
        
    });

    $('table#tbl-vydavky').on('change', 'input.trieda_mnozstvo', function(){
        var sel = $(this);

        var mnozstvo = $(this).val();
        var cena = $('input.trieda_cena', $(this).closest('tr')).val();
        var zlava = $('input.trieda_zlava', $(this).closest('tr')).val();
        
        var vysledok = (0-0);

        vysledok = ((cena*1)*(mnozstvo*1) - zlava);

        $('input.trieda_total', sel.closest('tr')).val(vysledok);
        
    });

    $('table#tbl-vydavky').on('change', 'input.trieda_zlava', function(){
        var sel = $(this);

        var zlava = $(this).val();
        var cena = $('input.trieda_cena', $(this).closest('tr')).val();
        var mnozstvo = $('input.trieda_mnozstvo', $(this).closest('tr')).val();
        
        var vysledok = (0-0);

        vysledok = ((cena*1)*(mnozstvo*1) - zlava);

        $('input.trieda_total', sel.closest('tr')).val(vysledok);
        
    });
// ------- AK SA ZMENÍ INPUT CENA, MNOŽSTVO ALEBO ZĽAVA, TAK PREPOČÍTAJ ------- KONIEC


// Spočítavanie celkovej ceny (total) pridaných produktov
    $('table#tbl-vydavky').live('change',function() {
        var total = 0;

        // Spočítaj pre všetky položky ich koncové sumy - total
          $('input.trieda_total').each(function () {
            var pripocitaj = $(this).val();
            total = (total-0) + (pripocitaj-0);
          });

          $('#celkova_suma').val(total+" €");   // Zapíše sa do inputu s id="celkova_suma"
    });

</script>

@include('foot')