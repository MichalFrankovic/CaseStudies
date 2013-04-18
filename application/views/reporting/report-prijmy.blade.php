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

$(document).ready(function(){
  	// Datepicker
		$('.datepicker').datepicker({
			format	: 'mm/dd/yyyy',
			weekStart:	1
		});

</script>

<?php
  
  $osoba2 = Input::get('osoba');
  $styp = Input::get('typ_prijmu');
?>

@endsection

@section('content')

@include('reporting.reporting-submenu')

<div class="whole" id="1" style="float:left;width:100%;">

{{ Form::open('reporting/report_prijmy', 'get', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
    <h4>Filter</h4>


<div class="input-prepend" style="float:left;margin-right:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum od: </span>
    <input class="span2 datepicker" type="text" name="od" value="" >
</div>
<div class="input-prepend" style="float:left;margin-right:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Dátum do: </span>
    <input class="span2 datepicker" type="text" name="do" value="">
</div>
<div class="input-prepend">
        <span class="add-on" style="width:120px;text-align:left;padding-left:10px">Čas zobraziť </span>
    <select name="osoba"  class="span2">
        <option value="m" selected="selected">Mesačne</option>
        <option value="s" >Štvrťročne</option>
        <option value="p" >Polročne</option>
        <option value="r" >Ročne</option>
    </select>
</div>
<div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px">Osoba: </span>
    <select name="osoba"  class="span2">
        <option value="all" selected="selected">VŠETKY</option>
        @foreach ($persons as $osoba)
        <option value="{{ $osoba->id }}" <?php if($osoba->id==$osoba2){echo 'selected="selected"';}?>> {{ $osoba->t_meno_osoby }}&nbsp;{{ $osoba->t_priezvisko_osoby }}</option>
        @endforeach
    </select>
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
        <span class="add-on" style="width:120px;text-align:left;padding-left:10px">Kategorie zobraziť </span>
    <select name="osoba"  class="span2">
        <option value="all" selected="selected">VŠETKY</option>
       
    </select>
 </div>
  <!--<div class="input-prepend" style="float:left;margin-right:50px">
        <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Suma od: </span>
        <input class="span2" type="text" name="od" value="" >
    </div>
    <div class="input-prepend" style="margin-left:50px">
    <span class="add-on" style="width:80px;text-align:left;padding-left:10px;">Suma do: </span>
    <input class="span2" type="text" name="do" value="">
</div>-->
       <!-- {{ Form::reset('Vynulovať filter' , array('class' => 'btn','style'=>'width:120px')); }}-->
    <a class="btn btn-primary" href="{{ URL::to('reporting/report_prijmy') }}" ><i class="icon-remove icon-white"></i>Vymaž filter</a>
       
       <!--{{ Form::submit('Zobraziť' , array('class' => 'btn btn-primary','style'=>'width:120px')); }}-->
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Aplikuj filter	</button>
        
</div>
{{ Form::close() }}

<div class="thumbnail" >
<form id="form1" name="form2" method="get" >
	
    <table class="table table-bordered">
        <thead>
            <tr style="font-weight: bold;">
                <td></td>
                <td>Mesiac1</td>
            </tr>    
        </thead>
        <tbody>
            
        </tbody>    
	</table>
</form>
</div>
</div>



@endsection
