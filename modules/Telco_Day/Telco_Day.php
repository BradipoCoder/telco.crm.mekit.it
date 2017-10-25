<?php
require_once 'data/SugarBean.php';
require_once('include/utils.php');

class Telco_Day extends SugarBean
{
    var $module_dir = 'Telco_Day';
    var $table_name = 'telco_day';
    var $object_name = 'Telco_Day';
    var $acltype = 'Telco_Day';
    var $acl_category = 'Telco_Day';
    var $disable_custom_fields = true;
    var $disable_vardefs = true;
    
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * @param string $interface
     *
     * @return bool
     */
    function bean_implements($interface)
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