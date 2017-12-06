<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once("modules/Calendar/controller.php");
require_once("data/BeanFactory.php");

class CustomCalendarController extends CalendarController
{

    /**
     * Bean that is being handled by the Calendar's current action.
     * @var SugarBean $currentBean
     */
    protected $currentBean = null;

    /**
     * Action QuickEdit
     */
    protected function action_quickedit()
    {
        if (isset($_REQUEST['current_module']) && $_REQUEST['current_module'] == "RAS") {
            $this->view = 'quickeditras';

            $record = null;
            if (isset($_REQUEST['record']) && !empty($_REQUEST['record'])) {
                $record = $_REQUEST['record'];
            }


            $this->currentBean = BeanFactory::getBean("Meetings", $record);

            if ($this->currentBean) {
                $this->view_object_map['currentModule'] = $this->currentBean->module_dir;
                $this->view_object_map['currentBean'] = $this->currentBean;
            }


        } else {
            die("CM: " . $_POST['current_module']);//parent::action_quickedit();
        }
    }

}
