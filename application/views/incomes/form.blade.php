@layout('layouts.base')

@if(Session::get('message'))
        <div class=" {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@section('styles')
	<style type="text/css">
	.btn.btn-primary{
		margin-left: 180px; 
	}
	</style>

	{{ HTML::style('assets/css/bootstrap-editable.css') }}
	{{ HTML::style('assets/css/jquery.validity.css') }}
	
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
		

	// Validacia
	
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
		<div class=" {{ Session::get('status_class') }} ">
			{{ Session::get('status') }}
		</div>
	@endif

@if (isset($error) && $error == true)
    <div class="alert alert-error">{{ $error }}</div>
@endif

@if ($uprava == 'ano')
	<form class="form-horizontal well" id="income-create" method="POST" action="form?editacia=ano&id={{ $editacia[0]->id }}" accept-charset="UTF-8">
@endif

@if ($uprava == 'nie')
	<form class="form-horizontal well" id="income-create" method="POST" action="{{ URL::to('incomes/form?editacia=nie') }}" accept-charset="UTF-8">
@endif

		<div class="control-group" >
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
				  	
				  	<input name="datum" class="datepicker input-small" type="text" value="@if (isset($editacia[0]->d_datum)) 
																  							{{ date('d.m.Y', strtotime($editacia[0]->d_datum)) }}
				  	 																	  @endif ">
				  	</input>
				</div>
	  		</div>
	  	</div>
		

		<div <?php if(!isset($error)) echo 'class="control-group"';?>  {{ isset($errors->vl_suma_prijmu) || (is_array($errors) && isset($errors['vl_suma_prijmu'])) ? ' class="control-group error"' : '' }}>
			{{ Form::label(null, 'Suma príjmu', array('class'=>'control-label')) }}
			<div class="controls">
				<div class="input-prepend" >
				  	<span class="add-on" value=''>€</span>
				  	
				  	<input class="input-small" type="text" value="<?php if (isset($meneny_suma))
                                                                 echo $meneny_suma;
																 elseif (isset($editacia[0]->vl_suma_prijmu)) echo $editacia[0]->vl_suma_prijmu; ?>" name="vl_suma_prijmu"> </input>
				</div>
                {{ isset($errors->vl_suma_prijmu) || (is_array($errors) && isset($errors['vl_suma_prijmu'])) ? '<span class="help-inline">'.$errors['vl_suma_prijmu'].'</span>' : '' }}
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
      
  <?php     
if ($uprava == "ano") {
     echo ' <a  onClick="history.go(-1)">    <!-- Tento Javascript vložený kvôli IE - ekvivalent takisto history.back() -->
                <button type="button" class="btn btn-primary" style="margin-left:110px">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                 </button>
           </a>';

    echo '       <button type="submit" class="btn btn-primary" style="margin-left:1px">
                    <i class="icon-ok icon-white"></i>
                        Aktualizuj
                 </button>
         ';
    }      
      
  else {
         echo ' <button type="reset" class="btn btn-primary" style="margin-left:110px">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                </button>
              ';

         echo ' <button type="submit" class="btn btn-primary" style="margin-left:1px">
                    <i class="icon-ok icon-white"></i>
                        Pridaj
                </button>
              ';

        }

?>    
      
 	
 

	{{ Form::close() }}

@endsection