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
        $allowed_compound_modules = ["RAS"];
        $is_compound_module = false;
        $compound_module_name = "";

        $this->view = 'quickedit';

        if (isset($_REQUEST['current_module']) && in_array($_REQUEST['current_module'], $allowed_compound_modules))
        {
            $is_compound_module = true;
            $compound_module_name = $_REQUEST['current_module'];
            $_REQUEST['current_module'] = "Meetings";
        }

        //@todo: open Bug: Why is this checking "Detail" instead of "edit"
        if ($this->retrieveCurrentBean('Detail')) {
            $this->view_object_map['currentModule'] = $this->currentBean->module_dir;
            $this->view_object_map['currentBean'] = $this->currentBean;
        }

        if($is_compound_module)
        {
            $this->view = 'quickedit' . strtolower($compound_module_name);



            //$this->view_object_map['currentModule'] = $this->currentBean->module_dir;
            //$this->view_object_map['currentBean'] = $this->currentBean;
        }
    }

    /**
     * Retrieves current activity bean and checks access to action
     *
     * @param boolean|string $actionToCheck
     * @return bool Result of check
     */
    protected function retrieveCurrentBean($actionToCheck = false)
    {
        $module = isset($_REQUEST['current_module']) && !empty($_REQUEST['current_module']) ? $_REQUEST['current_module'] : null;
        $record = isset($_REQUEST['record']) && !empty($_REQUEST['record']) ? $_REQUEST['record'] : null;

        $this->currentBean = BeanFactory::getBean($module, $record);

        if (!empty($actionToCheck)) {
            if (!$this->currentBean->ACLAccess($actionToCheck)) {
                $this->view = 'json';
                $jsonData = array(
                    'access' => 'no',
                );
                $this->view_object_map['jsonData'] = $jsonData;
                return false;
            }
        }

        return true;
    }

}
