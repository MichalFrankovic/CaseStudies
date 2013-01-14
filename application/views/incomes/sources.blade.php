@layout('layouts.base')

@section('styles')

	{{ HTML::style('assets/css/bootstrap-editable.css') }}

@endsection

@section('scripts')

	{{ HTML::script('assets/js/bootstrap-editable.js') }}
	<script>
	var base = '<?=URL::to('incomes')?>',
		inline_edit_url = '<?=URL::to('incomes/inline_edit/')?>';

	function initEditables()
	{
		//editables 
	    $('.editable-person').editable({
			url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
			source	: base + '/ajaxload/familymembers',
			type: 'select',
			name: 'id_osoba',
			title: 'Osoba',
	    });

	    //editables 
	    $('.editable-partner').editable({
			url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
			source	: base + '/ajaxload/partners',
			type: 'select',
			name: 'id_obchodny_partner',
			title: 'Partner',
	    });

	    $('.editable-popis').editable({
			url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
			type: 'textarea',
			name: 't_popis',
			title: 'Popis',
	    });

	    $('.editable-amount').editable({
			url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
			type: 'text',
			name: 'vl_zakladna_suma',
			title: 'Suma',
	    });

	    $('.editable-periodical').editable({
			url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
			source	: [{'A': 'áno'}, {'N': 'nie'}],
			type: 'select',
			name: 'fl_pravidelny',
			title: 'Pravidelny',
	    });
	}
	$(document).ready(function(){

    	initEditables();

	    $('#new-row').bind('click', function(){

	    	$('table tbody').prepend('<tr>' +
				'<td>&nbsp;</td>' +
				'<td>' +
					'<span class="editable-person-new" data-pk="new" data-original-title="Vyberte osobu"></span>' +
				'</td>' +
				'<td>' +
					'<span class="editable-partner-new" data-pk="new" data-original-title="Vyberte partnera"></span>' +
				'</td>' +
				'<td>' +
					'<span class="editable-popis-new" data-pk="new" data-original-title="Zadajte popis"></span>' +
				'</td>' +
				'<td>' +
					'<span class="editable-amount-new" data-pk="new" data-original-title="Vyberte partnera"></span>' +
				'</td>' +
				'<td>' +
					'<span class="editable-periodical-new" data-pk="new" data-original-title="Zvolte"></span>' +
				'</td>' +
			'</tr>');

	    	$('.editable-person-new').editable({
				url: base + '/ajaxsave/D_ZDROJ_PRIJMU',
				source	: base + '/ajaxload/familymembers',
				type: 'select',
				name: 'id_osoba',
				title: 'Osoba',
				ajaxOptions: { dataType: 'json' },
			    success: function (response, newValue)
			    {
					if(response){
			    		var $el = $('[data-pk=new]');
			    		$el.each(function(){
			    			$(this).attr('class', $(this).attr('class').replace('-new', ''));
			    			$(this).attr('data-pk', response.id);
			    		});
			    	}
			    	initEditables();
				}        
		    });
	    });

	});
	</script>
@endsection


@section('content')

	<ul class="nav nav-tabs">
		<?php
		$tabs = array(
			'form'	=> 'Nový príjem',
			'sources'	=> 'Zdroje príjmov',
			'partners'	=> 'Partneri',
		);
		foreach($tabs as $key => $title){
			$class = '';
			$url   = URL::to('incomes/'.$key);
			if(URI::segment(2) === $key){
				$class = 'class="active"';
			}
			echo "<li {$class}><a href='{$url}'>{$title}</a></li>";
		}
		?>
		<li id="new-row" class="pull-right">Nový zdroj</li>
	</ul>

	<table class="table table-bordered">
		<thead>
			<tr style="font-weight: bold;">
				<td>#</td>
				<td>Osoba</td>
				<td>Partner</td>
				<td>Popis</td>
				<td>Suma</td>
				<td>Pravidelný</td>
			</tr>
		</thead>
		<tbody>
			@foreach($sources as $key => $source)
			<tr>
				<td>{{$key+1}}</td>

				<td>
					<span class="editable-person" data-pk="{{$source->id}}" data-original-title="Vyberte osobu">
						{{ $source->t_meno_osoby}} {{ $source->t_priezvisko_osoby }}
					</span>
				</td>

				<td>
					<span class="editable-partner" data-pk="{{$source->id}}" data-original-title="Zadajte nazov">
						{{$source->t_nazov}}
					</span>	
				</td>

				<td>
					<span class="editable-popis" data-pk="{{$source->id}}" data-original-title="Zadajte popis">
						{{$source->t_popis}}
					</span>	
				</td>

				<td>
					<span class="editable-amount" data-pk="{{$source->id}}" data-original-title="Zadajte popis">
						{{$source->vl_zakladna_suma}}
					</span>	
				</td>

				<td>
					<span class="editable-periodical" data-pk="{{$source->id}}" data-original-title="Zadajte popis">
						{{$source->fl_pravidelny == 'A' ? 'áno' : 'nie' }}
					</span>	
				</td>

			</tr>
			@endforeach
		</tbody>
	</table>

@endsection