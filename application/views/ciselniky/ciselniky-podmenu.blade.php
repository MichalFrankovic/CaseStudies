<h2>Číselníky - SPRÁVA:</h2>

<ul class="nav nav-tabs">
    <li<?php echo $subactive=='ciselniky/sprava-partnerov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_partnerov', 'Partnerov'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-kategorii' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_kategorii', 'Kategórií'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-typu-prijmu' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_prijmu', 'Typu príjmu'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-typu-vydavku' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_vydavku', 'Typu výdavku'); }}</li>
	<li<?php echo $subactive=='ciselniky/sprava-osob' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_osob', 'Osôb'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-produktov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_produktov', 'Produktov'); }}</li>
</ul>