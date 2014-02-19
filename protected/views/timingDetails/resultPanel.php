<div style='position:relative;'><?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/timerUtils.js');
$timeout = ( Yii::app()->user->isGuest )? 500000 : 5000 ;
$eventDetails = TimingEvents::model()->find( 'id=:e', array(':e'=>$_REQUEST['event_id'] ));
switch ( $eventDetails->event_status ) {
    case 'Preliminary':
        $msg = "Results posted are premilinary."
            . "<div style='font-size:70%'; line-height:20px;'><br />This means that they have not been seen or corrected by an official yet, so please be patient.</div>";
        $cls='error';
        break;
    case 'Pending':
        $msg = "Results have been seen and corrected by an official"
            . "<div style='font-size:70%'>but are in a 'grace-period' before being finalized. If you see an error please contact a race official.</div>";
        $cls='warning';
        break;
    case 'Final':
        $msg = "These results are final "
            . "<div style='font-size:70%; line-height:20px;'><br />But, if you see an error, please contact a race official,<br /> and we will do everything we can to correct it.</div>";
        $cls='success';
        break;
    default:
        $msg = "Results will be posted as soon as they are available";
        $cls='error';
}
echo "<div id='notification' class='$cls rightTop mini'>$msg</div>";
?>
<div id="activeRiderList" ></div>
<div id="results_controls"><b>Sort by:</b><br />
    <input type="radio" name="result_type" id="result_type" value="scratch" onclick="getResults( )" />
        Scratch Time<br />
    <input type="radio" name="result_type" id="result_type" value="handicap" onclick="getResults( )" />
        Handicapped Time
</div>
<div id="results_group"><b>Filter by:</b><br />
    <input type="radio" name="result_group" id="result_group" value='all' onclick="getResults( )" />
        No Filter -- all results<br />
    <input type="radio" name="result_group" id="result_group" value="rider_category" onclick="getResults( )" />
        By Category<br />
    <input type="radio" name="result_group" id="result_group" value="rider_class" onclick="getResults( )" />
        By Class
</div>
<div id="results" ></div>
</div>
<script type='text/javascript'>
    var refreshId;
    <?php if( !Yii::app()->user->isGuest )
    { ?>
    	displayRiderStatus(<?php echo $_REQUEST['event_id'] ; ?> );
    <?php } ?>
    $(document).ready( function(){ getResults();} );
function getResults( )
{
    var groupby =  $("input[name='result_group']:checked").val();
    var sortby = $("input[name='result_type']:checked").val();
    if( refreshId ){ clearInterval( refreshId ) };
    var url = '/eman/index.php/timingDetails/ajax?a=showEventResults';
    $('#results').load( url + '&event_id=<?php echo $_REQUEST[ 'event_id' ]; ?>&sort=' + sortby + '&group=' + groupby )
    refreshId = setInterval(function() {
       $("#results").load( url + '&event_id=<?php echo $_REQUEST[ 'event_id' ]; ?>&sort=' + sortby + '&group=' + groupby )
    }, <?php echo $timeout;?>);
    $.ajaxSetup({ cache: false });
}
</script>