<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
$inputData = json_decode($_POST[ 'started']);
 * 
 */
foreach ( $_POST[ 'started'] as $key=>$value )
{
    // process the data
    echo "<br />$key : $value";
    if ( isset( $value ) && $value !== '' )
    {
        $rider = TimingDetails::model()->find( 'rider_num=:r and event_id=:e', array( ':r'=> $key, ':e'=>$_GET['event_id'] ) );
        if ( $rider && $rider->start_time !== $value )
        {
            $rider->start_time = $value;
            $rider->save();
        }else{
            if ( $rider )echo " {$rider->start_time} === $value";
            else echo " . . . No Rider";
        }
    }else{
        echo " -> bad value of $value";
    }
    
}


//$p = print_r( $_POST, true );
//echo "<pre>$p</pre>";
?>