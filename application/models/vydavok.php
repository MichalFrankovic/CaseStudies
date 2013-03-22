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
    public static $table = 'VIEW_F_VYDAVOK';

    public function partner() {

        return $this->belongs_to('Partner', 'id_obchodny_partner'); 
        // NENASTALA zmena aj napriek tomu, že z TAB D_OBCHODNY_PARTNER bol zmenený identifikátor
        // Vo VIEW_F_VYDAVOK má partner stále id_obchodny_partner
    }
}
