<?php

class importBogusRidersCommand extends CConsoleCommand
{
    public function run( $args = array() )
    {
        $mode = isset( $args[ 0 ] ) ? $args[ 0 ] : '';
        if( !( $mode == 'test' || $mode == 'demo' ) )
        {
            die ( "\nWARNING: you must use this Command in either 'test' or 'demo' mode.\n\n");
        }
        $db = 'db' . ucfirst( $mode );
        Yii::app()->$db->createCommand()->truncateTable('timing_attributes');
        Yii::app()->$db->createCommand()->truncateTable('timing_details');
        Yii::app()->$db->createCommand()->truncateTable('timing_rider');
        $user = new consoleUser();
        Yii::app()->user->setState( 'mode',$mode );
        $this->loadCatClass();
        $this->addRiders($mode);
        $this->createRandomCredit();
    }

    private function addRiders( $mode )
    {
        $currentPath = brUtils::whereAmI( __FILE__ , 1 );
        $data =file_get_contents( $currentPath . "/data/{$mode}-names.txt" );
        $lines = explode("\n", $data);
        if ( count( $lines ) > 0 )
        {
            foreach ( $lines as $dataLine )
            {
                $lineArray = str_getcsv( $dataLine );
                $rider = new TimingRider();
                $rider->last_name = $lineArray[ 1 ];
                $rider->first_name = $lineArray[ 0 ];
                $rider->owner_id = '1' ;
                $rider->attrMap[ 'defaultCategory' ] = $this->getRandomCat();
                $rider->attrMap[ 'gender' ] = $lineArray[ 2 ];
                $rider->attrMap[ 'defaultClass' ] =$this->getRandomClass();
                $rider->attrMap[ 'team' ] =$this->getRandomTeam();
                $rider->attrMap[ 'handicap' ] = $this->getRandomHandicap();
                $rider->save();
                if ( !$rider->id )
                {
                    $p = print_r( error_get_last(), true );
                    echo "Error on rider {$rider->first_name} {$rider->last_name}\n $p";
                }
            }
        }
    }

    private function loadCatClass()
    {
        $events = TimingEvents::model()->findAll( );
        foreach ( $events as $e )
        {
            $e->attrMap['category'] = array( '-20'=>'under 20'
                ,'20s'=>'20 - 29','30s'=>'30 - 39','40s'=>'40 - 49'
                ,'50s'=>'50 - 59','60+'=>'60 and over');
            $e->attrMap['class']    = array( 'O'=>'Open', 'S'=>'Stock'
                , 'T'=>'Tandem', 'Team'=>'Team');
            $e->save();
        }
    }


    private function addLogins()
    {
        $logins = array( );
        //$pass = '827ccb0eea8a706c4c34a16891f84e7b' ; // = 12345
        $logins[] = array( 'first_name' => ucfirst( $mode )
            , 'last_name'=>'User'
            , 'username'=>$mode
            , 'password' => md5( '12345' ) );
        foreach ( $logins as $login )
        {
            $user = TimingRider::model()->find( 'first_name =:f and last_name=:l '
                    , array( ':f'=>$login[ 'first_name' ], ':l'=>$login[ 'last_name' ] ) );
            if( $user )
            {
                $user->attrMap[ 'login' ][ 'username' ] = $login[ 'username' ];
                $user->attrMap[ 'login' ][ 'password' ] = $login[ 'password' ];
                $user->save();
            }
            else
            {
                echo "Could not find user {$login['first_name']}:\n";
            }
        }
    }

    private function createRandomCredit()
    {
        $fullCount = rand( 20, 50 );
        $halfCount = rand( 15, 25 );
        echo "Full Passes = $fullCount & Half Passes = $halfCount\n";
        $this->giveCredit( $fullCount, 'F', 8 );
        $this->giveCredit( $halfCount, 'H', 4 );
    }

    private function giveCredit( $countOfRiders, $typeOfCredit, $countOfCredit )
    {
        $allRiders = TimingRider::model()->findAll();
        for( $i = 0; $i < $countOfRiders; $i++ )
        {
            $randRider = $allRiders[ rand( 0, count( $allRiders ) -1 ) ];
            $randRider->adjustCredit( $countOfCredit );
            $randRider->attrMap[ 'pass' ] = $typeOfCredit;
            echo "{$randRider->name} has a $typeOfCredit";
            if ( rand( 0, count( $allRiders ) ) % 7 == 0 )
            {
                $randRider->adjustDdCredit ( $countOfCredit );
                echo " and they Doubled Down";
            }
            $randRider->save();
            echo "\n";
        }
    }
    private function getRandomClass()
    {
        return ( rand(0, 2 ) % 2 == 0 )
                ? 'O'
                : 'S'
                ;
    }

    private function getRandomCat()
    {
        $riderAge = rand(9, 65);
        if ($riderAge >= 60)
        {
            $retVal = '60+';
        }
        elseif( $riderAge >=50 )
        {
                $retVal = '50s';
        }
        elseif( $riderAge < 13 || $riderAge >=40 )
        {
            $retVal = '40s';
        }
        elseif( $riderAge < 18 || $riderAge >= 30 )
        {
            $retVal = '30s';
        }
        elseif( $riderAge  >= 20 )
        {
            $retVal = '20s';
        }
        else
        {
            $retVal = '-20';
        }
        return$retVal;
    }

    private function getRandomTeam()
    {
        $teams = array( 'IC3', 'Flanders', "Eric's",'GP','Revolution','Synergy','FreeWheel','GearWest','','','','','');
        return $teams[ rand(0,12)];
    }

    private function getRandomHandicap()
    {
        $randSeed = rand( 2, 20 );
        $randMinutes = str_pad( rand( 2, $randSeed ), 2, '0', STR_PAD_LEFT );
        $randSeconds = str_pad( rand( 0, 59 ), 2, '0', STR_PAD_LEFT );
        $randMilliseconds = str_pad( rand( 0,999 ), 2, '0', STR_PAD_LEFT );
        return "00:$randMinutes:$randSeconds.$randMilliseconds";
    }
}
?>