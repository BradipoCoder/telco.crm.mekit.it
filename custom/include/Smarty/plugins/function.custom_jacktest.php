<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * @param array $params
 * @param \Sugar_Smarty $smarty
 * @return string
 */
function smarty_function_custom_jacktest($params, &$smarty)
{
    $required_param_keys = ["module", "display_type", "form_name", "fields"];

    foreach($required_param_keys as $required_param_key)
    {
        if(!isset($params[$required_param_key])){
            $smarty->trigger_error("custom_jacktest: missing '".$required_param_key."' parameter");
            return "";
        }
    }

    foreach($params as $k => $v)
    {
        $smarty->assign($k, $v);
    }


    $display_params = [];
    $smarty->assign('display_params', $display_params);

    $html = $smarty->fetch("custom/include/Smarty/templates/custom_jacktest.tpl");

    return $html;
}
