<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/SugarObjects/forms/FormBase.php');
require_once('include/formbase.php');

/**
 * Class CaseFormBase
 */
class CaseFormBase extends FormBase
{


    /**
     * handles save functionality for meetings
     *
     * @param	string $prefix
     * @param	bool $redirect
     * @param	bool $useRequired
     *
     * @throws \Exception
     *
     * @returns \SugarBean
     */
    function handleSave($prefix, $redirect=true, $useRequired=false)
    {
        //global $current_user;
        //global $timedate;

        $case = new aCase();
        $case = populateFromPost($prefix, $case);

        if(!$case->ACLAccess('Save')) {
            throw new \Exception("You do not have Save access on Case module!");
        }

        $case->save(true);

        return $case;
    }
}
