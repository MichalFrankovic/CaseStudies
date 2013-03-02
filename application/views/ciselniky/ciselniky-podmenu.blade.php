<h2>Číselníky - SPRÁVA:</h2>

<ul class="nav nav-tabs">
    <li<?php echo $subactive=='podmenu-sprava-partnerov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_partnerov', 'Partnerov'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-kategorii' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_kategorii', 'Kategórií'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-typu-prijmu' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_prijmu', 'Typu príjmu'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-typu-vydavku' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_vydavku', 'Typu výdavku'); }}</li>
	<li<?php echo $subactive=='podmenu-sprava-osob' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_osob', 'Osôb'); }}</li>
    <li<?php echo $subactive=='podmenu-sprava-produktov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_produktov', 'Produktov'); }}</li>
</ul>