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
	</style>
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
		// Datepicker
		$('.datepicker').datepicker({
			format	: 'mm/dd/yyyy',
			weekStart:	1
		});
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
		$('.btn-danger').click(function(){
			return confirm("Ste si istý, že chcete zmatať tento príjem?");
		})
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
			'sources'	=> 'Zdroje príjmov',
			'partners'	=> 'Partneri',
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
		<div class="information {{ Session::get('status_class') }}">
			{{ Session::get('status') }}
		</div>
	@endif

	{{ Form::open('/incomes', 'POST', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
    <h4>Datum</h4>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Od: </span>
        <input class="span3 datepicker" type="text" name="od" ">
    </div>
    <div class="input-prepend">
    <span class="add-on">Do: </span>
    <input class="span3 datepicker" type="text" name="do" ">
</div>
 <div class="input-prepend">
        <span class="add-on">Zdroj prijmu: </span>
    <select name="zdroj" class="span3">
        <option value="all" selected="selected">VSETCI</option>
        @foreach ($sources as $source)
        <option value="{{ $source->id }}"> {{ $source->t_nazov }}</option>
        @endforeach
    </select>
     </div>
    <div class="input-prepend">

        
    <div class="submit">
        {{ Form::submit('Zobraziť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
    </div>
 </div>
	
	<table class="table table-bordered">
		<thead>
			<tr style="font-weight: bold;">
				<td>#</td>
				<td>Zdroj prijmu</td>
				<td>Vlozena suma</td>
				<td>Dátum</td>
				<td>Poznámka</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($incomes as $key => $income)
			<tr>
				<td>{{$key+1}}</td>

				<td>
					<span class="editable-popis" data-pk="{{$income->id}}" data-original-title="Zadajte popis">
						{{ $income->t_popis }}
					</span>
				</td>
				<td>
					<span class="editable-suma" data-pk="{{$income->id}}" data-original-title="Zadajte sumu">
						{{ $income->vl_suma_prijmu }}
					</span>
				</td>
				<td>
					<span class="editable-datum" data-pk="{{$income->id}}" data-original-title="Zadajte dátum">
						{{ date('d.m.Y', strtotime($income->d_datum)) }}
					</span>
				</td>

				<td>
					<span class="editable-poznamka" data-pk="{{$income->id}}" data-original-title="Zadajte poznámku">
						{{ $income->t_poznamka }}
					</span>
				</td>
				<td>
					<a class="btn btn-danger" href="{{ URL::to('incomes/delete/'.$income->id) }}">Odstranit</a>
				</td>
			</tr>
			@endforeach
		</tbody>
		
	</table>
@endsection