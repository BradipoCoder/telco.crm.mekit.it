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
     * List of elements to be handled as custom
     * @var array
     */
    protected $allowedCompoundModules = ["RAS"];

    /**
     *
     */
    protected function action_saveactivity()
    {
        $is_compound_module = false;
        $compound_module_name = "";

        $this->view = 'json';

        $this->view_object_map = [
            'jsonData' => [
                'access' => 'no',
                'error' => 1,
                'message' => 'Undefined controller error.'
            ]
        ];

        if ($is_compound_module = (isset($_REQUEST['current_module']) && in_array($_REQUEST['current_module'], $this->allowedCompoundModules)))
        {
            $compound_module_name = $_REQUEST['current_module'];
            $_REQUEST['current_module'] = "Cases";
        }

        if (!$this->retrieveCurrentBean('Save'))
        {
            $this->view_object_map["jsonData"] = array_merge($this->view_object_map["jsonData"], [
                'message' => 'You don\'t have "Save" access in module: ' . $_REQUEST['current_module']
            ]);
            return;
        }


        $module = $this->currentBean->module_dir;
        $bean = $this->currentBean;

        if (empty($_REQUEST['edit_all_recurrences']))
        {
            $repeat_fields = array('type', 'interval', 'count', 'until', 'dow', 'parent_id');
            foreach ($repeat_fields as $suffix) {
                unset($_POST['repeat_' . $suffix]);
            }
        }


        $path = "modules/{$bean->module_dir}/{$bean->object_name}FormBase.php";
        if (!file_exists($path)) {
            $path = "custom/" . $path;
            if (!file_exists($path)) {
                $this->view_object_map["jsonData"] = array_merge($this->view_object_map["jsonData"], [
                    'message' => 'File FormBase class for module ' . $bean->object_name . ' doesn\'t exist'
                ]);
                return;
            }
        }
        require_once($path);

        $className = "{$bean->object_name}FormBase";
        $reflection = new \ReflectionClass($className);
        /** @var \CaseFormBase $formBase */
        $formBase = $reflection->newInstance();

        try
        {
            $bean = $formBase->handleSave('', false, false);
        } catch(\Exception $e)
        {
            $this->view_object_map["jsonData"] = array_merge($this->view_object_map["jsonData"], [
                'message' => $e->getMessage()
            ]);
            return;
        }


        unset($_REQUEST['send_invites'], $_POST['send_invites']); // prevent invites sending for recurring activities


        $this->view_object_map["jsonData"] = array_merge($this->view_object_map["jsonData"], [
            'access' => 'yes',
            'error' => 0,
            'message' => 'OK - saved with id: ' . $bean->id
        ]);

    }

    /**
     * Action QuickEdit
     */
    protected function action_quickedit()
    {
        $is_compound_module = false;
        $compound_module_name = "";

        $this->view = 'quickedit';

        if ($is_compound_module = (isset($_REQUEST['current_module']) && in_array($_REQUEST['current_module'], $this->allowedCompoundModules)))
        {
            $compound_module_name = $_REQUEST['current_module'];
            $_REQUEST['current_module'] = "Cases";
        }

        if ($this->retrieveCurrentBean('Detail')) {
            $this->view_object_map['currentModule'] = $this->currentBean->module_dir;
            $this->view_object_map['currentBean'] = $this->currentBean;
        }

        if($is_compound_module)
        {
            $this->view = 'quickedit' . strtolower($compound_module_name);
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
        $access = true;

        $module = isset($_REQUEST['current_module']) && !empty($_REQUEST['current_module']) ? $_REQUEST['current_module'] : null;
        $record = isset($_REQUEST['record']) && !empty($_REQUEST['record']) ? $_REQUEST['record'] : null;

        $this->currentBean = BeanFactory::getBean($module, $record);
        if (!empty($actionToCheck)) {
            $access = $this->currentBean->ACLAccess($actionToCheck);
        }

        return $access;
    }

}
