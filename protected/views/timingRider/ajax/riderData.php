<?php
$r = TimingRider::model()->findByPk( $_REQUEST[ 'rider_id' ] );
$ed = TimingDetails::model()->findAll( 'rider_id=:r and event_id=:e '
        , array( ':r'=>$_REQUEST[ 'rider_id' ], ':e'=>$_REQUEST[ 'event_id' ] ) );

$retVal = array();
$retVal['open'] = $r->getHandicap( 'O' );
$retVal['ridesThisEvent'] = count( $ed );
$retVal['stock'] = $r->getHandicap( 'S' );
$retVal['fastest'] = $r->getFastestTime( );
$retVal['race_count'] = $r->getCountOfRaces( );
$retVal['last_race'] = $r->getLastRace( );
$retVal['pass'] = isset( $r->attrMap['pass'] )
        ? $r->attrMap['pass']
        : '';
$retVal['dd'] = isset( $r->attrMap['dd_credit'] )
        ? $r->attrMap['dd_credit']
        : '';
$retVal['credit'] = isset( $r->attrMap['credit'] )
        ? $r->attrMap['credit' ]
        : '';
$retVal['scratch_winner'] = isset( $r->attrMap['Scratch Winner'] )
        ? $r->attrMap['Scratch Winner']
        : '';
$retVal['handicap_winner'] = isset( $r->attrMap['Handicap Winner'] )
        ? $r->attrMap['Handicap Winner']
        : '';
$retVal['personal_record'] = isset( $r->attrMap['Personal Record'] )
        ? $r->attrMap['Personal Record']
        : '';
$retVal['mode'] = Yii::app()->user->getState( 'mode' );

echo json_encode($retVal);
?>
