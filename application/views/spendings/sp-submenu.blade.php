<ul class="nav nav-tabs">
    <li<?php echo $subactive=='spendings/simplespending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/simplespending', 'Jednoduchý výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/periodicalspending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/periodicalspending', 'Pravidelný výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/templatespending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/templatespending', 'Šablona výdavkov'); }}</li>
</ul>