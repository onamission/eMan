
<?php
// If a timestamp is sent from the client, then use it.  It should be the 
// javascript timestamp which is the number of microseconds since the epoch
// if no timestamp is sent in, then we need to get one at the server [in php]
$timestamp = ( isset( $_REQUEST[ 'timestamp' ] ) && 0 != $_REQUEST[ 'timestamp' ] )
    ? $_REQUEST[ 'timestamp' ]
    : floor( microtime( true ) * 1000 );
$ret = null;
$obj = null;
$obj_name = $_REQUEST['obj_name'];
eval( "\$obj = " . $obj_name . "::model()->findByPk( " . $_REQUEST['key']  . ');');

if ( $obj )
{
   // if ( isset( $obj->$_REQUEST['field'] ) )
   // {
        $obj->$_REQUEST['field'] = $timestamp; //microtime_float(); //timeDiffInMilSec( $start_time, $end_time );
        $obj->save();
        
        /* this section is moved to the TimingDetails object in the afterSave
        if ( 'TimingDetails' == $obj_name && 'finish_time' == $_REQUEST['field' ] )
        {
            // Just finding the object will create a duration which 
            // will then be saved to the db
            $durobj = TimingDetails::model()->findByPk( $obj->id );
            $durobj->save();
        }*/
        if ( 'TimingDetails' == $obj_name && 'start_time' == $_REQUEST['field'] )
            $ret = '<span style="go">GO!</span>';
        elseif ( 'TimingDetails' == $obj_name && 'finish_time' == $_REQUEST['field'] && '00:00:00' != $obj->start_time  )
        {
            //$timeDiff = timeDiffInMilSec($obj->start_time, $obj->finish_time);
            
            $ret = "<div class='startButton' >#{$durobj->rider_num} - " . $durobj->rider->name . " = " . $durobj->duration . '</div>' ;
        } else 
            $ret = '<span style="norm">' . $obj->$_REQUEST['field'] . '</span>' ;
   /* }
    else 
        $ret = 'Timing Error in saveTime()';*/
} else 
    $ret = 'Timing Error -- invaild input params in saveTime()';


echo $ret;


// using the new microsec from the epoc format, this function is not needed.
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return date('H:i:s', (float)$sec) . '.' . number_format( (float)$usec , 3) * 1000;
}

function timeDiffInMilSec( $s, $e )
{
    list( $sh, $sm, $ss ) = explode(':', $s);
    list( $eh, $em, $es ) = explode(':', $e );
    $start = ( $sh * 3600 ) + ( $sm * 60 ) + (float)$ss;
    $end   = ( $eh * 3600 ) + ( $em * 60 ) + (float)$es;
    $diff = ( $end - $start );
    $hours = str_pad( floor( $diff / 3600 ), 2, '0');
    $mins  = str_pad( floor( ( $diff - ( (int)$hours * 3600 ) ) / 60 ), 2, '0');
    $secs  = str_pad( floor( ( $diff - ( (int)$hours * 3600 ) - ( (int)$mins * 60 ) ) ), 2, '0');
    $milsec = number_format( ( $diff - floor( $diff ) ) * 1000 );
    return "$hours:$mins:$secs.$milsec";
}

?>

<style>
    .go{ font-size: 200px;}
</style>
