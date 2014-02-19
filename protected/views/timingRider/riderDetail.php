
<?php
/**
 * 
 * This simple page simply takes data from the user interface, combines it with start line data, calculates the riders
 *   overall time, saves it to the database and returns the rider's name and time back to the interface.
 * 
 */

$riderCriteria = '';
$riderCriteriaValue = array();
$retVal = array(  );
foreach ( $_REQUEST as $key => $value )
{
    if ( preg_match('/^rider_(.*)$/', $key, $matches) )
    {
        if ( $riderCriteria != '' ) $riderCriteria .= " and ";
        $riderCriteria .= "{$matches[1]}=:{$matches[1]}";
        $riderCriteriaValue[ ":{$matches[1]}"] = $value;
    }    
}
$riderList = TimingRider::model()->findAll( $riderCriteria, $riderCriteriaValue );
foreach ( $riderList as $rider )
{
    $indx = $rider->id;
    foreach ( $rider as $key => $attributeVal )
    {
        $retVal[$indx][ $key ] = $attributeVal;
    }
}
echo json_encode( $retVal );



?>