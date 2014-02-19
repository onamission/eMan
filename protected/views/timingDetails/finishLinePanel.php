<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/timerUtils.js');
?>
<input type='button' value='Stop!' onclick='postTheTime()' id='stopButton' />
<div id="activeRiderList"></div>
<table id="finishLineDetailHead">
    <tr>
        <th width="250px">Rider Number</th>
        <th width="150px">Raw Time</th>
        <th width="200px">Rider Name</th>
        <th width="150px">Rider Time</th>
    </tr>
</table>
<div id="finishLineDetail">
<table>
    <tr>
    <?php
    $allRiders = TimingDetails::model()->with( 'rider' )->findAll( array( 'condition'=> 'event_id=:e'
//            'event_id=:e and finish_time = 0'
            , 'params'=>array( ':e'=>$model->event_id ) 
            , 'order' =>'finish_time' )
        );
    $countOfRiders = 0;
    $stringCount = str_pad($countOfRiders, 4, '0', STR_PAD_LEFT);
    foreach ( $allRiders as $thisRider)
    {
//        $thisRiderNumber = str_pad( $thisRider->rider_num, 4, '0', STR_PAD_LEFT);
        $thisRiderNumber = $thisRider->finish_time != '25:00:00.000'
                ? $thisRider->rider_num
                : '';
        $thisRiderFinishTime = $thisRider->finish_time != '25:00:00.000'
                ? $thisRider->finish_time
                : '';
        $thisRiderName = $thisRider->finish_time != '25:00:00.000'
                ? $thisRider->rider->name
                : '';
        $thisRiderDuration = $thisRider->finish_time != '25:00:00.000'
                ? $thisRider->duration
                : '';
        $countOfRiders++;
        $stringCount = str_pad($countOfRiders, 4, '0', STR_PAD_LEFT);
    ?>
    <tr>

        <td width="250px">Finisher #<?php echo $countOfRiders; ?>
            <input type="text" name="rider_input<?php echo $thisRiderNumber; ?>"
                   class="finishLineInput"
                   id="rider_input<?php echo $stringCount; ?>"
                   onchange="getRiderData($(this).val(), '<?php echo "$stringCount'
                       , '{$model->event_id}"; ?>' )"
                   value ="<?php echo $thisRiderNumber;?>"/>
        <td width="150px" >
            <div id="raw_time<?php echo $stringCount; ?>" class='noMarg noPad'
            ondblclick="updateRawTime( '<?php echo $thisRiderFinishTime;?>', '<?php echo $stringCount; ?>')"><?php echo $thisRiderFinishTime;?></div></td>
        <td width="200px" id="rider_name<?php echo $stringCount; ?>">
            <?php echo $thisRiderName;?>
        </td>
        <td width="150px" id="rider_duration<?php echo $stringCount; ?>">
            <?php echo $thisRiderDuration;?>
        </td>
    </tr>
<?php } ?>
</table></div>
<div id='currentTime'></div>


<script type='text/javascript'>
    displayRiderResults( "activeRiderList"
        , "/eman/index.php/timingDetails/ajax?a=ridersLeft&event_id=<?php echo $_REQUEST['event_id'] ; ?>"
        , 5000
    );
    function updateRawTime( oldRawTime, riderSuffix ){
        var newTime = prompt( "Enter new raw time", oldRawTime);
        if( newTime !=null && newTime != '' ){
            $("#raw_time"+riderSuffix ).text( newTime );
            if( $("#rider_input"+riderSuffix).val() != null && $("#rider_input"+riderSuffix).val() !== '' ){
                setRiderData($("#rider_input"+riderSuffix).val(), newTime, riderSuffix, <?php echo $_REQUEST['event_id'] ; ?> )
            }
        }
    }
    var myVar=setInterval(function(){displayCurTime()},1000);

	function displayCurTime()
	{
		document.getElementById("currentTime").innerHTML= "The current time is " + whatTimeIsIt();
	}
    
</script>