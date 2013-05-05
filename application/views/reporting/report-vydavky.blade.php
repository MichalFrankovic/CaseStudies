@include('head')

@include('reporting/reporting-submenu')

{{ HTML::style('assets/css/bootstrap-editable.css') }}
{{ HTML::script('assets/js/bootstrap-editable.js') }}

<style type="text/css">
td {text-align: center !important;}
</style>

<form class="side-by-side" name="tentoForm" id="aktualnyformular"  method="POST" action="report_vydavky" accept-charset="UTF-8">  
<div class="thumbnail" >
    <h4> Reporting výdavkov </h4>

    <div class="input-prepend">
		<span class="add-on" style="width:80px;text-align:left;padding-left:10px;"> Zvoľ level: </span>

		<select name='level' class="span3"> 
			<option value='level1'>	Level 1 	</option>

		</select>	
	</div>


    <div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum od: </span>
        <input class="span3 datepicker" type="text" name="od" value="<?php 
        																if ($zaciatok == '') { }
        																	else {
																				$date = new DateTime($zaciatok);
																				echo $date->format('m/d/Y'); 
																				}
																	?>">
    </div>


    <div class="input-prepend" style="margin-left:50px">
	    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum do: </span>
	    <input class="span3 datepicker" type="text" name="do" value="<?php 
																		$date = new DateTime($koniec);
																		echo $date->format('m/d/Y'); 
																	?>">
	</div>


	<div class="input-prepend">
		<span class="add-on" style="width:80px;text-align:left;padding-left:10px;"> Zobrazenie: </span>

		<select name='zobrazovanie' class="span3"> 
			<option value='celkove'> Celkové		</option>
			<option value='mesacne' <?php if ($zobrazovanie == 'mesacne') echo "selected='selected'"; ?>> Po mesiacoch 	</option>

		</select>	
	</div>

    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Zobraziť	</button>
        
 </div>
 {{ Form::close() }}

<?php
if ($zobrazovanie == 'celkove') {

	$pocet = 0;
	echo "<TABLE class='table table-bordered table-striped side-by-side'>
			<THEAD>
			<TR>
				<TH style='width:250px'> Názov kategórie	</TH>
				<TH> Suma výdavkov							</TH>
			</TR>
		</THEAD>";

			foreach ($select1 as $key => $value) {
				echo '<tr>
						<td> '.$value->t_nazov.' 	   	 </td>
						<td> '.$value->suma_vydavkov.' € </td>
					  </tr>
					';
				$pocet++;
			}


		// Vypísanie aj prázdnych kategórií
		$z=0;
		foreach ($vsetkykategorie as $key => $value) {
			$porovnaj1 = $vsetkykategorie[$z]->t_nazov;
			$dopln = 0;

				foreach ($select1 as $key => $value) {
					$porovnaj2 = $value->t_nazov;
					
					if ($porovnaj1 == $porovnaj2) {}
						else {$dopln++;}	// Nezhoduje sa ani v 1 prípade
				}

				if ($dopln == $pocet) echo '
							<tr>
								<td>'.$porovnaj1.'	</td>
								<td> 0 €			</td>
							</tr>';
				
		$z++;
		}

}


if ($zobrazovanie == 'mesacne') {

echo "
<TABLE class='table table-bordered table-striped side-by-side'>
	<THEAD>
		<TR>
			<TH> Názov	</TH>
			<TH> Január	</TH>
			<TH> Február	</TH>
			<TH> Marec	</TH>
			<TH> Apríl	</TH>
			<TH> Máj	</TH>
			<TH> Jún	</TH>
			<TH> Júl	</TH>
			<TH> August	</TH>
			<TH> September	</TH>
			<TH> Október	</TH>
			<TH> November	</TH>
			<TH> December	</TH>
		</TR>
	</THEAD>";

 $i=0; 

	$data = array();

$pocet=0;
	foreach ($select2 as $row) {
		$data[ $row->nazov_kategorie ][] = $row;
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
				$op[$i]['suma'] = $x->suma_vydavkov;
				$op[$i]['kategoria'] = $x->nazov_kategorie;
				$op[$i]['mesiac'] = $x->mesiac;

				if (($x->mesiac) == 'January') $januar = $x->suma_vydavkov; 
				if (($x->mesiac) == 'February') $februar = $x->suma_vydavkov; 
				if (($x->mesiac) == 'March') $marec = $x->suma_vydavkov;
				if (($x->mesiac) == 'April') $april = $x->suma_vydavkov; 
				if (($x->mesiac) == 'May') $maj = $x->suma_vydavkov; 
				if (($x->mesiac) == 'June') $jun = $x->suma_vydavkov; 
				if (($x->mesiac) == 'July') $jul = $x->suma_vydavkov; 
				if (($x->mesiac) == 'August') $august = $x->suma_vydavkov; 
				if (($x->mesiac) == 'September') $september = $x->suma_vydavkov; 
				if (($x->mesiac) == 'October') $oktober = $x->suma_vydavkov; 
				if (($x->mesiac) == 'November') $november = $x->suma_vydavkov; 
				if (($x->mesiac) == 'December') $december = $x->suma_vydavkov; 

				$i++;
				  $pocet++;
				}
				
				/*echo "<pre>";
				var_dump($op);
				echo "</pre>";*/ 

			//	<td>'.$op[$i-1]['mesiac']. '</td>

				echo '<tr>
						<td>'.$op[$i-1]['kategoria'].'	</td>
						<td> '.$januar.' €				</td>
						<td> '.$februar.' €				</td>
						<td> '.$marec.' €				</td>
						<td> '.$april.' €				</td>
						<td> '.$maj.' €					</td>
						<td> '.$jun.' €					</td>
						<td> '.$jul.' €					</td>
						<td> '.$august.' €				</td>
						<td> '.$september.' €			</td>
						<td> '.$oktober.' €				</td>
						<td> '.$november.' €			</td>
						<td> '.$december.' €			</td>

					  </tr>';


					
	}
		//echo $data['BYVANIE'][1]->mesiac;


// Vypísanie aj prázdnych kategórií
	$z=0;
	foreach ($vsetkykategorie as $key => $value) {
		$porovnaj1 = $vsetkykategorie[$z]->t_nazov;
		$dopln = 0;

			for ($i=0; $i < $pocet ; $i++) { 
				$porovnaj2 = $op[$i]['kategoria'];
				

				if ($porovnaj1 == $porovnaj2) {}
					else {$dopln++;}	// Nezhoduje sa ani v 1 prípade
			}

			if ($dopln == $pocet) echo '
						<tr>
							<td>'.$porovnaj1.'	</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
							<td> 0 €			</td>
						</tr>';
			
	$z++;
	}

}

?>

</TABLE>


@include('foot')