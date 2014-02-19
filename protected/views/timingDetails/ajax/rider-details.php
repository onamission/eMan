<?php
    if ( isset( $_REQUEST[ 'rider_id' ] ) )
    {
            $criteria = 'event_id=:e and rider_id =:r';
            $params = array( ':e' => $_REQUEST[ 'event_id' ]
                    , ':r' =>$_REQUEST[ 'rider_id' ] );
    }
    else
    {
            $criteria = 'event_id=:e';
            $params = array( ':e' => $_REQUEST[ 'event_id' ] );
    }
    $riders = TimingDetails::model()->findAll( $criteria, $params );
    echo CJSON::encode( $riders );

?>