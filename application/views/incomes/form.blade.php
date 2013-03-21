@layout('layouts.base')

@section('styles')
	<style type="text/css">
	.btn.btn-primary{
		margin-left: 180px; 
	}
	</style>
	{{ HTML::style('assets/css/bootstrap-editable.css') }}
	{{ HTML::style('assets/css/jquery.validity.css') }}
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
	{{ HTML::script('assets/js/jquery.validity.js') }}
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
				url:	'ajaxload/incomesources/' + $(this).val(),
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
		<div class="information {{ Session::get('status_class') }}">
			{{ Session::get('status') }}
		</div>
	@endif

	{{ Form::open(URL::current(), 'POST', array('class'=>'form-horizontal well', 'id'=>'income-create')) }}
		<div class="control-group">
			{{ Form::label(null, 'Osoba', array('class'=>'control-label')) }}
		    <div class="controls">
		      {{ Form::select('id_osoba', $list_person, null, array('class' => ' input-xlarge')) }}
		    </div>
	  	</div>
		<div class="control-group">
			{{ Form::label(null, 'Typ prijmu', array('class'=>'control-label')) }}
		    <div class="controls">
		      {{ Form::select('id_typ_prijmu', $list_typ_prijmu, null, array('class' => ' input-xlarge')) }}
		    </div> 
	  	</div> 

	  	<div class="control-group">
	  		{{ Form::label(null, 'Dátum', array('class'=>'control-label')) }}
	  		<div class="controls">
	  			<div class="input-prepend">
				  	<span style="margin-top: 1px;" class="add-on"><i class="icon-calendar"></i></span>
				  	{{ Form::text('d_datum', date('m/d/Y'), array('class'=>'datepicker input-small')) }}
				</div>
	  		</div>
	  	</div>
		
		<div class="control-group">
			{{ Form::label(null, 'Suma príjmu', array('class'=>'control-label')) }}
			<div class="controls">
				<div class="input-prepend">
				  	<span class="add-on" value='x'>€</span>
				  	{{ Form::text('vl_suma_prijmu', '', array('class' => 'input-small', 'value' => '')) }}
				</div>
                </div>
                </div>
				<div class="control-group">
			{{ Form::label(null, 'Zdroj prijmu', array('class'=>'control-label')) }}
		    <div class="controls">
		      {{ Form::select('id_zdroj_prijmu', $list_zdroj_prijmu, null, array('class' => ' input-xlarge')) }}
		    </div>
			
		</div>
		
		<div class="control-group">
			
		</div>
		
		<div class="control-group">
			{{ Form::label(null, 'Poznámka', array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::textarea('t_poznamka', null, array('rows'=>3, 'class'=>'input-xxlarge')) }}
			</div>
		</div>
      
        
 <button type="reset" class="btn btn-primary" style="margin-left:110px" ><i class="icon-remove icon-white"></i>Zruš</button>
 <button type="submit" class="btn btn-primary"style="margin:5px"><i class="icon-ok icon-white"></i>Ulož príjem</button></span>

	{{ Form::close() }}

@endsection