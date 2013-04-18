@include('head')

@include('reporting/reporting-submenu')

{{ HTML::style('assets/css/bootstrap-editable.css') }}
{{ HTML::script('assets/js/bootstrap-editable.js') }}


<form class="side-by-side" name="tentoForm" id="aktualnyformular"  method="POST" action="report_vydavky" accept-charset="UTF-8">  
<div class="thumbnail" >
    <h2> Reporting </h2>

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

       
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Zobraziť	</button>
        
 </div>
 {{ Form::close() }}


<TABLE class='table table-bordered table-striped side-by-side'>
	<THEAD>
		<TR>
			<TH>  		</TH> 
			<TH> Názov	</TH>
			<TH> Suma	</TH>
		</TR>
	</THEAD>

	<?php $i=0; ?>
	@foreach ($otazka as $kategoria)
		<tr>
			<td width='70px' style="text-align: right;"> <?php $i++; echo "Kategória ".$i. ":";  ?> </td>
			<td width='200px'> {{ $kategoria->t_nazov }} 			</td>
			<td width='400px'> {{ $kategoria->suma_vydavkov }} 	€	</td>
		</tr>

	@endforeach

</TABLE>


@include('foot')