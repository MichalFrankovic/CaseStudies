@layout('layouts.base')

@section('styles')
	{{ HTML::style('assets/css/bootstrap-editable.css') }}
@endsection

@section('scripts')
	{{ HTML::script('assets/js/bootstrap-editable.js') }}
	<script>
	var inline_edit_url = '<?=URL::to('incomes/inline_edit/')?>';

	function initEditables()
	{
		//editables 
	    $('.editable-username').editable({
			url: inline_edit_url,
			type: 'text',
			name: 't_nazov',
			title: 'Názov',
			validate: function(value) {
	           if($.trim(value) == '') return 'This field is required';
	        }
	    });

	    $('.editable-address').editable({
			url: inline_edit_url,
			type: 'text',
			name: 't_adresa',
			title: 'Adresa',
		    validate: function(value) {
	           if($.trim(value) == '') return 'This field is required';
	        }
	    });
	}

	function rowCreated(response, newValue)
	{
		if(response){
    		var $el = $('[data-pk=new]');
    		$el.each(function(){
    			$(this).attr('class', $(this).attr('class').replace('-new', ''));
    			$(this).attr('data-pk', response.id);
    		});
    		
    		initEditables();
    	}
	}

	$(document).ready(function(){

    	initEditables();

	    $('#new-row').bind('click', function(){

	    	$('table tbody').prepend('<tr>' +
				'<td>&nbsp;</td>' +
				'<td>' +
					'<span class="editable-username-new" data-pk="new" data-original-title="Zadajte meno"></span>' +
				'</td>' +
				'<td>' +
					'<span class="editable-address-new" data-pk="new" data-original-title="Zadajte adresu"></span>' +
				'</td>' +
			'</tr>');

			$('.editable-username-new').editable({
				url: inline_edit_url,
				type: 'text',
				name: 't_nazov',
				title: 'Názov',
				validate: function(value) {
		           if($.trim(value) == '') return 'This field is required';
		        },
		        ajaxOptions: { dataType: 'json' },
			    success: rowCreated
			});
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
		<li id="new-row" class="pull-right">
			<button class="btn btn-info">
				<i class="icon-plus icon-white"></i> Nový partner
			</button>
		</li>
	</ul>

	<table class="table table-bordered">
		<thead>
			<tr style="font-weight: bold;">
				<td>#</td>
				<td>Názov</td>
				<td>Adresa</td>
			</tr>
		</thead>
		<tbody>
			@foreach($partners as $key => $partner)
			<tr>
				<td>{{$key+1}}</td>

				<td>
					<span class="editable-username" data-pk="{{$partner->id}}" data-original-title="Zadajte nazov">
						{{ htmlspecialchars($partner->t_nazov) }}
					</span>
				</td>

				<td>
					<span class="editable-address" data-pk="{{$partner->id}}" data-original-title="Zadajte adresu">
						{{ htmlspecialchars($partner->t_adresa) }}
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection