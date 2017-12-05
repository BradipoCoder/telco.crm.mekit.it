<?php

$dictionary['Telco_Day'] = array(
    'table'   => 'telco_day',
    'audited' => true,
    'fields' => array(
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'dbType' => 'varchar',
            'type' => 'name',
            'len' => '64',
            'comment' => 'The name',
            'importable' => 'required',
            'required' => true,
        ),
    ),
);


VardefManager::createVardef(
    'Telco_Day',
    'Telco_Day',
    array('default')
);
