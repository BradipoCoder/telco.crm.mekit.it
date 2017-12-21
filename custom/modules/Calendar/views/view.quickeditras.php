<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.ajax.php');
require_once('include/EditView/EditView2.php');
require_once("modules/Calendar/CalendarUtils.php");
require_once('include/json_config.php');
require_once("data/BeanFactory.php");
require_once('include/SugarFields/SugarFieldHandler.php');

/**
 * Class CalendarViewQuickEditRas
 */
class CalendarViewQuickEditRas extends SugarView
{
    /** @var string */
    private $baseModuleName = "Cases";

    /** @var  \aCase */
    public $bean;

    /** @var  \Account */
    public $bean_account;

    /** @var bool */
    protected $editable = false;

    /**
     * Do something before display
     */
    public function preDisplay()
    {
        if (isset($this->view_object_map['currentBean'])) {
            $this->bean = $this->view_object_map['currentBean'];
            $this->editable = $this->bean->ACLAccess('Save');
        }
    }

    /**
     * Display
     */
    public function display()
    {
        //$moduleName = $this->baseModuleName;
        $_REQUEST['module'] = $this->baseModuleName;

        $gr = "";

        if (!empty($this->bean->id)) {
            global $json;
            $json = getJSONobj();
            $json_config = new json_config();
            $gr = $json_config->getFocusData($this->baseModuleName, $this->bean->id);
        }

        $json_arr = [
            'access' => 'yes',
            'module_name' => $this->bean->module_dir,
            'record' => $this->bean->id,
            'edit' => ($this->editable ? 1 : 0),
            'html' => $this->getMainDisplay(),
            'gr' => $gr
        ];

        if ($repeat_arr = CalendarUtils::get_sendback_repeat_data($this->bean)) {
            $json_arr = array_merge($json_arr, array("repeat" => $repeat_arr));
        }

        ob_clean();
        print json_encode($json_arr);
    }


    /**
     * @return string
     */
    protected function getMainDisplay()
    {
        /** @var \User $current_user */
        global $current_user;

        $timedate = \TimeDate::getInstance();
        //$userTimeZone = $timedate::userTimezone($current_user);// "Europe/Rome"
        $formattedUserDate = $timedate->now();


        $ss = new Sugar_Smarty();

        //COMMON
        $ss->assign('form_name', "CalendarEditView");

        //---------------------------------------------------------------------------------------------------------CASES
        $moduleName = "Cases";
        //Default values
        $this->bean->name = "RAS del " . $formattedUserDate;
        $this->bean->assigned_user_id = $current_user->id;
        $this->bean->assigned_user_name = $current_user->full_name;
        //Template assignments
        $ss->assign('module_cases', $moduleName);
        $ss->assign('fields_cases', $this->getFieldDefinitionsForBean($this->bean));
        $ss->assign('MOD_CASES', return_module_language($GLOBALS['current_language'], $moduleName));


        //------------------------------------------------------------------------------------------------------ACCOUNTS
        $moduleName = "Accounts";
        $record_account = null;
        //Bean
        $this->bean_account = \BeanFactory::getBean($moduleName, $record_account);
        //Default values
        $this->bean_account->name = "Micosoft";
        //$this->bean->assigned_user_id = $current_user->id;
        //$this->bean->assigned_user_name = $current_user->full_name;
        //Template assignments
        $ss->assign('module_accounts', $moduleName);
        $ss->assign('fields_accounts', $this->getFieldDefinitionsForBean($this->bean_account));
        $ss->assign('MOD_ACCOUNTS', return_module_language($GLOBALS['current_language'], $moduleName));


        return $ss->fetch("custom/modules/Calendar/tpls/ras.tpl");
    }

