<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

Yii::app()->db->createCommand()->truncateTable('timing_attributes');
Yii::app()->db->createCommand()->truncateTable('timing_details');
Yii::app()->db->createCommand()->truncateTable('timing_rider');

loadCatClass();

$data = file_get_contents( brUtils::whereAmI( __FILE__ , 2 ).'/data/prod-names.txt' );
$lines = explode("\n", $data);
if ( $returnString == '' && count( $lines ) > 0 )
{
     // the put all of the data into a huge hash to be processed
    $dataMap = array();
    $lineCounter = 0;

    foreach ( $lines as $dataLine )
    {
        $lineArray = str_getcsv( $dataLine );
        $rider = new TimingRider();
        $rider->last_name = $lineArray[ 0 ];
        $rider->first_name = $lineArray[ 1 ];
        $rider->owner_id = '1' ;
        $rider->attrMap[ 'defaultCategory' ] = $lineArray[ 2 ];
        $rider->attrMap[ 'gender' ] = $lineArray[ 3 ];
        $rider->attrMap[ 'defaultClass' ] =$lineArray[ 4 ];
        $rider->attrMap[ 'team' ] =$lineArray[ 5 ];
        if( $lineArray[ 6 ] ) $rider->attrMap[ 'contact' ][ 'email' ] =$lineArray[ 6 ];
        $rider->save();
        if ( $rider->id )
        {} //echo  "Saved {$rider->first_name} {$rider->last_name }  with ID { $rider->id }<br />" ;
        else {
            $p = print_r( error_get_last(), true );
            echo "Error on rider {$rider->first_name} {$rider->last_name} <pre>$p</pre>";
        }
    }
}

addLogins();
fixGender();
        ?>
    </body>
</html>

<?php
    function loadCatClass()
    {
        $events = TimingEvents::model()->findAll( );
        foreach ( $events as $e )
        {
            $e->attrMap['category'] = array( '-20'=>'under 20','20s'=>'20 - 29','30s'=>'30 - 39','40s'=>'40 - 49','50s'=>'50 - 59','60+'=>'60 and over');
            $e->attrMap['class']    = array( 'O'=>'Open', 'S'=>'Stock', 'T'=>'Tandem', 'Team'=>'Team');
            $e->save();
        }
    }
    function fixGender()
    {
        $sqlMale = <<<END
            UPDATE bigrings_timing.timing_attributes
                SET value = 'Male'
                WHERE name='gender' and value='M'
END;
        $conn = Yii::app()->db->createCommand($sqlMale);
        $rowCount = $conn->query();

        $sqlFemale = <<<END
            UPDATE bigrings_timing.timing_attributes
                SET value = 'Female'
                WHERE name='gender' and value='F'
END;
        $conn = Yii::app()->db->createCommand($sqlFemale);
        $rowCount = $conn->query();
    }

    function addLogins()
    {

        //add logins
        $logins = array( );
        $pass = '827ccb0eea8a706c4c34a16891f84e7b' ; // = 12345
        $logins[] = array( 'first_name' => 'Tim', 'last_name'=>'Turnquist', 'username'=>'tturnquist' );
        $logins[] = array( 'first_name' => 'Joel', 'last_name'=>'Boelke', 'username'=>'TnT', 'pass'=>'bab0a9611b2bf7094d878d15c4f66dc6' );
        foreach ( $logins as $login )
        {
            $user = TimingRider::model()->find( 'first_name =:f and last_name=:l '
                    , array( ':f'=>$login[ 'first_name' ], ':l'=>$login[ 'last_name' ] ) );
            if( $user )
            {
                $user->attrMap[ 'login' ][ 'username' ] = $login[ 'username' ];
                $user->attrMap[ 'login' ][ 'password' ] = $pass;
                $user->save();
            }
            else
            {
                echo "Could not find user {$login['first_name']}:<br />";
            }
        }
    }

?>