<?php
$handicap = TimingRider::model()->findByPk( $_REQUEST[ 'id' ] )->getHandicap( $_REQUEST[ 'class' ] );

echo $handicap;
?>
