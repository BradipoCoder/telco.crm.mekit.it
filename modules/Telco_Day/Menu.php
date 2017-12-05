<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings;


if (ACLController::checkAccess('Calendar', 'list', true)) {
    $module_menu[] = Array(
        "index.php?module=Calendar&action=index&view=day",
        'Calendario', /*$mod_strings['LNK_VIEW_CALENDAR'],*/
        "Today"
    );
}

