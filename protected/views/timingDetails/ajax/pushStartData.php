<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    $dets = TimingDetails::model()->with('rider')->findAll( array('order'=>'t.rider_num'
        , 'condition'=>'event_id=:e AND start_time=:s AND finish_time=:f'
        ,'params'=> array( ':e'=>$_REQUEST['event_id'], ':s'=>'0', 'f'=>'25:00:00.000' ) ) );
$riders = array();
foreach( $dets as $rider=>$riderDetails )
{
 //   print_r( $riderDetails );
    $key = $riderDetails['rider_num'];
    $riders[ $key ][ 'rider_id' ] = $riderDetails[ 'rider_id' ];
    $riders[ $key ][ 'rider_num' ] = $riderDetails[ 'rider_num' ];
    $riders[ $key ][ 'start_time' ] = $riderDetails[ 'start_time' ];
    $riders[ $key ][ 'name' ] = "{$riderDetails->rider->first_name } {$riderDetails->rider->last_name }";
    $riders[ $key ][ 'class' ] = $riderDetails[ 'class' ];
    $riders[ $key ][ 'category' ] = $riderDetails[ 'category' ];
}
ksort( $riders );
echo json_encode( $riders );
?>
