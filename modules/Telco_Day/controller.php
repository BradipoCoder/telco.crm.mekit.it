<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 15.21
 */

/**
 * Class Telco_DayController
 */
class Telco_DayController extends SugarController
{
    /**
     * List view
     */
    protected function action_listview()
    {
        parent::action_listview();
    }
    
    /**
     * Print view
     */
    protected function action_printview()
    {
        $this->view = 'print';
    }
}