
@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')

<h2>Editovanie osoby (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="editUserDone">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>         
            <th>    Meno          </th>
            <th>    Priezvisko  </th>
            <th>    Aktivna   </th>
            <th>    Výber akcie     </th>
            <th></th>
        </tr>
        </thead>

<br>

        <tbody>
            @foreach ($osoby as $osoba)
        <tr>
           
            <td><div class="input-append">
                <input name="meno" class="span2" type="text" value= "{{ $osoba->t_meno_osoby }}" required/>
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="priezvisko" class="span2" type="text" value="{{ $osoba->t_priezvisko_osoby }}" required/>
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="status" class="span2" type="Checkbox" value="{{ $osoba->fl_aktivna }}" 
                <?php if ($osoba->fl_aktivna == 'A') { echo 'checked'; }?>/>
                <span class="help-inline">'.$errors['name'].'</span>        
            </div></td>
            
            <td><input type="submit" name="Submit" value="Uložiť"/></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</form>

@include('foot');
