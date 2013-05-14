@layout('layouts.base')

@section('styles')
	
	{{ HTML::style('assets/css/bootstrap-editable.css') }}
	
@endsection

@section('scripts')
	
	{{ HTML::script('assets/js/bootstrap-editable.js') }}
	<script>
	var base = '<?=URL::to('incomes')?>';
	function resetSourceList()
	{
		$('[name=id_zdroj_prijmu]').html('<option value="">zvoľte zdroj príjmu</option>')
	}

	$(document).ready(function(){
		// Datepicker - v externom súbore už
	/*	$('.datepicker').datepicker({
			format	: 'mm/dd/yyyy',
			weekStart:	1
		});  

	*/
		// Zmena osoby
		$('[name=id_osoba]').change(function(){
			var id = $(this).val()
			if(id == 0){
				resetSourceList();
				return;
			}

			$.ajax({
				type:	'GET',
				url:	'incomes/ajaxload/incomesources/' + $(this).val(),
				success:	function(response){
					$('[name=id_zdroj_prijmu]').html( response );
				}
			})
		});

		// Zmena zdroja prijmu
		$('[name=id_zdroj_prijmu]').change(function(evt){
			var $source = $('[value='+$(this).val()+']', this);
			// change type
			$('[name=typ] option').removeAttr('selected');
			$('[name=typ] [value='+$source.attr('data-type')+']').attr('selected', 'selected');
			//
			var $sum = $('[name=vl_suma_prijmu]');
			// if($sum.val() == ''){
				$sum.val( $source.attr('data-sum'));
			// }
		});
	});

	$(document).ready(function(){
		$('#create').click(function(){

			$('#income-create').toggle();
		});
	});

	// Validacia
	$(document).ready(function(){
		$("#income-create").submit(function(evt) {
		    $.validity.start();
		    	$('[name=id_osoba], [name=d_datum], [name=vl_suma_prijmu], [name=id_zdroj_prijmu]').require();
		    	$('[name=vl_suma_prijmu]').match('number').greaterThan(0);
		    	$('[name=d_datum]').lessThanOrEqualTo(new Date());

			var result = $.validity.end();
			
			if(!result.valid){
				evt.preventDefault();
			}
		});
	});

	// Inline Editacia 
	$(document).ready(function(){
	  /*$('.btn-danger').click(function(){
		return confirm("Ste si istý, že chcete zmatať tento príjem?");
	    })*/
		//editables 
	    $('.editable-suma').editable({
			url: base + '/ajaxsave/F_PRIJEM',
			type: 'text',
			name: 'vl_suma_prijmu',
			title: 'Suma prijmu',
	    });

	    $('.editable-datum').editable({
			url: base + '/ajaxsave/F_PRIJEM',
			type: 'date',
			name: 'd_datum',
			title: 'Dátum',
			viewformat: "dd.mm.yyyy"
	    });

	    $('.editable-poznamka').editable({
			url: base + '/ajaxsave/F_PRIJEM',
			type: 'text',
			name: 't_poznamka',
			title: 'Poznámka',
	    });

	 
	});
	</script>
@endsection


@section('content')

	<ul class="nav nav-tabs">
		<?php
		$tabs = array(
			'index'	=> 'Výpis príjmov',
			'form'	=> 'Nový príjem',
					
		);
		foreach($tabs as $key => $title){
			$class = '';
			$url   = URL::to('incomes/'.$key);
			if(URI::segment(2) === $key){
				$class = 'class="active"';
			} else if(!URI::segment(2) && $key === 'index'){
				$class = 'class="active"';
			}
			echo "<li {$class}><a href='{$url}'>{$title}</a></li>";
		}
		?>
	</ul>

	@if(Session::get('status'))
		<div class=" {{ Session::get('status_class') }} ">
			{{ Session::get('status') }}
		</div>
	@endif
	
	<?php

	$zdroj = Input::get('zdroj');
	$osoba = Input::get('osoba');
	$styp = Input::get('typ_prijmu');
	?>
		
{{ Form::open('incomes/index', 'get', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
    <h4> Filter príjmov: </h4>

<div class="input-prepend">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Osoba: </span>
    <select name="osoba"  class="span2">
        <option value="all" selected="selected">VŠETKY</option>
        @foreach ($persons as $person)
        <option value="{{ $person->id }}" <?php if($person->id==$osoba){echo 'selected="selected"';}?>> {{ $person->t_priezvisko_osoby }} {{ $person->t_meno_osoby }} </option>
        @endforeach
    </select>
 </div>
    <div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum od: </span>
        <input class="span2 datepicker" type="text" name="od" value="{{ $od }}" >
    </div>
    <div class="input-prepend" style="margin-left:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum do: </span>
    <input class="span2 datepicker" type="text" name="do" value="{{ $do }}">
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
 <div class="input-prepend">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Zdroj príjmu: </span>
    <select name="zdroj"  class="span2">
        <option value="all" selected="selected">VŠETCI</option>
        @foreach ($partners as $source)
        <option value="{{ $source->id }}" <?php if($source->id==$zdroj){echo 'selected="selected"';}?>> {{ $source->t_nazov }}</option>
        @endforeach
    </select>
     </div>
       <!-- {{ Form::reset('Vynulovať filter' , array('class' => 'btn','style'=>'width:120px')); }}-->
    <a class="btn btn-primary" href="{{ URL::to('incomes/index') }}" ><i class="icon-remove icon-white"></i>Vynulovať filter</a>
       
       <!--{{ Form::submit('Zobraziť' , array('class' => 'btn btn-primary','style'=>'width:120px')); }}-->
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Zobraziť	</button>
        
 </div>
 {{ Form::close() }}
	<h3> Zoznam príjmov: </h3>
	<form id="form1" name="form1" method="get" action="multideleteincomes">

	<table class="table table-bordered">
		<thead>
			<tr style="font-weight: bold;">
				<td><input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /></td>
				<td>Osoba</td>
				<td>Typ</td>
				<td>Dátum</td>
				<td>Suma</td>
				<td>Zdroj</td>
				<td>Poznámka</td>
				<td>Výber akcie</td>
			</tr>
		</thead>
		<tbody>
			@foreach($incomes as $income)
			<tr>
				<td style="text-align: center;"><input type="checkbox" name="income[]" id="checkbox2" class="spendcheck" value="{{$income->id}}" /></td>
				<td> {{ $income->t_priezvisko_osoby }} {{ $income->t_meno_osoby }} </td>
				<td>{{ $income->t_nazov_typu }}</td>
				<td>					
					{{ date('d.m.Y', strtotime($income->d_datum)) }}
				</td>
				<td>
					{{ $income->vl_suma_prijmu }} €
				</td>
				<td>				
					{{ $income->t_nazov }}
				</td>
				
				<td>					
					{{ $income->t_poznamka }}
					
				</td>
				<td style="text-align: center;">
					<a class="btn btn-primary" href="{{ URL::to('incomes/form?id='.$income->id) }}"> Upraviť </a>
				    <a class="btn btn-danger" href="{{ URL::to('incomes/delete/'.$income->id) }}" onclick="return confirm('Naozaj chcete zmazať tento záznam?')">
				    	<i class="icon-remove icon-white"> </i> Vymazať </a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a class="btn btn-danger" href="#" onclick="multizmazanie('income[]')"><i class="icon-remove icon-white"></i>Vymazať zvolené</a>
	</form>
@endsection

