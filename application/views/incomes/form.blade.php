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


{{ Form::open_for_files(URL::current()) }}
	{{ Form::select('id_osoba', $list_person) }}
	{{ Form::select('typ', array(''=>'Vyberte typ', 'A' => 'pravidelny', 'N' => 'nepravidelny')) }}
	{{ Form::text('d_datum', date('d.m.Y')) }}
	{{ Form::text('vl_suma_prijmu', '') }}
	{{ Form::select('id_zdroj_prijmu', array('' => 'zdroj príjmu')) }}
	{{ Form::textarea('t_poznamka') }}
	{{ Form::submit('Ulož príjem', array('class'=>'btn')) }}
{{ Form::close() }}
@endsection