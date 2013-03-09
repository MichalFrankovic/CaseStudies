

<ul class="nav nav-tabs">
	<li<?php echo $subactive=='podmenu-sprava-osob' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_osob', 'Osoby'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-partnerov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_partnerov', 'Partneri'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-kategorii' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_kategorii', 'Kategórie'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-produktov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_produktov', 'Produkty'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-typu-prijmu' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_prijmu', 'Typy príjmu'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-typu-vydavku' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_vydavku', 'Typy výdavku'); }}</li>
	
</ul>