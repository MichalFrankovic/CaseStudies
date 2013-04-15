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

		if ($uprava == 'nie') {
			$tabs = array(
				'index'	=> 'Výpis príjmov',
				'form'	=> 'Nový príjem',
			);
		}

		if ($uprava == 'ano') {
			$tabs = array(
				'index'	=> 'Výpis príjmov',
				'form'	=> 'Uprav príjem', 
				);
		}

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



@if ($uprava == 'ano')
	<form class="form-horizontal well" id="income-create" method="POST" action="form?editacia=ano&id={{ $editacia[0]->id }}" accept-charset="UTF-8">
@endif

@if ($uprava == 'nie')
	<form class="form-horizontal well" id="income-create" method="POST" action="{{ URL::to('incomes/form?editacia=nie') }}" accept-charset="UTF-8">
@endif

		<div class="control-group">
			{{ Form::label(null, 'Osoba', array('class'=>'control-label')) }}
		    <div class="controls">
		      	
			    <select name='id_osoba' class='input-xlarge'>
			      	@foreach ($osoby as $osoba)
			      	<option value="{{ $osoba->id }}" @if ((isset($editacia[0]->id_osoba)) AND ($osoba->id == $editacia[0]->id_osoba))
	                                                selected="selected" @endif > {{$osoba->t_meno_osoby}} {{$osoba->t_priezvisko_osoby}}

			      	</option>
			      	
			      	@endforeach
			     </select>
		         	
		    </div>
	  	</div>


		<div class="control-group">
			{{ Form::label(null, 'Typ príjmu', array('class'=>'control-label')) }}
		    <div class="controls">
		     <select name='id_typ_prijmu' class='input-xlarge'>
			      	@foreach ($typ_prijmu as $typ)
			      	<option value="{{ $typ->id }}" @if ((isset($editacia[0]->id_typ_prijmu)) AND ($typ->id == $editacia[0]->id_typ_prijmu))
	                                                selected="selected" @endif > {{$typ->t_nazov_typu}} 

			      	</option>
			      	
			      	@endforeach
			 </select>
		    </div> 
	  	</div> 


	  	<div class="control-group">
	  		{{ Form::label(null, 'Dátum', array('class'=>'control-label')) }}
	  		<div class="controls">
	  			<div class="input-prepend">
				  	<span style="margin-top: 1px;" class="add-on"><i class="icon-calendar"></i></span>
				  	
				  	<input class="datepicker input-small" type="text" value="<?php if (isset($editacia[0]->d_datum)) {
																  					$x = $editacia[0]->d_datum;
																  					$x = date('m/d/Y');
																  	 				echo $x;
																  	 			}
				  	 														?> ">
				  	</input>
				</div>
	  		</div>
	  	</div>
		

		<div class="control-group">
			{{ Form::label(null, 'Suma príjmu', array('class'=>'control-label')) }}
			<div class="controls">
				<div class="input-prepend">
				  	<span class="add-on" value=''>€</span>
				  	
				  	<input class="input-small" type="text" value="<?php if (isset($editacia[0]->vl_suma_prijmu)) echo $editacia[0]->vl_suma_prijmu; ?>" name="vl_suma_prijmu"> </input>
				</div>
            </div>
        </div>

		
		<div class="control-group">
			{{ Form::label(null, 'Zdroj príjmu - partner', array('class'=>'control-label')) }}
		    <div class="controls">
		      <select name='id_zdroj_prijmu' class='input-xlarge'>
			      	@foreach ($zdroj_prijmu as $zdroj)
			      	<option value="{{ $zdroj->id }}" @if ((isset($editacia[0]->id_obchodny_partner)) AND ($zdroj->id == $editacia[0]->id_obchodny_partner))
	                                                selected="selected" @endif > {{$zdroj->t_nazov}} 

			      	</option>
			      	
			      	@endforeach
			     </select>
		    </div>
			
		</div>
		
		<div class="control-group">
			
		</div>
		
		<div class="control-group">
			{{ Form::label(null, 'Poznámka', array('class'=>'control-label')) }}
			<div class="controls">
				<textarea rows="3" cols="50" name="t_poznamka" class="input-xxlarge" value=""> <?php if (isset($editacia[0]->t_poznamka)) echo $editacia[0]->t_poznamka; ?> </textarea>
			</div>
		</div>
      
        
 <button type="reset" class="btn btn-primary" style="margin-left:110px" >
 	<i class="icon-remove icon-white"> </i>	Zruš	
 </button>

 <button type="submit" class="btn btn-primary"style="margin:5px">
 	<i class="icon-ok icon-white"> </i> <?php if ($uprava == 'nie') echo 'Ulož príjem'; else echo 'Aktualizuj príjem'; ?>
 </button>

	{{ Form::close() }}

@endsection