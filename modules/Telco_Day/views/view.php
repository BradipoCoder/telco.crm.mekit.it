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
    protected $purpose = "view";
    
    /** @var bool */
    protected $debug = false;
    
    /** @var bool */
    protected $showHtml = false;
    
    /** @var bool */
    protected $forceDownload = true;
    
    /** @var array */
    protected $templateData = [];
    
    /** @var  string */
    protected $templateHtml;
    
    /** @var  \DateTime */
    private $period_start;
    
    /** @var  \DateTime */
    private $period_end;
    
    /** @var string */
    protected $default_interval_length = "+1 day";
    
    /**
     * @return string
     */
    protected function getDisplayHtml()
    {
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
    
        $this->prepareConfigData();
        $this->prepareCurrentPeriodData();
        $this->prepareUserData();
        $this->prepareMeetingsData();
    
        $this->templateData["title"] = "Appuntamenti per " . $this->templateData["user"]["full_name"];
        
        //add css
        $this->templateData["css"] = [
            "/modules/Telco_Day/css/telco_day.css",
        ];
    }
    
    protected function prepareMeetingsData()
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
        
        if($this->debug)
        {
            print "<pre>SQL: " . $sql . "</pre>";
        }
        
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
    
    /**
     *
     */
    protected function prepareCurrentPeriodData()
    {
        $this->templateData["periods"]["period_start"] = $this->period_start;
        $this->templateData["periods"]["period_end"] = $this->period_end;
        
        $this->templateData["periods"]["period_start_format_iso"] = $this->period_start->format(self::DATE_FORMAT_ISO);
        $this->templateData["periods"]["period_end_format_iso"] = $this->period_end->format(self::DATE_FORMAT_ISO);
        
        $this->templateData["periods"]["period_start_format_fancy"] =
            $this->period_start->format(self::DATE_FORMAT_FANCY);
        $this->templateData["periods"]["period_end_format_fancy"] = $this->period_end->format(self::DATE_FORMAT_FANCY);
    }
    
    /**
     *
     */
    protected function prepareUserData()
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
     * Generic configuration values
     */
    protected function prepareConfigData()
    {
        $this->templateData["config"]["purpose"] = $this->purpose;
        $this->templateData["config"]["debug"] = ($this->debug ? 1 : 0);
        $this->templateData["config"]["print_show_html"] = ($this->showHtml ? 1 : 0);
        $this->templateData["config"]["print_force_download"] = ($this->forceDownload ? 1 : 0);
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
                //by default we set tomorrows date
                $this->period_start = new \DateTime();
                $this->period_start->modify("+1 day");
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
                $this->period_end = clone $this->period_start;
                $this->period_end->modify($this->default_interval_length);
            }
        }
        else
        {
            $this->period_end = $period_end;
        }
    }
    
    /**
     *  Intercept POST values
     */
    protected function interceptPostValues()
    {
        if (isset($_POST["date_start"]) && !empty($_POST["date_start"]))
        {
            $d = \DateTime::createFromFormat(self::DATE_FORMAT_ISO, $_POST["date_start"]);
            $this->setPeriodStart($d);
        }
        
        /* AUTOMATIC END DATE
        if (isset($_POST["date_end"]) && !empty($_POST["date_end"]))
        {
            $d = \DateTime::createFromFormat(self::DATE_FORMAT_ISO, $_POST["date_end"]);
            $this->setPeriodEnd($d);
        }
        */
        
        //CONFIG (checkboxes are NOT present in POST when unchecked)
        if(!empty($_POST))
        {
            $this->debug = isset($_POST["cfg_debug"]) && $_POST["cfg_debug"] == 1;
            $this->showHtml = isset($_POST["cfg_print_show_html"]) && $_POST["cfg_print_show_html"] == 1;
            $this->forceDownload = isset($_POST["cfg_print_force_download"]) && $_POST["cfg_print_force_download"] == 1;
        }
        
        if (isset($_POST["pdf"]))
        {
            $this->purpose = 'pdf';
        }
        
        if($this->debug)
        {
            print "<pre>POST: " . print_r($_POST, true) . "</pre>";
        }
    }
}