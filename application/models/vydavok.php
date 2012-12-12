<?php
/**
 * Created by JetBrains PhpStorm.
 * User: datashark
 * Date: 12/12/12
 * Time: 1:14 PM
 * To change this template use File | Settings | File Templates.
 */
class Vydavok extends Eloquent
{
    public static $table = 'F_VYDAVOK';

    public function partner() {

        return $this->belongs_to('Partner', 'id_obchodny_partner');
    }
}
