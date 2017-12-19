<?php
$viewdefs['Cases'] =
    array(
        'CalendarCreate' =>
            array(
                'templateMeta' =>
                    array(
                        'maxColumns' => '2',
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'useTabs' => false,
                        'tabDefs' =>
                            array(
                                'LBL_QUICKCREATE_PANEL1' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                    ),
                'panels' =>
                    array(
                        'lbl_quickcreate_panel1' =>
                            array(
                                0 =>
                                    [
                                        0 => 'name',
                                    ],
                                1 =>
                                    [
                                        0 => [
                                            'name' => 'select_company',
                                            'label' => 'Azienda',
                                            'customCode' =>
                                                '{custom_jacktest module=$module display_type="EditView" form_name=$form_name fields=$fields field_name="name"}',
                                        ],
                                        /*
                                        1 => [
                                            'name' => 'account_name',
                                            'hideLabel' => 1,
                                        ]*/
                                    ],
                            ),
                    ),
            ),
    );

