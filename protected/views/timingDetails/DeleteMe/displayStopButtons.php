<style>
    button, .startButton{ margin: 20px 0px; padding: 20; width: 130px }
</style>

<?php

$start = TimingEvents::model()->findByPk( $_REQUEST['event_id'] );
if( $start && isset( $start->start_time ) && '00:00:00' != $start->start_time )
{
    echo "<span class='startButton' id='starttime'>{$start->start_time}</span><hr />";
}
else
{
    echo CHtml::ajaxButton( 'Start'
            , array(
                'ajax' => array( 
                    'type'=>'POST'
                    ,'url' =>CController::createUrl('timingDetails/saveTime')
                    ,'update'=>'#starttime' //selector to update
                    ,'data'=>array('obj'=>'TimingEvents', 'key' => $_REQUEST['event_id']) )
            ));
    echo "<span id='starttime'></span><hr /><br />";
}
$riderList = TimingDetails::model()->findAll( 'event_id=:e ORDER BY rider_num'
        , array( ':e'=>$_REQUEST['event_id'] ) );
foreach ( $riderList as $rider )
{
    echo "<span id='rider_{$rider->id}' >";
    if ( isset( $rider->duration ) && '00:00:00' != $rider->duration )
    {
        echo "<span class='startButton' >{$rider->rider->name} {$rider->duration}</span><br />";
    }
    else
    {
        echo CHtml::ajaxButton( $rider->rider_num . " " . $rider->rider->name
                , array(
                    'ajax'=>array(
                        'type'=>'POST'
                        , 'url'=>CController::createurl('timingDetails/saveTime')
                        , 'update'=>'#rider_{$rider->id}'
                        , 'data'=>array( 'obj'=>'TimingDetails','key'=> $rider->id)
                    )
                )) . "<br />";
    }
    echo "</span>";
}
?>
