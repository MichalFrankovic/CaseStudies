@include('head')
<script>var js_polozky = {{ $dzejson }}</script>
<h3 style="color: #bc8f8f;">{{ $message }}</h3>
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Jednoduchý výdavok</h2>
{{ Form::open('spendings/savespending', 'POST', array('class' => 'side-by-side')); }}
<input type="hidden" name="hlavicka-id" id="hidden" value="N"/>
<div class="thumbnail">
    <h4>Syst&eacute;mov&eacute; spr&aacute;vy:</h4>
    <div class="input-prepend" style="float:left;width:295px">
        <span class="add-on">D&aacute;tum: </span>
        <input name="datum" class="span3" type="text" placeholder="Deň.Mesiac.Rok" value="{{ date('d.m.Y') }}">
    </div>
    <div class="input-prepend" style="float:left;width:350px">
        <span class="add-on">Dodávateľ: </span>
        <select name="dodavatel" class="span3">
            @foreach ($partneri as $partner)
            <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-prepend">
        <span class="add-on">Zaplatil: </span>
        <select name="osoba" class="span3">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" > {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-prepend">
        <span class="add-on">Poznámka: </span>
        <input name="poznamka" class="span10" type="text" value="">
    </div>
    <hr>
    <h4>Položky výdavku</h4>
    <table id="tbl-vydavky" class="table table-bordered" >
        <tr>
            <th scope="col"></th>
            <th scope="col">Položka</th>
            <th scope="col">Cena / ks (bez zľavy)</th>
            <th scope="col">Počet</th>
            <th scope="col">Zľava</th>
        </tr>
        <input type="hidden" name="vydavok-id[]" id="hidden" value="N"/>
        <tr>
            <td><a class="btn" href=""><i class="icon-remove"></i></a></td>
            <td>
                <select name="polozka-id[]" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
                    @foreach ($polozky as $polozka)
                    <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <div class="input-append">
                    <input name="cena[]" class="span2" type="text" value="" />
                    <span class="add-on">€</span>
                </div>
            </td>
            <td>
                <div class="input-append">
                    <input name="mnozstvo[]" class="span1" type="text" value="" />
                    <span class="add-on">m.j.</span>
                </div>
            </td>
            <td>
                <input name="zlava[]" class="span1" type="text" value="0" />
                <select name="typ-zlavy[]" class="span2">
                    <option value="0" >Bez z&lcaron;avy</option>
                    <option value="P">Z&lcaron;ava v %</option>
                    <option value="A">Z&lcaron;ava v EUR</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="button" class="btn" value="Pridať položku" onclick="pridaj_riadok_do_vydavkov()"/>
    <hr>
    <div>
        <p>Celkov&aacute; z&lcaron;ava</p>
    </div>
    <div class="input-prepend">
        <span class="add-on">Typ z&lcaron;avy: </span>
        <select name="celkovy-typ-zlavy" class="span2">
            <option value="0" >Bez z&lcaron;avy</option>
            <option value="P" >Z&lcaron;ava v %</option>
            <option value="A" >Z&lcaron;ava v EUR</option>
        </select>
    </div>
    <div class="input-prepend">
        <span class="add-on">Hodnota z&lcaron;avy: </span>
        <input name="celkova-zlava" class="span1" type="text" value="0" />
    </div>
    <div class="input-prepend">
        <span class="add-on">Celkov&aacute; suma: </span>
        <input class="span3" type="text"  disabled="disabled">
    </div>
    <div class="input-prepend">
        <span class="add-on">Celkov&aacute; z&lcaron;ava: </span>
        <input class="span3" type="text" disabled="disabled">
    </div>
    <hr>
    <div>
        <input type="submit" class="btn" value="Vytvori&tcaron; produkt" />
    </div>
    {{ Form::close() }}
    @include('foot');
