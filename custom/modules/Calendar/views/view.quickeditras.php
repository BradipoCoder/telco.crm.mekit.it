<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

require_once('include/MVC/View/views/view.ajax.php');
require_once('include/EditView/EditView2.php');
require_once("modules/Calendar/CalendarUtils.php");
require_once('include/json_config.php');
require_once("data/BeanFactory.php");

/**
 * Class CalendarViewQuickEditRas
 */
class CalendarViewQuickEditRas extends SugarView
{
    /** @var EditView $ev */
    protected $ev;

    /**
     * @var boolean
     */
    protected $editable;

    public function preDisplay()
    {
        if (isset($this->view_object_map['currentBean'])) {
            $this->bean = $this->view_object_map['currentBean'];
            $this->editable = $this->bean->ACLAccess('Save');
        }
    }


    public function display()
    {
        $moduleName = $this->view_object_map['currentModule'];

        $_REQUEST['module'] = $moduleName;

        if (!empty($this->bean->id)) {
            global $json;
            $json = getJSONobj();
            $json_config = new json_config();
            $gr = $json_config->getFocusData($moduleName, $this->bean->id);
        } else {
            $gr = "";
        }

        $json_arr = [
            'access' => 'yes',
            'module_name' => $this->bean->module_dir,
            'record' => $this->bean->id,
            'edit' => $this->editable,
            /*'html'=> $this->ev->display(false, true),*/
            'html' => $this->getMainDisplay(),
            'gr' => $gr
        ];

        if($repeat_arr = CalendarUtils::get_sendback_repeat_data($this->bean)){
            $json_arr = array_merge($json_arr,array("repeat" => $repeat_arr));
        }

        ob_clean();
        print json_encode($json_arr);
    }


    /**
     * @return string
     */
    protected function getMainDisplay()
    {
        $ss = new Sugar_Smarty();

        $ss->assign('FORM_CASES', $this->getCasesEditForm());
        $ss->assign('FORM_ACCOUNTS', $this->getAccountEditForm());
        $ss->assign('FORM_MEETINGS', $this->getMeetingsEditForm());


        $answer = $ss->fetch("custom/modules/Calendar/tpls/ras.tpl");

        return $answer;
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


        //$this->ev = new EditView();

        $ev = new EditView();
        $ev->view = "QuickCreate";
        $ev->ss = new Sugar_Smarty();
        $ev->formName = "CalendarEditView";

        $this->bean->name = "Nuovo RAS di Adam";

        $ev->setup($moduleName, $this->bean, $source, $tpl);
        //$ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";
        $ev->process(false, "CalendarEditView");


        $html = $ev->display(false, true);

        /*
        $data = [];
        $data[] = print_r($ev, true);
        $html = '<pre>' . htmlentities(implode("\n", $data)). '</pre>';
        */

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


        //$this->ev = new EditView();

        $this->ev = new EditView();
        $this->ev->view = "QuickCreate";
        $this->ev->ss = new Sugar_Smarty();
        $this->ev->formName = "CalendarEditView";

        /** @var Meeting $bean */
        $bean = BeanFactory::getBean($moduleName);
        $bean->name = "Nuovo Meeting di Adam";



        $this->ev->setup($moduleName, $bean, $source, $tpl);



        //$this->ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$this->ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";

        $this->ev->process(false, "CalendarEditView");

        $html = '';

        //$html .= '<pre>DEFS: ' . htmlentities(print_r( $this->ev->defs, true)). '</pre>';
        //$html .= '<pre>FIELDDEFS: ' . htmlentities(print_r( $this->ev->fieldDefs, true)). '</pre>';



        $html .= $this->ev->display(false, true);



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


        //$this->ev = new EditView();

        $this->ev = new EditView();
        $this->ev->view = "QuickCreate";
        $this->ev->ss = new Sugar_Smarty();
        $this->ev->formName = "CalendarEditView";

        /** @var Meeting $bean */
        $bean = BeanFactory::getBean($moduleName);
        $bean->name = "Nuovo Account di Adam";



        $this->ev->setup($moduleName, $bean, $source, $tpl);



        //$this->ev->defs['templateMeta']['form']['headerTpl'] = "modules/Calendar/tpls/editHeader.tpl";
        //$this->ev->defs['templateMeta']['form']['footerTpl'] = "modules/Calendar/tpls/empty.tpl";

        $this->ev->process(false, "CalendarEditView");

        $html = '';

        //$html .= '<pre>DEFS: ' . htmlentities(print_r( $this->ev->defs, true)). '</pre>';
        //$html .= '<pre>FIELDDEFS: ' . htmlentities(print_r( $this->ev->fieldDefs, true)). '</pre>';



        $html .= $this->ev->display(false, true);



        return $html;
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
