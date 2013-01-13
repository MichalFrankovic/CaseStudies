@layout('layouts.base')


@section('scripts')
<script>
function resetSourceList()
{
	$('[name=id_zdroj_prijmu]').html('<option value="">zvoľte zdroj príjmu</option>')
}

$(document).ready(function(){
	// Zmena osoby
	$('[name=id_osoba]').change(function(){
		var id = $(this).val()
		if(id == 0){
			resetSourceList();
			return;
		}

		$.ajax({
			type:	'POST',
			data:	{id: $(this).val()},
			url:	'incomes/get_source',
			success:	function(response){
				response += '<option val="0">iný</option>';
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
</script>
@endsection


@section('content')


{{ Form::open(URL::current(), 'POST', array('class'=>'form-horizontal')) }}
	<div class="control-group">
		{{ Form::label(null, 'Osoba', array('class'=>'control-label')) }}
	    <div class="controls">
	      {{ Form::select('id_osoba', $list_person) }}
	    </div>
  	</div>

  	<div class="control-group">
  		{{ Form::label(null, 'Typ príjmu', array('class'=>'control-label')) }}
  		<div class="controls">
  			{{ Form::select('typ', array(''=>'vyberte typ', 'A' => 'pravidelný', 'N' => 'nepravidelný')) }}
  		</div>
  	</div>

  	<div class="control-group">
  		{{ Form::label(null, 'Dátum', array('class'=>'control-label')) }}
  		<div class="controls">
  			{{ Form::text('d_datum', date('d.m.Y')) }}		
  		</div>
  	</div>
	
	<div class="control-group">
		{{ Form::label(null, 'Suma príjmu', array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('vl_suma_prijmu', '') }}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			{{ Form::select('id_zdroj_prijmu', array('' => 'zdroj príjmu')) }}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			{{ Form::textarea('t_poznamka', null, array('rows'=>5)) }}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			{{ Form::submit('Ulož príjem', array('class'=>'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}
@endsection