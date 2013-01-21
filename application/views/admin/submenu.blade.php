<ul class="nav nav-tabs">
    <li<?php echo $subactive=='admin/users' ? ' class="active"' : ''; ?>>{{ HTML::link('admin', 'Zoznam domácností'); }}</li>
    <li<?php echo $subactive=='admin/adduser' ? ' class="active"' : ''; ?>>{{ HTML::link('admin/addUser', 'Pridanie novej domácnosti'); }}</li>
<!--    <li<?php echo $subactive=='admin/options' ? ' class="active"' : ''; ?>>{{ HTML::link('admin/options', 'Číselníky'); }}</li>-->
</ul>