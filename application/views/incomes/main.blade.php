@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif
<h2>Prijmy</h2>

<h2>Filter Prijmov</h2>
{{ Form::open('incomes/filter', 'POST', array('class' => 'side-by-side')); }}

<div class="thumbnail">
    <h4>Dátum</h4>
    <div class="input-prepend">
        <span class="add-on">Od: </span>
        <input class="span3" type="date" name="od" value="{{ $od }}">
    </div>
    <div class="input-prepend">
    <span class="add-on">Do: </span>
    <input class="span3" type="date" name="do" value="{{ $do }}">
</div>
 <div class="input-prepend">
        <span class="add-on">Vydajca: </span>
    <select name="vydajca" class="span3">
        <option value="all" selected="selected">Vsetci</option>
        @foreach ($partneri as $partner)
        <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
        @endforeach
    </select>
     </div>
   <div class="input-prepend">

        <span class="add-on">Kategória: </span>
        <select name="category" class="span3">
          @foreach ($kategorie as $kat)
            <option value="{{ $kat->id_kategoria_a_produkt }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    <div class="submit">
        {{ Form::submit('Zobraziť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
    </div>
 </div>


@include('foot');