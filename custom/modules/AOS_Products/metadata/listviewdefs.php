<?php
$listViewDefs ['AOS_Products'] = 
array (
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
  ),
  'AOS_PRODUCT_CATEGORY_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
    'id' => 'AOS_PRODUCT_CATEGORY_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'aos_product_category_id',
    ),
  ),
  'CATEGORY' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_CATEGORY',
    'width' => '10%',
    'default' => true,
  ),
  'PART_NUMBER' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PART_NUMBER',
    'default' => true,
  ),
  'PART_NUMBER_OLD' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_PART_NUMBER_OLD',
    'width' => '10%',
    'default' => true,
  ),
  'COST' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'default' => true,
  ),
  'PRICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
);
;
?>
