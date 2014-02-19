
<?php


function calcTimeDiff( $end, $start )
{
    list( $endTime, $endMilliseconds ) = explode('.', $end);
    list( $startTime, $startMilliseconds ) = explode('.', $start);
    $endTime = strtotime($endTime);
    $startTime = strtotime($startTime);
    if( $endMilliseconds >= $startMilliseconds )
    {
        $diffMilliseconds = $endMilliseconds - $startMilliseconds;
    }else{
        $diffMilliseconds = 1000 + ( $endMilliseconds - $startMilliseconds );
        $endTime = $endTime - 1;
    }
    $timeDiff = $endTime - $startTime;
    $hours = str_pad( floor( $timeDiff/3600 ), 2, 0, STR_PAD_LEFT);
    $mins  = str_pad( floor( ( $timeDiff - ( $hours * 3600 ) ) / 60 ), 2, 0, STR_PAD_LEFT) ;
    $sec   = str_pad( floor( ( $timeDiff - ( $hours * 3600 ) -( $mins * 60 ) ) ), 2, 0, STR_PAD_LEFT) ;
    return "$hours:$mins:$sec.$diffMilliseconds";
}


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

//echo json_encode(array( 'riderName'=>'bob', 'riderDuration'=> 'chickens' ) );
echo json_encode(array( 'riderName'=>$rider->name, 'riderDuration'=> $raceResults->duration ) );

?>