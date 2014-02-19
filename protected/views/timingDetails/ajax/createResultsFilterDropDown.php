<?php
$filter = isset( $_REQUEST[ 'result_type'] )
    ? 'Timing' . ucfirst( $_REQUEST[ 'result_type'] )
    : 'TimingEvents';

if ( $filter == 'TimingEvents' )
{
    $label =  'an event';
    $column = 'name';
}
else
{
    $label =  "a rider";
    $column = 'last_name, first_name';
}
// retrieve the models from db
$models = $filter::model()->findAll(
                 array('order' => $column));

// format models as $key=>$value with listData
$list = CHtml::listData($models,
                'id', 'name');
echo CHtml::dropDownList('categories', $category,
              $list,
              array('empty' => "(Select $label)"));
?>
