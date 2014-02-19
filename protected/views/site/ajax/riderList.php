<?php
$searchTerm = $_REQUEST['term'];
//die(var_dump($_REQUEST));
$riderList = array();
$riders = TimingRider::model()->findAll('owner_id=:o and ( first_name LIKE :f or last_name LIKE :l ) order by first_name'
        , array( ':o'=>Yii::app()->user->owner_id, ':f'=>"%{$_REQUEST['term']}%", ':l'=>"%{$_REQUEST['term']}%" ) );
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
    $riderDetails['attributes']['fastestTime'] = $rider->getFastestTime();
    $riderDetails['attributes']['handicap'] = $rider->getHandicap();
    $riderDetails['attributes']['countOfRaces'] = $rider->getCountOfRaces();
    $riderDetails['attributes']['lastRace'] = date( 'M-d-y', strtotime( $rider->getLastRace() ) );
    
    $riderList[] = $riderDetails;
}


// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
 
// Rudimentary search
$matches = array();
foreach($riderList as $rider){
	if(stripos($rider['name'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$rider['value'] = $rider['name'];
		$rider['label'] = "{$rider['name']}";
		$matches[] = $rider;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);

?>
