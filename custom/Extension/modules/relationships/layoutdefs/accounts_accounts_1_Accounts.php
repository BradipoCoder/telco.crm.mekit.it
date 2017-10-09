<?php
 // created: 2017-05-15 09:42:23
$layout_defs["Accounts"]["subpanel_setup"]['accounts_accounts_1accounts_ida'] = array (
  'order' => 100,
  'module' => 'Accounts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_ACCOUNTS_1_FROM_ACCOUNTS_R_TITLE',
  'get_subpanel_data' => 'accounts_accounts_1accounts_ida',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
