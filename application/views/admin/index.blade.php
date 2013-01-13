@include('head')
@include('admin/submenu')

<!--<pre>TODO:

* lisitng pouzivatelov (domacnosti) - check!
* pridanie / editacia (zmena emailu, hesla, nazvu uctu, urovne - ci je admin)
* aktivacia / deaktivacia (fl aktivna N) - check!
* mazanie pouzivatelov (fl aktvina na N)

</pre>-->
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif

<!--PRIDAVANIE UZIVATELOV-->

<h2 class="">Pridanie užívateľa (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="admin/addUser">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Názov domácnosti</th>
            <th>E-mail</th>
            <th>Heslo</th>
            <th>Zopakovať heslo</th>
            <th>Úroveň účtu</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>            
            <td><div class="input-append">
                <input name="domacnost" class="span2" type="text" value="" placeholder="Novákovci" />
            </div></td>
            
            <td><div class="input-append">
                <input name="email" class="span2" type="text" value="" placeholder="novak@mail.com"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="heslo" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="heslo2" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="uroven" class="span2" type="text" value="" placeholder="A/N"/>
            </div></td>
            
            <td><input type="submit" name="Submit" value="Pridaj používateľa"/></td>
            
        </tr>
        </tbody>
    </table>
</form>

<!--LISTING A NASTAVENIE UZIVATELOV-->

<h2 class="">Zoznam užívateľov (domácností)</h2>
<form id="form1" name="form1" method="post" action="">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Názov domácnosti</th>
            <th>E-mail</th>
            <th>Admin účet</th>
            <th>Aktívna</th>            
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($domacnosti as $domacnost)
        <tr>
            <td>{{ $domacnost->t_nazov_domacnosti }}</td>
            <td>{{ $domacnost->t_email_login }}</td>
            <td>{{ $domacnost->fl_admin }}</td>
            <td>{{ $domacnost->fl_aktivna }}</td>
            <td><a class="btn" href="admin/editUser?id={{ $domacnost->id }}">Upraviť</a>
                <a class="btn" href="admin/disableUser?id={{ $domacnost->id }}">Aktivovať/Deaktivovať</a>
                <a class="btn" href="admin/deleteUser?id={{ $domacnost->id }}">Zmazať</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</form>
@include('foot');
