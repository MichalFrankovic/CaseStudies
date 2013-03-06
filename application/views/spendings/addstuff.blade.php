@include('head')
@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')


<h2>Dodávateľ</h2>

<div class="thumbnail" >
    {{ Form::open('spendings/pridajpartnera', 'POST', array('class' => 'side-by-side')); }}
    <div class="input-prepend">
        <span class="add-on">Zaplatil: </span>
        <select name="osoba" class="span3">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" > {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov-partnera" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Adresa:</span>
        <input class="span3 " type="text" name="adresa" value="">
    </div>
    <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
</div>
</div>

@include('foot')

