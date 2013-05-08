@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@include('spendings/sp-submenu')

{{ HTML::style('assets/css/bootstrap-editable.css') }}
{{ HTML::script('assets/js/bootstrap-editable.js') }}

<div class="thumbnail">
    <h4> Parametre: </h4>
{{ Form::open('spendings/savefromtemplate', 'POST', array('class' => '')); }}
    <table border="0" style="width: 100%;">
          <tr>
            <td>
                <div class="input-prepend">
                    <span class="add-on">   Dátum:          </span>
                    <input class="span2 datepicker" type="date" name="datum" value="<?php $x=$datum; $x = date('d.m.Y'); echo $x;?>" />
                </div>
            </td>

            <td>
                <div class="input-prepend" style="float:left">
                     <span class="add-on">  Názov šablóny:  </span>
                        <select name="sablona" class="span2">
                        @foreach ($sablony as $sablona)
                            <option value="{{ $sablona->id }}"> {{ $sablona->t_poznamka }}  </option>
                        @endforeach
                        </select>
                </div>
            </td>

            <td>
                <div class="input-prepend">
                    <span class="add-on">   Zaplatil:   </span>
                        <select name="osoba" class="span2">
                        @foreach ($osoby as $osoba)
                            <option value="{{ $osoba->id }}">{{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }} </option>
                        @endforeach
                        </select>
                </div>
            </td>

            <td>
                 <div class="input-prepend">
                    <label class="add-on">   Suma v €:   </label>
                            <input class="span2" type="text" name="nazov">
                </div>
            </td>
        </tr>

    </table>

    <button type="submit" class="btn btn-primary">
        <i class="icon-edit icon-white"></i>
            Uložiť ako výdavok
    </button>
        
</div>
{{ Form::close() }}

<HR>

<h4> Zoznam šablón výdavkov: </h4>
<form id="form1" name="form1" method="post" action="zmazsablony">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" />    </th>
                <th>    Názov           </th>
                <th>    Príjemca platby </th>
                <th>    Zaplatil        </th>
                <th>    Typ výdavku     </th>
                <th>    Pravidelnosť    </th>
                <th>    Kategória       </th>
                <th>    Suma v €        </th>
                <th>    Výber akcie     </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sablony as $sablona)
            <tr>
                <td style="text-align: center;"> <input type="checkbox" name="sablona[]" id="checkbox2" class="spendcheck" value="{{ md5($sablona->id). $secretword}}" /></td>
                <td>    {{ $sablona->t_poznamka }}                                              </td>
                <td>    {{ $sablona->prijemca }}                                                </td>
                <td>    {{ $sablona->t_priezvisko_osoby }}                                      </td>
                <td>    {{ $sablona->t_nazov_typu_vydavku }}                                    </td>
                <td>    {{ (($sablona->fl_pravidelny == 'A')? "Pravidelný" : "Nepravidelný") }} </td>
                <td>    {{ $sablona->kategoria }}                                               </td>
                <td>    {{ $sablona->vl_jednotkova_cena }} €                                    </td>
                <td style="text-align: center;">
                    <a class="btn btn-primary" href="sablona?id={{ $sablona->id }}"> Upraviť </a>
                    <a class="btn btn-danger" href="zmazsablonu?sablona={{ md5($sablona->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                        <i class="icon-remove icon-white"> </i> Vymazať </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-danger" href="#" onclick="multizmazanie('sablona[]')"><i class="icon-remove icon-white"></i>Vymazať zvolené</a>
</form>


@include('foot')