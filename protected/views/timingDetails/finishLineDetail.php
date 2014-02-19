
<?php
/**
 *
 * This simple page simply takes data from the user interface, combines it with start line data, calculates the riders
 *   overall time, saves it to the database and returns the rider's name and time back to the interface.
 *
 */
$riderID = $_REQUEST['rider_id'];
$riderEndTime = str_replace('%3A', ':', $_REQUEST['time'] );
$eventId = $_REQUEST['event_id'];

$raceResults = TimingDetails::model()->find( 'rider_num=:r and event_id=:e', array(':r'=>$riderID, ':e'=>$eventId ) );
$raceResults->finish_time = $riderEndTime;
$raceResults->duration = calcTimeDiff( $raceResults->finish_time, $raceResults->start_time );
$raceResults->save();

$rider = TimingRider::model()->find( 'id=:i', array(':i'=>$raceResults->rider_id ) );

echo json_encode(array( 'name'=>$rider->name, 'duration'=> $raceResults->duration ) );



function calcTimeDiff( $end, $start )
{
    $endTime =brUtils::getTimeInSeconds($end);
    $startTime = brUtils::getTimeInSeconds($start);
    return brUtils::convertSecondsToTime ( $endTime - $startTime );
}
?>