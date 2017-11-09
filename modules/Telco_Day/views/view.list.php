<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 15.07
 */
require_once("modules/Telco_Day/views/view.php");

/**
 * Class Telco_DayViewList
 */
class Telco_DayViewList extends Telco_DayView
{
    /**
     * Display view
     */
    public function display()
    {
        $this->interceptPostValues();
        $this->prepareTemplateData();
        $html = $this->getDisplayHtml();
        print $html;
    }
}
