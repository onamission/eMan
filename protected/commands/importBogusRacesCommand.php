<?php
class importBogusRacesCommand extends CConsoleCommand
{
    public function run( $args = array() )
    {
        $mode = isset( $args[ 0 ] ) ? $args[ 0 ] : '';
        if( !( $mode == 'test' || $mode == 'demo' ) )
        {
            die ( "\nWARNING: you must use this Command in either 'test' or 'demo' mode.\n\n");
        }
        $user = new consoleUser();
        Yii::app()->user->setState( 'mode',$mode );

        $raceList = TimingEvents::model()->findAll( 'eventDate<:d', array( ':d' => date('Y-m-d') ) );
        $racerList = TimingRider::model()->findAll();
        foreach ( $raceList as $race )
        {
            echo "Processing race: " .$race->name . "\n";
            $raceFactor = brUtils::getRandomFactor( 6 );
            // for each race, start with race number 1 and increment through the racers
            for ( $racerNum = 1; $racerNum <= rand( 60,100); $racerNum++ )
            {
                $rider = $this->getRandomRider( $race, $racerList );
                $dets = new TimingDetails();
                $dets->start_time = $this->calcStartTime( $racerNum );
                $dets->save();   // save the record witht the start time to get the handicap
                $dets->duration = $this->getRandomDuration( $rider, $raceFactor );
                $dets->finish_time = $this->calcFinishTime( $dets->start_time, $dets->duration );
                $dets->rider_num = $racerNum;
                $dets->event_id = $race->id;
                $dets->rider_id = $rider->id;
                $dets->rider_category = $rider->attrMap[ 'defaultCategory' ];
                $dets->rider_class = $rider->attrMap[ 'defaultClass' ];
                $dets->save();
            }
            // calc race winners and update rider record
            $this->calcWinners( $race );
        }
    }

    private function getRandomRider( $race, $racerList )
    {
        do{
            $randIndex = rand( 0, count( $racerList ) - 1 );
            $randomRider = $racerList[ $randIndex ];
            $dets = TimingDetails::model()->find( 'event_id =:e and rider_id =:r'
                    , array( ':e'=> $race->id, ':r'=>$randomRider->id ) );
        } while ( $dets );
        return $randomRider;
    }

    private function calcStartTime( $riderNum )
    {
        $sevenOclock = ( 19*60*60 );
        $seconds = ( 30 * ( (int)$riderNum -1 ) ) + $sevenOclock;
        return brUtils::convertSecondsToTime( $seconds );
    }

    private function getRandomDuration( $rider , $raceFactor )
    {
        $catFactor = $rider->attrMap[ 'defaultCategory' ] == 'S' ? 360 : 0;
        $personFactor = brUtils::getRandomFactor(10);
        $randPercent = rand(0, $raceFactor + $personFactor ) ;
        $rPer = ( 100 - $randPercent ) / 100;
        $establishedHandicap = $rider->getHandicap( $rider->attrMap[ 'defaultClass'] );
        $handicap = ( $establishedHandicap !== '00:00:00' )
                ? brUtils::getTimeInSeconds( $establishedHandicap )
                : brUtils::getTimeInSeconds( $rider->attrMap[ 'handicap' ] );
        $duration = brUtils::getTimeInSeconds( '00:21:30' ) + ( ( $catFactor + $handicap ) * $rPer );
        $randomMillisec = rand( 0, 999 )/1000;
        return brUtils::convertSecondsToTime( ( $duration + $randomMillisec ) );
    }

    private function calcFinishTime( $startTime, $duration )
    {
        $finishTime =  brUtils::getTimeInSeconds( $startTime )
                + brUtils::getTimeInSeconds( $duration);
        return brUtils::convertSecondsToTime( $finishTime );
    }

    private function calcWinners( $event )
    {
        $scratchWinner = $event->getWinner( 'scratch' ) ;
        if ( $scratchWinner )
        {
            $scratchWinner->attrMap[ 'Scratch Winner' ]
                    = brUtils::increment( isset( $scratchWinner->attrMap[ 'Scratch Winner' ] )
                        ? $scratchWinner->attrMap[ 'Scratch Winner' ]
                        : 0 );
            $scratchWinner->save();
           // print_r( $scratchWinner->getErrors() );
            echo "\tScratch Winner = {$scratchWinner->name} \n";
        }
        $handicapWinner = $event->getWinner( 'net' );
        if ( $handicapWinner )
        {
            $handicapWinner->attrMap[ 'Handicap Winner' ]
                = brUtils::increment( isset( $handicapWinner->attrMap[ 'Handicap Winner' ] )
                        ? $handicapWinner->attrMap[ 'Handicap Winner' ]
                        : 0 );
            $handicapWinner->save();
            echo "\tHandicap Winner = {$handicapWinner->name} \n";
        }
    }

}
?>
