<?php
$searchTerm = $_REQUEST['term'] ? $_REQUEST['term'] : '';
$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';

//die(var_dump($_REQUEST));
$riderList = array();
if ( $id == '' )
{
    $riders = array();
}

if ( $searchTerm != '' )
{
    $riders = TimingRider::model()->findAll('owner_id=:o and ( first_name LIKE :f or last_name LIKE :l ) order by first_name'
            , array( ':o'=>Yii::app()->user->owner_id, ':f'=>"%{$_REQUEST['term']}%", ':l'=>"%{$_REQUEST['term']}%" ) );
}
else
{
    $riders = array( 0 => TimingRider::model()->findByPk( $id ) );
}
foreach ( $riders as $rider )
{
    $riderDetails = array();
    // get TimingRider propertied
    foreach ( $rider as $key=>$value )
    {
        $riderDetails[$key] = $value;
    }
    $riderDetails['name'] = $rider->name;

    //get TimingRider dynamic Attributes
    $riderDetails['attributes'] = TimingRider::getAllAttributes('TimingRider', $rider->id);
    $riderList[] = $riderDetails;
}

// Cleaning up the term
if ( $searchTerm != '' )
{
    $term = trim(strip_tags($_GET['term']));

    // Rudimentary search
    $matches = array();
    foreach($riderList as $rider){
    //foreach($riders as $rider){
        if(stripos($rider['name'], $term) !== false){
            // Add the necessary "value" and "label" fields and append to result set
            $rider['value'] = $rider['name'];
            $rider['label'] = "{$rider['name']}";
            $matches[] = $rider;
        }
    }

    // Truncate, encode and return the results
    $matches = array_slice($matches, 0, 30);
}
elseif( $riderList )
{
    $riderList[0]['value'] = $riderList[0]['name'];
    $riderList[0]['label'] = "{$riderList[0]['name']}";
    $matches = $riderList[ 0 ];
}
print json_encode($matches);

?>
