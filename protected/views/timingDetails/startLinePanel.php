
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/timerUtils.js');
/*
 * Create the selector for which event is running
 */
$this->menu=array(
	array('label'=>'Manage Timing Details', 'url'=>array('admin')),
);
$continue = ( isset( $_REQUEST[ 'continue' ] ) ) ? 'Continue' : '';
?>

<div id="buttons">
    <form name="starter" id="starter" method="post">
        <?php if ( '' == $continue ) { ?>
        <input type="button" value="Start" name="start" id="start" onclick="CreateTimer('timer', 25);"/>
        <?php } ?>
        <input type="hidden" id="continue" name="continue" value="<?php echo $continue;?>" />
    </form>
</div>

<?php

/*
 *  If there is a reply, then show the display and run functions
 */
    // Get a list of riders in the event and set them up FOUR at a time...
    $dets = TimingDetails::model()->findAll( 'event_id=:e AND '
            . 'start_time=:s AND finish_time=:f ORDER BY rider_num'
        , array( ':e'=>$model->event_id, ':s'=>'0', 'f'=>'25:00:00.000' ) );
    if( isset( $dets[0] ) )
    {
        echo "<div class='up'>Up is: <b>#".$dets[0]->rider_num.' <br /> '
                . $dets[0]->rider->name . "</b><span id='countdown'></span></div>";
        if( isset( $dets[1] ) )
                echo "<div class='ondeck'>On deck: <b>#" . $dets[1]->rider_num.' - '
                    . $dets[1]->rider->name . "</b></div>";
        if( isset( $dets[2] ) )
                echo "<div class='inthehole'>In the hole is: <b>#"
                    .$dets[2]->rider_num.' - '
                    . $dets[2]->rider->name . "</b></div>";
        if( isset( $dets[3] ) )
                echo "<div class='nextup'>Next up is <b>#".$dets[3]->rider_num
                    .' - ' . $dets[3]->rider->name . "</b></div>";

//  Then let Javascript do the work:
?>
<script type="text/javascript">
<?php
if ( $continue == 'Continue' )
{?>
    $().ready(CreateTimer('timer', 26));
<?php } ?>
    var Timer;
    var TotalSeconds;


    function CreateTimer(TimerID, Time) {
        // first, set the form up to pass the right parameters to the next page
        $('#start').hide();
        $('#continue').val('Continue');
        Timer = document.getElementById('countdown');
        TotalSeconds = Time;
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
    }

    function Tick() {
        TotalSeconds -= 1;

        if( TotalSeconds == 0 ){ StopTimer(); }
        else{
            UpdateTimer()
            window.setTimeout("Tick()", 1000);
        }
    }

    function UpdateTimer() {
        Timer.innerHTML = TotalSeconds;
        var fontsize = ( ( 50 - TotalSeconds ) * 5 );
        Timer.style.fontSize = '' + fontsize + 'px'
        if(TotalSeconds < 6 ){ Timer.style.color="#FF0000" }
        else{ Timer.style.color="#000000"}
    }

    function StopTimer(){
        Timer.innerHTML = "GO!";
        Timer.style.color="green";
        var d = new Date();
        d = formatTime( d );
        $('#countdown').load('/eman/index.php/TimingDetails/ajax?a=saveTime'
             + '&key=<?php echo $dets[0]->id; ?>&obj_name=TimingDetails&field=start_time&timestamp=' + d ,"GO");
        var v = setTimeout( "go()",3460 );
    }

    function go(){
       // window.location.reload()
       document.forms['starter'].submit();
    }

</script>
<?php
    }
    else
    {
        // Once all riders have been started, then display that message
        echo "<div class='up'>all riders have left</div>";
    }
?>