<?php
// created: 2017-05-15 09:42:23
$dictionary["Account"]["fields"]["accounts_accounts_1"] = array (
  'name' => 'accounts_accounts_1',
  'type' => 'link',
  'relationship' => 'accounts_accounts_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_ACCOUNTS_1_FROM_ACCOUNTS_L_TITLE',
  'id_name' => 'accounts_accounts_1accounts_ida',
);
$dictionary["Account"]["fields"]["accounts_accounts_1_name"] = array (
  'name' => 'accounts_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_ACCOUNTS_1_FROM_ACCOUNTS_L_TITLE',
  'save' => true,
  'id_name' => 'accounts_accounts_1accounts_ida',
  'link' => 'accounts_accounts_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["accounts_accounts_1accounts_ida"] = array (
  'name' => 'accounts_accounts_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_accounts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_ACCOUNTS_1_FROM_ACCOUNTS_R_TITLE',
);
