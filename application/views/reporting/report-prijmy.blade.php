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
            left:45px;
            bottom:-10px;
        }
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
    <select name="typ_zob"  class="span2">
        <option value="m" selected="selected">Mesačne</option>
        <option value="s" >Štvrťročne</option>
        <option value="p" >Polročne</option>
        <option value="r" >Ročne</option>
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
<div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Typ príjmu: </span>
    <select name="typ_prijmu"  class="span2">
        <option value="all" selected="selected">VŠETKY</option>
        @foreach ($typy as $typ)
        <option value="{{ $typ->id }}" <?php if($typ->id==$styp){echo 'selected="selected"';}?>> {{ $typ->t_nazov_typu }}</option>
        @endforeach
    </select>
 </div>
<div class="filterbutton" >
       <!-- {{ Form::reset('Vynulovať filter' , array('class' => 'btn','style'=>'width:120px')); }}-->
    <a class="btn btn-primary" href="{{ URL::to('reporting/report_prijmy') }}" ><i class="icon-remove icon-white"></i>Vymaž filter</a>
       
       <!--{{ Form::submit('Zobraziť' , array('class' => 'btn btn-primary','style'=>'width:120px')); }}-->
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Aplikuj filter	</button>
    </div>
</div>
{{ Form::close() }}


<form id="form1" name="form2" method="get" >
	
    <table class="table table-bordered">
        
                
                <?php echo " 
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

                if (($x->mesiac) == 'January') $januar = $x->suma_prijmu; 
                if (($x->mesiac) == 'February') $februar = $x->suma_prijmu; 
                if (($x->mesiac) == 'March') $marec = $x->suma_prijmu;
                if (($x->mesiac) == 'April') $april = $x->suma_prijmu; 
                if (($x->mesiac) == 'May') $maj = $x->suma_prijmu; 
                if (($x->mesiac) == 'June') $jun = $x->suma_prijmu; 
                if (($x->mesiac) == 'July') $jul = $x->suma_prijmu; 
                if (($x->mesiac) == 'August') $august = $x->suma_prijmu; 
                if (($x->mesiac) == 'September') $september = $x->suma_prijmu; 
                if (($x->mesiac) == 'October') $oktober = $x->suma_prijmu; 
                if (($x->mesiac) == 'November') $november = $x->suma_prijmu; 
                if (($x->mesiac) == 'December') $december = $x->suma_prijmu; 

                $i++;
                  
                $pocet++;
                }
             
                echo '  <tr>
                        <td>'.$op[$i-1]['meno'].'  </td>
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
                }
                
    $z=0;
    if (Input::get('osoba')){
                /*$porovnaj = Input::get('osoba')//->t_meno_osoby
                 echo '$porovnaj';   
                    /*echo '
                        <tr>
                            <td>'.$porovnaj.'  </td>
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
                        </tr>';*/
    }
    else {
    foreach ($vsetciosoby as $key => $value) {
        $porovnaj1 = $vsetciosoby[$z]->t_meno_osoby;
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
}


                

                           ?>

        
	</table>
</form>

</div>



@endsection
