<ul class="nav nav-tabs">
    <li<?php echo $subactive=='spendings/zoznam' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/zoznam', 'Zoznam výdavkov'); }}</li>
    <li<?php echo $subactive=='spendings/jednoduchyvydavok' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/simplespending', 'Jednoduchý výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/periodicalspending' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/periodicalspending', 'Pravidelný výdavok'); }}</li>
    <li<?php echo $subactive=='spendings/sablona' ? ' class="active"' : ''; ?>>{{ HTML::link('spendings/sablona', 'Šablóna výdavkov'); }}</li>
    
</ul>