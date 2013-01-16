@include('head')

<!--<pre>TODO:

* lisitng pouzivatelov (domacnosti)
* pridanie / editacia (zmena emailu, hesla, nazvu uctu, urovne - ci je admin)
* aktivacia / deaktivacia (fl aktivna N)
* mazanie pouzivatelov (fl aktvina na N)

</pre>-->

<h2 class="">Editovanie užívateľa (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="editUserDone">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Názov domácnosti</th>
            <th>E-mail</th>
<!--            <th>Heslo</th>
            <th>Zopakovať heslo</th>-->
            <th>Stav účtu</th>
            <th>Admin. účet</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($domacnosti as $domacnost)
        <tr>
            <td><div class="input-append">
                <input type="hidden" name="id" id="hidden" value="{{ $domacnost->id }}"/>
<!--                <span class="add-on">€</span>-->
            </div></td>
            <td><div class="input-append">
                <input name="domacnost" class="span2" type="text" value= "{{ $domacnost->t_nazov_domacnosti }}" />
<!--                <span class="add-on">€</span>-->
            </div></td>
            <td><div class="input-append">
                <input name="email" class="span2" type="text" value="{{ $domacnost->t_email_login }}" />
<!--                <span class="add-on">€</span>-->
            </div></td>
            <td><div class="input-append">
                <input name="stav" class="span2" type="text" value="{{ $domacnost->fl_aktivna }}" />
<!--                <span class="add-on">€</span>-->
            </div></td>
            <td><div class="input-append">
                <input name="uroven" class="span2" type="text" value="{{ $domacnost->fl_admin }}" />
<!--                <span class="add-on">€</span>-->
            </div></td>
            
            <td><input type="submit" name="Submit" value="Uložiť"/></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</form>

@include('foot');
