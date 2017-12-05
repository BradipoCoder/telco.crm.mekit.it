<?php
require_once 'data/SugarBean.php';
require_once 'include/SugarObjects/templates/basic/Basic.php';
require_once('include/utils.php');

/**
 * Class Telco_Day
 */
class Telco_Day extends Basic
{
    var $module_dir = 'Telco_Day';
    var $table_name = 'telco_day';
    var $object_name = 'Telco_Day';
    var $disable_custom_fields = true;
    var $importable = false;

    var $id;
    var $name;

    /**
     * Telco_Day constructor.
     */
    function __construct()
    {
        parent::__construct();
    }


    /**
     * @param string $interface
     *
     * @return bool
     */
    public function bean_implements($interface)
    {
        $answer = false;

        switch($interface)
        {
            case 'ACL':
                $answer = true;
                break;
        }

        return $answer;
    }
}