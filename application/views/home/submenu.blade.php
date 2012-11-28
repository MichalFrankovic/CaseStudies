<ul class="nav nav-tabs">
	<li<?php echo $subactive=='admin/users' ? ' class="active"' : ''; ?>>{{ HTML::link('admin/users', 'Používatelia'); }}</li>
	<li<?php echo $subactive=='admin/settings' ? ' class="active"' : ''; ?>>{{ HTML::link('admin/settings', 'Nastavenia'); }}</li>
	<li<?php echo $subactive=='admin/options' ? ' class="active"' : ''; ?>>{{ HTML::link('admin/options', 'Číselníky'); }}</li>
</ul>