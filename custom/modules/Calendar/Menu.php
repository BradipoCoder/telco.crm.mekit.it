<?php

/**
 * NOT LOADED !
 */


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings;

$module_menu[] = Array(
    "index.php?module=Telco_Day&action=index",
    "Telco Day", /*$mod_strings['LNK_NEW_MEETING'],*/
    "Telco_day"
);

if (ACLController::checkAccess('Meetings', 'edit', true)) {
    $module_menu[] = Array(
        "index.php?module=Meetings&action=EditView&return_module=Meetings&return_action=DetailView",
        $mod_strings['LNK_NEW_MEETING'],
        "Schedule_Meeting"
    );
}
if (ACLController::checkAccess('Calls', 'edit', true)) {
    $module_menu[] = Array(
        "index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView",
        $mod_strings['LNK_NEW_CALL'],
        "Schedule_Call"
    );
}
if (ACLController::checkAccess('Tasks', 'edit', true)) {
    $module_menu[] = Array(
        "index.php?module=Tasks&action=EditView&return_module=Tasks&return_action=DetailView",
        $mod_strings['LNK_NEW_TASK'],
        "Create"
    );
}
if (ACLController::checkAccess('Calendar', 'list', true)) {
    $module_menu[] = Array(
        "index.php?module=Calendar&action=index&view=day",
        $mod_strings['LNK_VIEW_CALENDAR'],
        "Today"
    );
}


?>
