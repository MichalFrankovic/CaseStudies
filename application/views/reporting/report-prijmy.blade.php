@layout('layouts.base')

@section('styles')
    
    {{ HTML::style('assets/css/bootstrap-editable.css') }}
    <style>
        .information{
            padding: 20px;
            margin-bottom: 20px;
        }
        .information.success{
            background: rgba(0, 255, 0, .3);
        }
        .information.error{
            background: rgba(255, 0, 0, .3);
        }
        .filterbutton{
            margin: 30px 20px 0px 10px;
            position: relative;
            left:310px;
            /*bottom:-10px;*/
        }
    </style>
    <style type="text/css">
        td {text-align: center !important;}

        .uzsi {width: 50% !important;}
    </style>
@endsection

@section('scripts')

{{ HTML::script('assets/js/bootstrap-editable.js') }}
<script>

$(document).ready(function(){
  	// Datepicker
		$('.datepicker').datepicker({
			format	: 'mm/dd/yyyy',
			weekStart:	1
		});

</script>

<?php
  
  $osoba2 = Input::get('osoba');
  $styp = Input::get('typ_prijmu');
?>

@endsection

@section('content')

@include('reporting.reporting-submenu')

<div class="whole" id="1" style="float:left;width:100%;">

{{ Form::open('reporting/report_prijmy', 'get', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
    <h4>Filter</h4>


<div class="input-prepend" style="float:left;margin-right:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum od: </span>
    <input class="span2 datepicker" type="text" name="od" value="<?php  if ($zac_datum == '') { }
                                                                        else {
                                                                              $date = new DateTime($zac_datum);
                                                                              echo $date->format('d.m.Y'); 
                                                                              }
                                                                    ?>" >
</div>
<div class="input-prepend" style="float:left;margin-right:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum do: </span>
    <input class="span2 datepicker" type="text" name="do" value="<?php 
                                                                        $date = new DateTime($kon_datum);
                                                                        echo $date->format('d.m.Y'); 
                                                                    ?>">
</div>
<div class="input-prepend">
        <span class="add-on" style="width:120px;text-align:left;padding-left:10px">Časová jednotka </span>
    <select name="zob_typ"  class="span2">
        <option value="cel" selected="selected">Celkové</option>
        <option value="mes" <?php if ($zob_typ == 'mes') echo "selected='selected'"; ?>>Mesačne</option>
    </select>
</div>
<div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Osoba: </span>
    <select name="osoba"  class="span2">
        <option value="all" selected="selected">VŠETCI</option>
        @foreach ($persons as $osoba)
        <option value="{{ $osoba->id }}" <?php if($osoba->id==$osoba2){echo 'selected="selected"';}?>> {{ $osoba->t_meno_osoby }}&nbsp;{{ $osoba->t_priezvisko_osoby }}</option>
        @endforeach
    </select>
 </div>

<div class="filterbutton" >
    <a class="btn btn-primary" href="{{ URL::to('reporting/report_prijmy') }}" ><i class="icon-remove icon-white"></i>Vynulovať filter</a>
       
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Zobrazovať	</button>
</div>

</div>
{{ Form::close() }}


<form id="form1" name="form2" method="get">
	
    <table class="table table-bordered">
        
                
    <?php 

    $suma = 0;

    if ($zob_typ == 'cel') {

    $pocet = 0;
    echo "<THEAD>
            <TR>
                <TH style='width:250px'> Osoby </TH>
                <TH> Suma prijmov             </TH>
            </TR>
          </THEAD>";

            foreach ($select1 as $key => $value) {
                echo '<tr>
                        <td> '.$value->meno_osoby.'         </td>
                        <td> '.round($value->suma_prijmu,2).' € </td>
                      </tr>
                    ';
                $pocet++;
                $suma = $suma + $value->suma_prijmu;
            }


        // Vypísanie aj prázdnych kategórií
        $z=0;
        
        if (Input::get('osoba') && Input::get('osoba') !=='all'){
            $porovnaj = Input::get('osoba');
            $dopln = 0;
            
            foreach ($select1 as $key => $value) {
                    $porovnaj2 = $value->id;
                    if ($porovnaj == $porovnaj2) {}
                    else {
                         
                            $dopln++;}
                    }
            
                    
                    if ($dopln == $pocet){
                        foreach ($persons as $osoba) {
                            if ($osoba->id==$porovnaj){
                                         
                        echo '
                        <tr>
                            <td>'.$osoba->t_meno_osoby.' '.$osoba->t_priezvisko_osoby.'  </td>
                            <td> 0 €            </td>
                            
                        </tr>'; }}}

        }
        else {
            foreach ($vsetciosoby as $key => $value) {
                $porovnaj1 = $vsetciosoby[$z]->meno_osoby;
                $dopln = 0;

                foreach ($select1 as $key => $value) {
                    $porovnaj2 = $value->meno_osoby;
                    
                    if ($porovnaj1 == $porovnaj2) {}
                        else {$dopln++;}    // Nezhoduje sa ani v 1 prípade
                }

                if ($dopln == $pocet) echo '
                            <tr>
                                <td>'.$porovnaj1.'  </td>
                                <td> 0 €            </td>
                            </tr>';
                
        $z++;
        }
         echo '<tr class="info" style="font-weight:bold;">
         <td> CELKOVÁ SUMA:          </td>
         <td> '.round($suma,2).'     </td>
      </tr>';
    }



    }

    if ($zob_typ == 'mes') {
                echo " 
                            <thead>
                                
                                <TR>
                                    <TH> Osoby </TH>
                                    <TH> Január     </TH>
                                    <TH> Február    </TH>
                                    <TH> Marec      </TH>
                                    <TH> Apríl      </TH>
                                    <TH> Máj        </TH>
                                    <TH> Jún        </TH>
                                    <TH> Júl        </TH>
                                    <TH> August     </TH>
                                    <TH> September  </TH>
                                    <TH> Október    </TH>
                                    <TH> November   </TH>
                                    <TH> December   </TH>
                                </TR>
                                
                            </thead>

                           "; 
                                          
    $i=0; 

            $sum_za_januar=0;
            $sum_za_februar=0;
            $sum_za_marec=0;
            $sum_za_april=0;
            $sum_za_maj=0;
            $sum_za_jun=0;
            $sum_za_jul=0;
            $sum_za_august=0;
            $sum_za_september=0;
            $sum_za_oktober=0;
            $sum_za_november=0;
            $sum_za_december=0;

    $data = array();

    $pocet=0;
    foreach ($select2 as $row) {
        $data[ $row->meno_osoby ][] = $row;
        }

    $op = array();

    foreach ($data as $daco) {

            $januar=0;
            $februar=0;
            $marec=0;
            $april=0;
            $maj=0;
            $jun=0;
            $jul=0;
            $august=0;
            $september=0;
            $oktober=0;
            $november=0;
            $december=0;

        foreach ($daco as $x) {
            
                //echo $x->suma_vydavkov;
                //echo "<BR>";
                $op[$i]['suma'] = $x->suma_prijmu;
                $op[$i]['meno'] = $x->meno_osoby;
                $op[$i]['mesiac'] = $x->mesiac;

                if (($x->mesiac) == 'January') $januar = round($x->suma_prijmu,2); 
                if (($x->mesiac) == 'February') $februar = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'March') $marec = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'April') $april = round($x->suma_prijmu,2); 
                if (($x->mesiac) == 'May') $maj = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'June') $jun = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'July') $jul = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'August') $august = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'September') $september = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'October') $oktober = round($x->suma_prijmu,2); 
                if (($x->mesiac) == 'November') $november = round($x->suma_prijmu,2);
                if (($x->mesiac) == 'December') $december = round($x->suma_prijmu,2);

                $i++;
                  
                $pocet++;
                }
             
                echo '  <tr>
                        <td width="250px">'.$op[$i-1]['meno'].'  </td>
                        <td> '.$januar.' €              </td>
                        <td> '.$februar.' €             </td>
                        <td> '.$marec.' €               </td>
                        <td> '.$april.' €               </td>
                        <td> '.$maj.' €                 </td>
                        <td> '.$jun.' €                 </td>
                        <td> '.$jul.' €                 </td>
                        <td> '.$august.' €              </td>
                        <td> '.$september.' €           </td>
                        <td> '.$oktober.' €             </td>
                        <td> '.$november.' €            </td>
                        <td> '.$december.' €            </td>

                      </tr>';

                $sum_za_januar = $sum_za_januar + $januar;
                $sum_za_februar = $sum_za_februar + $februar;
                $sum_za_marec = $sum_za_marec + $marec;
                $sum_za_april = $sum_za_april + $april;
                $sum_za_maj = $sum_za_maj + $maj;
                $sum_za_jun = $sum_za_jun + $jun;
                $sum_za_jul = $sum_za_jul + $jul;
                $sum_za_august = $sum_za_august + $august;
                $sum_za_september = $sum_za_september + $september;
                $sum_za_oktober = $sum_za_oktober + $oktober;
                $sum_za_november = $sum_za_november + $november;
                $sum_za_december = $sum_za_december + $december;
                
                }
                
    $z=0;
     if (Input::get('osoba') && Input::get('osoba') !=='all'){
            $porovnaj = Input::get('osoba');
            $dopln = 0;
            
            foreach ($select1 as $key => $value) {
                    $porovnaj2 = $value->id;
                    if ($porovnaj == $porovnaj2) {}
                    else {
                         
                            $dopln++;}
                    }
            
                    
                    if ($dopln == $pocet){
                        foreach ($persons as $osoba) {
                            if ($osoba->id==$porovnaj){
                                         
                        echo '
                        <tr>
                            <td style="width:50px;">'.$osoba->t_meno_osoby.' '.$osoba->t_priezvisko_osoby.'  </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            
                        </tr>'; }}}
    }
    else {
        foreach ($vsetciosoby as $key => $value) {
        $porovnaj1 = $vsetciosoby[$z]->meno_osoby;
        $dopln = 0;

            for ($i=0; $i < $pocet ; $i++) { 
                $porovnaj2 = $op[$i]['meno'];
                
                    if ($porovnaj1 == $porovnaj2) {}
                    else {$dopln++;}    // Nezhoduje sa ani v 1 prípade
              }

            if ($dopln == $pocet) echo '
                        <tr>
                            <td>'.$porovnaj1.'  </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                            <td> 0 €            </td>
                        </tr>';
             $z++;
    
        }
          echo '<tr class="info" style="font-weight:bold; font-size:13px;">
                <td> SUM ZA MESIAC:             </td>
                <td> '.$sum_za_januar.' €       </td>
                <td> '.$sum_za_februar.' €      </td>
                <td> '.$sum_za_marec.' €        </td>
                <td> '.$sum_za_april.' €        </td>
                <td> '.$sum_za_maj.' €          </td>
                <td> '.$sum_za_jun.' €          </td>
                <td> '.$sum_za_jul.' €          </td>
                <td> '.$sum_za_august.' €       </td>
                <td> '.$sum_za_september.' €    </td>
                <td> '.$sum_za_oktober.' €      </td>
                <td> '.$sum_za_november.' €     </td>
                <td> '.$sum_za_december.' €     </td>
                </tr>';
    }
}


                

                           ?>

        
	</table>
</form>

</div>



@endsection
