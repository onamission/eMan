<?php
Yii::app()->clientScript->registerCoreScript('jquery');

$event = TimingEvents::model()->findByPk( $_REQUEST['event_id'] );

$event_name = $event->name;

$details = TimingDetails::model()->findAll( 'event_id=:e '
        . ' AND duration IS NOT NULL AND duration != "" AND duration NOT LIKE "%0:00:00" AND duration != "0"'
        . ' ORDER BY duration  '
        , array( ':e' => $_REQUEST['event_id'] ) );
echo printResults( $details, "Finished - Overall $event_name");

function printResults( $results, $result_name )
{
    $ret_str = '';
    $ret_str = "<h2>$result_name </h2><table>";
    $cnt = 1;
    $riderList=array();
    foreach ( $results as $row )
    {
        //$combinedTime = date( 'H:i:s', strtotime( "0" . $row->duration ) - strtotime(  $row->rider->handicap ) );
        list( $d, $du ) = explode('.',$row->duration);
        $dur = strtotime( $d );

        list( $h, $hu ) = explode( ".", $row->rider->handicap );
        $han = strtotime( $h );
        if ( $hu > $du )
        {
            $u = $hu - $du;
            $han -= 1;
        }
        else
        {
            $u = $du - $hu ;
        }
        $netTime = brUtils::convertSecondsToTime( $dur - $han ) . ".$u";
        $riderList[ $netTime ][ $row->duration ] = array(
            'name' => $row->rider->name,
            'rider_num' => $row->rider_num,
            'rider_class' => $row->rider_class,
            'rider_cat' => $row->rider_category,
            'rider_handicap'=> $row->rider->handicap
        );
    }

    ksort( $riderList );
    foreach ( $riderList as $net=>$details )
    {
        ksort( $details );
        foreach ( $details as $dur=>$dets )
        {
            $ret_str .= "<tr class='" . ( 0 == $cnt % 2  ? 'odd' : 'even' ) . "'>" ;
            $ret_str .= "<td class='count'>$cnt</td>"
            . "<td class='rider_num'>#" . $dets[ 'rider_num' ] . "</td>"
            . "<td class='rider'>" . $dets[ 'name' ] . "</td>"
            . "<td class='finish_time'>$dur</td>"
            . "<td class='finish_time'>" . $dets[ 'rider_category' ] ."</td>"
            . "<td class='finish_time'>" .$dets[ 'rider_class' ] . "</td>"
            . "<td class='finish_time'>" . $dets['rider_handicap' ]  . "</td>"
            . "<td class='finish_time'>$net</td></tr>";
            $cnt++;
        }
    }
    $ret_str .= "</table>";
    return $ret_str;
}


?>
<style>
    .count { width: 35px; text-align: right;padding: 5px;float:left; clear:left; height: 20px }
    .rider { width: 155px; text-align: left;padding: 5px; float:left ; font-size: 120%; font-weight: 120%; height: 20px}
    .rider_num { width: 55px; text-align: right;padding: 5px; float:left ; font-size: 120%; font-weight: 120%; height: 20px}
    .duration { width: 85px; text-align: right;padding: 5px; float:left; height: 20px }
    .odd { background-color: #fff; }
    .even { background-color: #fed; }
</style>

