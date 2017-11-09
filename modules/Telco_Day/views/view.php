<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 16.14
 */

class Telco_DayView extends SugarView
{
    /** @var string */
    const DATE_FORMAT_ISO = "Y-m-d";
    
    /** @var string */
    const DATE_FORMAT_FANCY = "l, j F";
    
    /** @var string */
    private $purpose = "view";
    
    /** @var array */
    protected $templateData = [];
    
    /** @var  string */
    protected $templateHtml;
    
    /** @var  \DateTime */
    private $period_start;
    
    /** @var  \DateTime */
    private $period_end;
    
    /** @var string */
    protected $default_interval_length = "-1 week";
    
    /**
     * @return string
     */
    protected function getDisplayHtml()
    {
        $this->ss->assign("purpose", $this->purpose);
        $this->ss->assign("tplData", $this->templateData);
        
        $templateFile = 'modules/Telco_Day/tpls/TelcoDayView.tpl';
        if (inDeveloperMode())
        {
            $this->ss->clear_compiled_tpl($templateFile);
        }
        
        return $this->ss->fetch($templateFile, null, null, false);
    }
    
    /**
     *
     * @param \DateTime|mixed $startDate
     * @param \DateTime|mixed $endDate
     */
    protected function prepareTemplateData($startDate = null, $endDate = null)
    {
        $this->setPeriodStart($startDate);
        $this->setPeriodEnd($endDate);
    
        
        
        $this->prepareCurrentPeriodData();
        $this->prepareUserData();
        $this->prepareMeetingsData();
    
        $this->templateData["title"] = "Appuntamenti per " . $this->templateData["user"]["full_name"];
        
        //add css
        $this->templateData["css"] = [
            "/modules/Telco_Day/css/telco_day.css",
        ];
    }
    
    private function prepareMeetingsData()
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
            . " AND mm.date_start >= '" . $this->period_start->format("Y-m-d") . "'"
            . " AND mm.date_start < '" . $this->period_end->format("Y-m-d") . "'"
            . " AND mm.deleted = 0"
            . " AND mu.deleted = 0"
            . " ORDER BY mm.date_start ASC";
        
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
        $this->templateData["meetings"] = $meetings;
    }
    
    /**
     * @param \Meeting $meeting
     *
     * @return \Meeting
     */
    private function addCaseDataToMeeting($meeting)
    {
        if ($meeting->parent_type == 'Cases' && !empty($meeting->parent_id))
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
        if (isset($meeting->case["account_id"]) && !empty($meeting->case["account_id"]))
        {
            $account = new \Account();
            $account->retrieve($meeting->case["account_id"]);
            $meeting->accounts = $account->toArray(false, true);
        }
        
        return $meeting;
    }
    
    private function prepareCurrentPeriodData()
    {
        $this->templateData["periods"]["period_start"] = $this->period_start;
        $this->templateData["periods"]["period_end"] = $this->period_end;
        
        $this->templateData["periods"]["period_start_format_iso"] = $this->period_start->format(self::DATE_FORMAT_ISO);
        $this->templateData["periods"]["period_end_format_iso"] = $this->period_end->format(self::DATE_FORMAT_ISO);
        
        $this->templateData["periods"]["period_start_format_fancy"] =
            $this->period_start->format(self::DATE_FORMAT_FANCY);
        $this->templateData["periods"]["period_end_format_fancy"] = $this->period_end->format(self::DATE_FORMAT_FANCY);
    }
    
    private function prepareUserData()
    {
        /** @type \User $current_user */
        global $current_user;
        
        foreach ($current_user as $k => $v)
        {
            if (is_string($v) || is_numeric($v))
            {
                if (!empty($v))
                {
                    $this->templateData["user"][$k] = $v;
                }
            }
        }
    }
    
    /**
     * @return \DateTime
     */
    public function getPeriodStart()
    {
        return $this->period_start;
    }
    
    /**
     * @param \DateTime $period_start
     */
    public function setPeriodStart($period_start)
    {
        if (!$period_start instanceof \DateTime)
        {
            if (!$this->period_start instanceof \DateTime)
            {
                $this->period_start = new \DateTime();
            }
        }
        else
        {
            $this->period_start = $period_start;
        }
    }
    
    /**
     * @return \DateTime
     */
    public function getPeriodEnd()
    {
        return $this->period_end;
    }
    
    /**
     * @param \DateTime $period_end
     */
    public function setPeriodEnd($period_end)
    {
        if (!$period_end instanceof \DateTime)
        {
            if (!$this->period_end instanceof \DateTime)
            {
                //setting a week back from today
                $this->period_end = new \DateTime();
                $this->period_start = clone $this->period_end;
                $this->period_start->modify($this->default_interval_length);
            }
        }
        else
        {
            $this->period_end = $period_end;
        }
    }
    
    /**
     *
     */
    protected function interceptPostValues()
    {
        //print_r($_POST);
        
        if (isset($_POST["date_start"]) && !empty($_POST["date_start"]))
        {
            $d = \DateTime::createFromFormat(self::DATE_FORMAT_ISO, $_POST["date_start"]);
            $this->setPeriodStart($d);
        }
        
        if (isset($_POST["date_end"]) && !empty($_POST["date_end"]))
        {
            $d = \DateTime::createFromFormat(self::DATE_FORMAT_ISO, $_POST["date_end"]);
            $this->setPeriodEnd($d);
        }
        
        if (isset($_POST["pdf"]))
        {
            $this->purpose = 'pdf';
        }
    }
}