@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')



<div class="thumbnail" >
  <h2>Pridajte typ výdavku</h2>

{{ Form::open('ciselniky/pridajtypvydavku', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend">
        <label class="control-label">    Názov typu výdavku:          </label>  
        <input class="span3" type="text" name="nazov_typu_vydavku" value="">
    </div>

<button type="submit" class="btn btn-primary">
    <i class="icon-ok icon-white"></i>
            Pridaj
    </button>
{{ Form::close() }}
     

</div>

<h2 class=""> Zoznam typov výdavkov </h2>


<form id="form1" name="form1" method="post" action="multizmazattypy" >
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th> Názov 				</th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ)
        <tr>
            <td><input type="checkbox" name="typvydavku[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->t_nazov_typu_vydavku }} </td>
           
            
            <td> <a class="btn" href="upravittypvydavku?id={{ $typ->id }}"> Upraviť </a>
                 <a class="btn" href="zmazattypvydavku?typvydavku={{ md5($typ->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>

@include('foot')