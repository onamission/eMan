<?php
$detsList = TimingDetails::model()->findAll('event_id=:e', array(':e'=>$_REQUEST['event_id']));
$riderList = array();
$counterStart = 100;
$counterStop = 0;
foreach ( $detsList as $key => $value )
{
    if ( $value->rider_num < $counterStart ) $counterStart = $value->rider_num;
    if ( $value->rider_num > $counterStop ) $counterStop = $value->rider_num;
    $returnStr = "<span class='fake-link' onclick='updateRiderNum({$value->id}, \"{$value->rider->name}\")'>{$value->rider->name}</span>";
    $riderList[ $value->rider_num ][ 'Rider Name' ] = isset($riderList[ $value->rider_num ][ 'Rider Name' ])
            ? $riderList[ $value->rider_num ][ 'Rider Name' ] . " <br /> " . $returnStr
            : $returnStr;
}
echo "<table><tr><th>Number</th><th>Name</th></tr>";
for ( $i = $counterStart; $i<=$counterStop; $i++ ){
    $className = ( $i % 2 == 0 ) ? 'even-row' : 'odd-row';
    if ( !isset( $riderList[ $i ][ 'Rider Name' ] ) ) $className = 'not-set';
    if ( stristr( $riderList[ $i ][ 'Rider Name' ] , " <br /> " ) ) $className = 'duplicate';
    echo "<tr class='$className'><td>$i</td><td>{$riderList[ $i ][ 'Rider Name' ]}</td></tr>";
}