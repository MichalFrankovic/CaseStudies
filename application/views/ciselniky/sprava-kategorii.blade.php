@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')


Toto je správa kategórií


<h2>Pridaj kategóriu</h2>
<div class="thumbnail" >

    {{ Form::open('ciselniky/pridajkategoriu', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov kategórie: </span>

        <input class="span3" type="text" name="nazov" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Pod-kategória: </span>

        <select name="category-id" class="span3">
            <option value="" selected="selected">ŽIADNA</option>
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




@include('foot')