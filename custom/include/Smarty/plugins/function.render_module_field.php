<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * @param array $params
 * @param \Sugar_Smarty $smarty
 * @return string
 */
function smarty_function_render_module_field($params, &$smarty)
{
    //required parameter keys
    $required_param_keys = ["module", "form_name", "fields", "field_name"];

    foreach ($required_param_keys as $required_param_key) {
        if (!isset($params[$required_param_key])) {
            $msg = "[render_module_field] Missing required parameter: '" . $required_param_key . "'!";
            $smarty->trigger_error($msg);

            return '<span class="error">' . $msg . '</span>';
        }
    }

    //check field_name in fields and set it as vardef
    if (!array_key_exists($params["field_name"], $params["fields"])) {
        $msg = "[render_module_field] Field is not in vardefs: '" . $params["field_name"] . "'!";
        $smarty->trigger_error($msg);

        return '<span class="error">' . $msg . '</span>';
    }
    $params["vardef"] = $params["fields"][$params["field_name"]];

    //optional parameter keys
    $params["parent_field_array"] = isset($params["parent_field_array"]) ? $params["parent_field_array"] : 'fields';
    $params["display_type"] = isset($params["display_type"]) ? $params["display_type"] : 'EditView';
    $params["display_params"] = isset($params["display_params"]) ? $params["display_params"] : [];
    $params["access_key"] = isset($params["access_key"]) ? $params["access_key"] : null;
    $params["tab_index"] = isset($params["tab_index"]) ? $params["tab_index"] : 1;
    $params["type_override"] = isset($params["type_override"]) ? $params["type_override"] : null;


    // Assign all params to Smarty
    foreach ($params as $k => $v) {
        $smarty->assign($k, $v);
    }

    return $smarty->fetch("custom/include/Smarty/templates/render_module_field.tpl");
}
