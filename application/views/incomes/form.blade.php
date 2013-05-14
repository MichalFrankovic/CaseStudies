@layout('layouts.base')

@if(Session::get('message'))
        <div class=" {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@section('styles')
	<style type="text/css">
		.btn.btn-primary{ 
			margin-top: 15px;
			margin-left: 180px; 
		}

		.input-prepend,.tlacidla,.input-xxlarge 
		{
			margin-bottom: 10px !important;
			margin-left: 40px !important;
		}

		.control-group, .error {margin-bottom: 0px !important;}

		.input-prepend {vertical-align: inherit !important;}
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


<script>
	$(document).ready(function()
		{
		var inputs = $(' textarea[title]');
			inputs.bind('focus',function()
				{
		var object = $(this);
	if(object.val() == object.attr('title'))
					{
						object.val('');
					}
				}
			);
			
		inputs.bind
			('blur',function()
				{
		var object = $(this);
	if(object.val() == '')
			{
				object.val(object.attr('title'));
			}
		}
			);
	inputs.trigger('blur');
		}
	);
</script>

<div <?php if(!isset($error)) echo 'class=""';?>  {{ isset($errors->id_osoba) || (is_array($errors) && isset($errors['id_osoba'])) ? ' class="control-group error"' : '' }}>
	<div class="input-prepend">

        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Osoba: </span>
		<span style="padding:px 600px 0px;"><select name='id_osoba' class='input-xlarge'>
			    
             <option value="Nezaradený" selected="selected">Vyber</option>

			      	@foreach ($osoby as $osoba)
			      	<option value="{{ $osoba->id }}" @if ((isset($meneny_osoba)) AND ($osoba->id == $meneny_osoba))
	                                                selected="selected" @endif 
                                                     @if ((isset($editacia[0]->id_osoba)) AND ($osoba->id == $editacia[0]->id_osoba))
	                                                selected="selected" @endif > {{$osoba->t_priezvisko_osoby}} {{$osoba->t_meno_osoby}} 

			      	</option>
			      	
			      	@endforeach
			     </select>
    </div>

	{{ isset($errors->id_osoba) || (is_array($errors) && isset($errors['id_osoba'])) ? '<span class="help-inline">'.$errors['id_osoba'].'</span>' : '' }}

</div>


<div   {{ isset($errors->id_typ_prijmu) || (is_array($errors) && isset($errors['id_typ_prijmu'])) ? ' class="control-group error"' : '' }}>
    <div class="input-prepend">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px"> Typ príjmu: </span>
			<select name='id_typ_prijmu' class='input-xlarge'>
             <option value="Nezaradený" selected="selected"> Vyber </option>

			      	@foreach ($typ_prijmu as $typ)
			      	<option value="{{ $typ->id }}"@if ((isset($meneny_typ)) AND ($typ->id == $meneny_typ))
	                                                selected="selected" @endif 

                                                  @if ((isset($editacia[0]->id_typ_prijmu)) AND ($typ->id == $editacia[0]->id_typ_prijmu))
	                                                selected="selected" @endif > {{$typ->t_nazov_typu}} 

			      	</option>
			      	
			      	@endforeach
			 </select>
    </div>

    {{ isset($errors->id_typ_prijmu) || (is_array($errors) && isset($errors['id_typ_prijmu'])) ? '<span class="help-inline">'.$errors['id_typ_prijmu'].'</span>' : '' }}

</div> 


<div <?php if(!isset($error)) echo 'class=""';?>  {{ isset($errors->d_datum) || (is_array($errors) && isset($errors['d_datum'])) ? ' class="control-group error"' : '' }}>
  	<div class="input-prepend"> 
		<span  class="add-on" style="width:80px;text-align:left;padding-left:10px;"> Dátum <i class="icon-calendar" style="margin-left:20px;"> </i> </span>
					  	
		<input  name="d_datum" class="datepicker input-small" type="text"  value="<?php if (isset($meneny_datum))
																						  {
                                                                                     		echo $meneny_datum; 
                                                                                     	  }

                                                                                     elseif (isset($editacia[0]->d_datum)) {
																	  					$x = $editacia[0]->d_datum;
																	  					$x = date('m.d.Y');
																	  	 				echo $x;
																	  	 			}
					  	 														?> ">
	</div>
    {{ isset($errors->d_datum) || (is_array($errors) && isset($errors['d_datum'])) ? '<span class="help-inline">'.$errors['d_datum'].'</span>' : '' }}
</div>
	  	
		

<div <?php if(!isset($error)) echo 'class=""';?>  {{ isset($errors->vl_suma_prijmu) || (is_array($errors) && isset($errors['vl_suma_prijmu'])) ? ' class="control-group error"' : '' }}>

	<div class="input-prepend" >
		<span  class="add-on" style="width:80px;text-align:left;padding-left:10px;"> Suma € </span>
				  	
			<input class="input-small" type="text" value="<?php if (isset($meneny_suma))
                                                                 echo $meneny_suma;
																 elseif (isset($editacia[0]->vl_suma_prijmu)) echo $editacia[0]->vl_suma_prijmu; ?>" name="vl_suma_prijmu"> </input>
	</div>
                
    {{ isset($errors->vl_suma_prijmu) || (is_array($errors) && isset($errors['vl_suma_prijmu'])) ? '<span class="help-inline" style="display:inline" >'.$errors['vl_suma_prijmu'].'</span>' : '' }}
</div>

		
<div  <?php if(!isset($error)) echo 'class="control-group"';?>  {{ isset($errors->id_obchodny_partner) || (is_array($errors) && isset($errors['id_obchodny_partner'])) ? ' class="control-group error"' : '' }}>				
    <div class="input-prepend" >
		<span class="add-on" style="width:80px;text-align:left;padding-left:10px"> Zdroj príjmu: </span>
		<span style="padding:px 600px 0px;">
			<select name='id_zdroj_prijmu' class='input-xlarge'>
                <option value="Nezaradený" selected="selected"> Vyber </option>
			      	@foreach ($zdroj_prijmu as $zdroj)
			      	<option value="{{ $zdroj->id }}"  @if ((isset($meneny_zdroj)) AND ($zdroj->id == $meneny_zdroj))
	                                                selected="selected" @endif 
	                                                
                                                    @if ((isset($editacia[0]->id_obchodny_partner)) AND ($zdroj->id == $editacia[0]->                                                     id_obchodny_partner))
	                                                selected="selected" @endif > {{$zdroj->t_nazov}} 

			      	</option>
			      	
			      	@endforeach
			</select>
    </div>

	{{ isset($errors->id_obchodny_partner) || (is_array($errors) && isset($errors['id_obchodny_partner'])) ? '<span class="help-inline">'.$errors['id_obchodny_partner'].'</span>' : '' }}

</div>
			
<div>
    <textarea rows="3" cols="50" name="t_poznamka" class="input-xxlarge" placeholder="Poznámka...."><?php if (isset($editacia[0]->t_poznamka)) echo $editacia[0]->t_poznamka; ?></textarea>
</div>

<div class="tlacidla">
 <?php     
if ($uprava == "ano") {
     echo ' <a  onClick="history.go(-1)">    <!-- Tento Javascript vložený kvôli IE - ekvivalent takisto history.back() -->
                <button type="button" class="btn btn-primary" style="margin-left:0px">
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
         echo ' <button type="reset" class="btn btn-primary" style="margin-left:0px">
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
</div>
      

 
</div>

@endsection