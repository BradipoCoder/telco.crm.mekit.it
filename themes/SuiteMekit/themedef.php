<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$themedef = [
    'name' => 'Suite Mekit',
    'description' => 'SuiteCRM Mekit Theme',
    'version' => [
        'regex_matches' => ['.*']
    ],
    'group_tabs' => true,
    'classic' => true,
    'configurable' => true,
    'config_options' => [
        'display_sidebar' => [
            'vname' => 'LBL_DISPLAY_SIDEBAR',
            'type' => 'bool',
            'default' => true,
        ],
        'do_something_funky' => [
            'vname' => 'LBL_FUNKY_CHICKEN',
            'type' => 'bool',
            'default' => false,
        ],
    ],
];
