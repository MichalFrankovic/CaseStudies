<ul class="nav nav-tabs">
    <li<?php echo $subactive=='reporting/vydavky' ? ' class="active"' : ''; ?>>{{ HTML::link('reporting/report_vydavky', 'Reporting výdavkov'); }}</li>
    <li<?php echo $subactive=='reporting/prijmy' ? ' class="active"' : ''; ?>>{{ HTML::link('reporting/report_prijmy', 'Reporting príjmov'); }}</li>
    
    
</ul>