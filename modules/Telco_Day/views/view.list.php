<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 15.07
 */

/**
 * Class Telco_DayViewList
 */
class Telco_DayViewList extends SugarView
{
    /**
     * Display view
     */
    public function display()
    {
        echo '<h1>TELCO DAY</h1>';
        echo '<a href="/index.php?module=Telco_Day&action=printView">STAMPA</a>';
    }
    
    
}
