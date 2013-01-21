@include('head')
@include('admin/submenu')
@if (isset($message) )
    <h2 style="color: #bc8f8f;">{{ $message }}</h2>
@endif

<!--CHECK ALL SKRIPT-->
<script type="text/javascript">
checked=false;
function checkedAll (form1) {
	var aa= document.getElementById('form1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>

<!--PRIDAVANIE UZIVATELOV-->
<!--<a class="btn" href="admin/addUser">Pridaj používateľa</a>-->
<!--<h2>Pridanie užívateľa (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="admin/addUser">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Názov domácnosti*</th>
            <th>E-mail*</th>
            <th>Heslo*</th>
            <th>Zopakovať heslo*</th>
            <th>Úroveň účtu*</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>            
            <td><div class="input-append">
                <input name="name" class="span2" type="text" value="" placeholder="Novákovci" />
            </div></td>
            
            <td><div class="input-append">
                <input name="email" class="span2" type="text" value="" placeholder="novak@mail.com"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="password" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="password-repeat" class="span2" type="password" value="" placeholder="**********"/>
            </div></td>
            
            <td><div class="input-append">
                <input name="status" class="span2" type="text" value="" placeholder="A/N"/>
            </div></td>
            
            <td><input type="submit" name="Submit" value="Pridaj používateľa"/></td>
            
        </tr>
        </tbody>
    </table>
</form>-->

<!--LISTING A NASTAVENIE UZIVATELOV-->
<form id="form1" name="form1" method="post" action="admin/editMore">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th><input type='checkbox' name='checkall' onclick='checkedAll(form1);'></th>
            <th>Názov domácnosti</th>
            <th>E-mail</th>
            <th>Admin práva</th>
            <th>Aktívna</th>            
            <th>Nastavenia</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($domacnosti as $domacnost)
        <tr>
            <td><input type="checkbox" name="polozka[]" value="{{ $domacnost->id }}" /></td>
            <td>{{ $domacnost->t_nazov_domacnosti }}</td>
            <td>{{ $domacnost->t_email_login }}</td>
            <td>{{ $domacnost->fl_admin }}</td>
            <td>{{ $domacnost->fl_aktivna }}</td>
            <td><a class="btn" href="admin/editUser?id={{ $domacnost->id }}">Edit</a>
                <a class="btn" href="admin/disableUser?id={{ $domacnost->id }}">Aktivuj/Deaktivuj</a>
                <a class="btn" href="admin/deleteUser?id={{ $domacnost->id }}" onclick="return confirm('Určite chcete zmazať tento záznam?')">Zmaž</a>
            </td>
        </tr>
        @endforeach
        
        </tbody>
        <tr>
            <td><input type="Submit" name="Submit" value="Zmaž" onclick="return confirm('Určite chcete zmazať tieto záznamy ?')"></td>
            <td><input type="Submit" name="Submit" value="Aktivuj"> <input type="Submit" name="Submit" value="Deaktivuj"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</form>
@include('foot');
<!--
-->