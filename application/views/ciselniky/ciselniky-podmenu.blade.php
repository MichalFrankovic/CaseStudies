<h2>Číselníky</h2>

<ul class="nav nav-tabs">
    <li<?php echo $subactive=='ciselniky/sprava-produktov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_produktov', 'Správa produktov'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-prijemcu-platby' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_prijemcu_platby', 'Správa príjemcu platby'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-kategorii' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_kategorii', 'Správa kategórií'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-typu-prijmu' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_typu_prijmu', 'Správa typu príjmu'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-zdroju-prijmu' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_zdroju_prijmu', 'Správa zdroju príjmu'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-poplatkov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_poplatkov', 'Správa poplatkov'); }}</li>
    <li<?php echo $subactive=='ciselniky/sprava-setriacich-uctov' ? ' class="active"' : ''; ?>>{{ HTML::link('ciselniky/sprava_setriacich_uctov', 'Správa šetriacich účtov'); }}</li>
</ul>