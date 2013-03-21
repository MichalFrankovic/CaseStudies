<ul class="nav nav-tabs">
    <li<?php echo $subactive=='spendings/list' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/list', 'Zoznam výdavkov'); }}</li>
    <li<?php echo $subactive=='spendings/simplespending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/simplespending', 'Jednoduchý výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/periodicalspending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/periodicalspending', 'Pravidelný výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/sablona' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/sablona', 'Šablona výdavkov'); }}</li>
    
</ul>