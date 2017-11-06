<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 16.14
 */

class Telco_DayView extends SugarView
{
    /** @var  \DateTime */
    protected $today;
    
    /**
     * @return string
     */
    protected function getDisplayHtml()
    {
        $templateFile = 'modules/Telco_Day/tpls/TelcoDayView.tpl';
        
        $this->today = new \DateTime();
    
        $this->assignCurrentPeriodData();
        $this->assignUserData();
        $this->assignMeetingsData();
        
        
        
        if (inDeveloperMode()) {
            $this->ss->clear_compiled_tpl($templateFile);
        }
        
        return $this->ss->fetch($templateFile, null, null, false);
    }
    
    
    private function assignMeetingsData()
    {
        /** @type \User $current_user */
        global $current_user;
        
        /** \DBManager $db */
        global $db;
        
        $meetings = [];

        $sql = ""
            . "SELECT mm.*, mu.*"
            . " FROM meetings AS mm"
            . " INNER JOIN meetings_cstm AS mc ON mc.id_c = mm.id"
            . " INNER JOIN meetings_users AS mu ON mu.meeting_id = mm.id"
            . " WHERE mu.user_id = " . $current_user->id
            . " AND mm.status = 'Planned'"
            . " AND mm.date_start >= '".$this->today->format("Y-m-d")."' AND mm.date_start < ('".$this->today->format("Y-m-d")."' + INTERVAL 1 DAY)"
            . " AND mm.deleted = 0"
            . " AND mu.deleted = 0"
            . " ORDER BY mm.date_start ASC"
        ;
        
        $query = $db->query($sql);
        while ($row = $db->fetchByAssoc($query))
        {
            $meeting = new Meeting();
            $meeting->populateFromRow($row);
            $meeting = $this->addCaseDataToMeeting($meeting);
            $meeting = $this->addAccountsDataToMeeting($meeting);
            
            $meetings[] = $meeting->toArray();
        }
        
        //print "MEETINGS: ". print_r($meetings, true);
        
        $this->ss->assign('meetings', $meetings);
    }
    
    /**
     * @param \Meeting $meeting
     *
     * @return \Meeting
     */
    private function addCaseDataToMeeting($meeting)
    {
        if($meeting->parent_type == 'Cases' && !empty($meeting->parent_id))
        {
            $case = new \aCase();
            $case->retrieve($meeting->parent_id);
            $meeting->case = $case->toArray();
        }
        
        return $meeting;
    }
    
    /**
     * @param \Meeting $meeting
     *
     * @return \Meeting
     */
    private function addAccountsDataToMeeting($meeting)
    {
        if(isset($meeting->case["account_id"]) && !empty($meeting->case["account_id"]))
        {
            $account = new \Account();
            $account->retrieve($meeting->case["account_id"]);
            $meeting->accounts = $account->toArray(false, true);
        }
        
        return $meeting;
    }
    
    
    /**
     * Current period/day data
     */
    private function assignCurrentPeriodData()
    {
        $this->ss->assign("current_period_start", $this->today);
        $this->ss->assign("current_period_end", $this->today);
    }
    
    /**
     * User data
     */
    private function assignUserData()
    {
        /** @type \User $current_user */
        global $current_user;
    
        $this->ss->assign("user", $current_user);
    
        //$current_user->full_name
        
        $prefix = 'user_';
    
        foreach($current_user as $k => $v)
        {
            if(is_string($v) || is_numeric($v))
            {
                if(!empty($v))
                {
                    $this->ss->assign($prefix . $k, $v);
                }
            }
        }
    }
}