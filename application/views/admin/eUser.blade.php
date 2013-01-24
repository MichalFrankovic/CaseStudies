@include('head')
@include('admin/submenu')


<h2>Editovanie užívateľa (domácnosti)</h2>
<form id="form1" name="form1" method="post" action="editUserDone">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Názov domácnosti</th>
            <th>E-mail</th>
<!--            <th>Heslo</th>
            <th>Zopakovať heslo</th>-->
            <th>Aktívna</th>
            <th>Admin práva</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($domacnosti as $domacnost)
        <tr>
            <td><div class="input-append">
                <input type="hidden" name="id" id="hidden" value="{{ $domacnost->id }}"/>
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="domacnost" class="span2" type="text" value= "{{ $domacnost->t_nazov_domacnosti }}" />
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="email" class="span2" type="text" value="{{ $domacnost->t_email_login }}" />
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="status" class="span2" type="checkbox" value="{{ $domacnost->fl_aktivna }}" <?php if ($domacnost->fl_aktivna == 'A') { echo 'checked'; }?>/>
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            <td><div class="input-append">
                <input name="uroven" class="span2" type="checkbox" value="{{ $domacnost->fl_admin }}" <?php if ($domacnost->fl_admin == 'A') { echo 'checked'; }?>/>
                <span class="help-inline">'.$errors['name'].'</span>

            </div></td>
            
            <td><input type="submit" name="Submit" value="Uložiť"/></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</form>

@include('foot');
