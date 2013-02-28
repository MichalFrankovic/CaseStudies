@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')


Toto je správa produktov

<h2>Pridaj Produkt</h2>
<div class="thumbnail" >
    {{ Form::open('ciselniky/pridajprodukt', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Základná cena:</span>
        <input class="span3" type="text" name="cena" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Kategória: </span>

        <select name="category-id" class="span3">
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>
    

        <div class="submit">
            {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
        </div>
        {{ Form::close() }}
    </div>
</div>

@include('foot')