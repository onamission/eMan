<?php
$ret = 'unique';
$d = TimingDetails::model()->findAll( 'event_id=:e and rider_num=:r'
        , array( ':e' => $_REQUEST['event_id'], ':r'=>$_REQUEST['rider_num'] ) );
foreach( $d as $r )
{
    $ret = 'duplicate';
}

echo json_encode($ret);
?>