    /**
     *
     * @see include/EditView/EditView2.php:504
     *
     * @param \SugarBean $bean
     * @return array
     */
    protected function getFieldDefinitionsForBean(\SugarBean $bean)
    {
        /** @var array $app_list_strings */
        global $app_list_strings;

        $module_name = $bean->module_name;
        $module_prefix = strtolower($module_name);
        $fields_to_prefix = ["id", "name"];
        $fieldDefs = $bean->getFieldDefinitions();

        /* options for enum types */
        foreach ($fieldDefs as $key => &$defElement) {

            // MERGE FIELD DEFINITION - COPIED - IS THIS USEFUL?
            $defElement = (!empty($defElement) && !empty($ieldDefs[$key]['value']))
                ? array_merge($bean->field_defs[$key], $defElement)
                : $bean->field_defs[$key];

            // SET ENUM OPTIONS
            if (
                isset($defElement['options']) &&
                isset($app_list_strings[$defElement['options']])
            ) {
                if (
                    isset($GLOBALS['sugar_config']['enable_autocomplete']) &&
                    $GLOBALS['sugar_config']['enable_autocomplete'] == true
                ) {
                    $defElement['autocomplete'] = true;
                    $defElement['autocomplete_options'] = $defElement['options'];
                } else {
                    $defElement['autocomplete'] = false;
                }

                $defElement['options'] = $app_list_strings[$defElement['options']];
            }

            //SET BEAN DEFINED VALUES
            $value = isset($bean->$key) ? $bean->$key : '';

            if (empty($defElement['value'])) {
                $defElement['value'] = $value;
            }

            // ... OR POPULATE FROM REQUEST ?
            // $this->fieldDefs[$name]['value'] = $this->getValueFromRequest($_REQUEST, $name);
        }

        foreach($fields_to_prefix as $fieldName)
        {
            if(isset($fieldDefs[$fieldName]))
            {
                //$fieldVal = $fieldDefs[$fieldName];
                $prefixedFieldName = $module_prefix . "_" . $fieldName;
                $fieldDefs[$prefixedFieldName] = $fieldDefs[$fieldName];
                $fieldDefs[$prefixedFieldName]["name"] = $prefixedFieldName;
                unset($fieldDefs[$fieldName]);
            }
        }

        return $fieldDefs;
    }


    /**
     * @return string
     */
    public function getCasesEditForm()
    {
        $moduleName = "Cases";
        $source = $this->getBestViewdefsPath($moduleName);
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $moduleName);
        $tpl = $this->getCustomFilePathIfExists('include/EditView/EditView.tpl');


        $ev = new EditView();
        $ev->view = "QuickCreate";
        $ev->ss = new Sugar_Smarty();
        $ev->formName = "CalendarEditView";

        //Default values
        $this->bean->name = "Nuovo RAS di Adam";

        $ev->setup($moduleName, $this->bean, $source, $tpl);
        //$ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";

        $ev->process(false, "CalendarEditView");
        $html = $ev->display(false, true);

        return $html;
    }

    /**
     *
     * @return string
     */
    public function getMeetingsEditForm()
    {
        $moduleName = "Meetings";
        $source = $this->getBestViewdefsPath($moduleName);
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $moduleName);
        $tpl = $this->getCustomFilePathIfExists('include/EditView/EditView.tpl');


        $ev = new EditView();
        $ev->view = "QuickCreate";
        $ev->ss = new Sugar_Smarty();
        $ev->formName = "CalendarEditView";

        /** @var Meeting $bean */
        $bean = BeanFactory::getBean($moduleName);
        $bean->name = "Nuovo Meeting di Adam";


        $ev->setup($moduleName, $bean, $source, $tpl);


        //$ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";

        $ev->process(false, "CalendarEditView");

        $html = '';

        //$html .= '<pre>DEFS: ' . htmlentities(print_r( $ev->defs, true)). '</pre>';
        //$html .= '<pre>FIELDDEFS: ' . htmlentities(print_r( $ev->fieldDefs, true)). '</pre>';


        $html .= $ev->display(false, true);


        return $html;
    }

    /**
     *
     * @return string
     */
    public function getAccountEditForm()
    {
        $moduleName = "Accounts";
        $source = $this->getBestViewdefsPath($moduleName);
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $moduleName);
        $tpl = $this->getCustomFilePathIfExists('include/EditView/EditView.tpl');


        //$ev = new EditView();

        $ev = new EditView();
        $ev->view = "QuickCreate";
        $ev->ss = new Sugar_Smarty();
        $ev->formName = "CalendarEditView";

        /** @var Meeting $bean */
        $bean = BeanFactory::getBean($moduleName);
        $bean->name = "Nuovo Account di Adam";


        $ev->setup($moduleName, $bean, $source, $tpl);


        //$ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";

        $ev->process(false, "CalendarEditView");

        $html = '';

        //$html .= '<pre>DEFS: ' . htmlentities(print_r( $ev->defs, true)). '</pre>';
        //$html .= '<pre>FIELDDEFS: ' . htmlentities(print_r( $ev->fieldDefs, true)). '</pre>';


        $html .= $ev->display(false, true);


        return $html;
    }


    /**
     * @param \SugarBean $bean
     * @return mixed
     */
    public function isBeanEditable($bean)
    {
        return $bean->ACLAccess('Save');
    }

    /**
     * @param string $moduleName
     * @return string
     */
    protected function getBestViewdefsPath($moduleName)
    {
        $base = 'modules/' . $moduleName . '/metadata/';
        $source = 'custom/' . $base . 'quickcreatedefs.php';
        if (!file_exists($source)) {
            $source = $base . 'quickcreatedefs.php';
            if (!file_exists($source)) {
                $source = 'custom/' . $base . 'editviewdefs.php';
                if (!file_exists($source)) {
                    $source = $base . 'editviewdefs.php';
                }
            }
        }

        return $source;
    }
}
