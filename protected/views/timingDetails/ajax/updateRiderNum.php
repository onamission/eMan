<?php

$detailId = $_REQUEST['id'];
$riderNum = $_REQUEST['rider_num'];

$raceDets = TimingDetails::model()->findByPk( $detailId);
//$raceDetails = TimingDetails::model()->find('id=:i', array(':i'=> $detailId ) );
//$p = print_r($raceDets,true);
//die ("<pre>$p</pre>");
$raceDets->rider_num = $riderNum;
$raceDets->save();
