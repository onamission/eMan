<?php
echo "Event Control Panel<br />";

$this->menu=array(
	array('label'=>'Create Event', 'url'=>array('/timingEvents/create')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);echo "<form>";

$eventId = CHttpRequest::getParam( 'event_id' );

echo CHtml::dropDownList( 'event_id', array($eventId)
        , CHtml::listData( TimingEvents::model()->findAll( 'owner_id=:o AND eventDate>=:d'
                , array(':o'=>Yii::app()->user->owner_id, ':d'=> date( 'Y-m-d' ) )
                , array('order'=>'ord') ), 'id', 'name' )
        , array( 'onchange' => "submit();"
          , 'prompt'=>'Select an event'
            , )
        );
echo "</form>";

if ( isset( $_REQUEST['event_id' ] ) )
{
    $event = TimingEvents::model()->find( 'id=:e', array(':e'=>$_REQUEST['event_id']) );
    echo " <ul id='controlPanelMenu'><li>";
 //   echo CHtml::link( 'Edit ' . $event->name, array('/timingEvents/update',  'event_id'=> $_REQUEST['event_id' ] ) );
 //   echo " </li><li>";
    echo CHtml::link( 'Register Riders ', array('registrationPanel', 'event_id' => $_REQUEST['event_id' ] ) );
    echo " </li><li>";
    echo CHtml::link( 'Start Line Function', array('startLinePanel3', 'event_id' => $_REQUEST['event_id' ] ) );
    echo " </li><li>";
    echo CHtml::link( 'Pre-Race Check', array('preRaceCheck', 'event_id'=> $_REQUEST['event_id' ] ) );
    echo " </li><li>";
    echo CHtml::link( 'Finish Line Function', array('finishLinePanel', 'event_id'=> $_REQUEST['event_id' ] ) );
    echo " </li><li>";
    echo CHtml::link( 'View Results', array('resultPanel','event_id'=> $_REQUEST['event_id' ] ) );
  //  echo " </li><li>";
 //   echo CHtml::link( 'Edit Rider Results', array('editTime', 'event_id'=>  $_REQUEST['event_id' ] ) );
    echo " </li></ul>";
}

?>
