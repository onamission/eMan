<?php
echo "<form>";
echo CHtml::dropDownList( 'eventid', array($_REQUEST['event_id'])
        , CHtml::listData( TimingEvents::model()->findAll( array('order'=>'ord') ), 'id', 'name' ) 
        , array( 'onchange' => "submit();" 
          , 'prompt'=>'Select an event'
            , )
        );
echo "</form";

?>

<?php
if ( isset( $_REQUEST['eventid' ] ) )
{
    echo "<table>";
    $rd = TimingDetails::model()->findAll('event_id=:e', array(':e'=>$_REQUEST['event_id']));
    foreach ( $rd as $det )
    {
        echo "<tr>";
        echo "<td>{$det->rider->name}</td>";
        echo "<td>" . CHtml::dropDownList( 'cat_' . $det_rider, array( $det->cat_id )
                , CHtml::listData( TimingCat::model()->findAll( array( ) ), 'id', 'name' )
                , array( 'onchange'=>'submit();' 
                , 'prompt'=>'Select a Category')) . "</td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "</tr>";
    }
    echo "</table";
}
?>
