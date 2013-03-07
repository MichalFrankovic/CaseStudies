@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')



<h2>Pridajte typ výdavku</h2>
<div class="thumbnail" >

    {{ Form::open('ciselniky/pridajtypvydavku', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:inherit;width:275px; height:10px;">
        <span class="add-on">Názov typu výdavku: </span>

        <input class="span3" type="text" name="nazov_typu_vydavku" value="">
      <span style="padding:0px 4px;"> {{ Form::submit('Uložiť' , array('class' => 'btn')); }}</span>

     {{ Form::close() }}
     </div>
</div>
</div>
<h2 class=""> Zoznam typov výdavkov </h2>


<form id="form1" name="form1" method="post" action="multizmazattypy" >
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="20"> Označit </th>
            <th> ID 				</th>
            <th> Názov 				</th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ)
        <tr>
            <td><input type="checkbox" name="typvydavku[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->id }} 				  </td>
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