
<script type="text/javascript">
    var status = 'ok';
    var bigTimer;
    var smallTimer;
    var startedRiders = new Array();
    var ridersToStart;
    var TotalSeconds = 0;


    function getData( event_id ){
        status = "working";
        var ret = $.ajax({
            url : '../timingDetails/ajax?a=pushStartData&event_id='+event_id,
            dataType: 'json',
            beforeSend: function(){
                changeClassAndText( 'status_working'
                    , 'Working . . .'
                    , 'pull');
            },
            success: function(json){
               changeClassAndText( 'status_ok'
                    , 'Riders Fetched'
                    , 'pull');
                $("#data").data( json );
                },
            error: function(json){
                changeClassAndText( 'status_lazy'
                    , 'Fetch Error'
                    , 'pull');
                $("#data").data( json );
            }
        }).done(function( json ) {
        })
    };

     function setData( event_id ){
        status = "working";
        var ret = $.ajax({
            url : '../timingDetails/ajax?a=saveStartData&event_id='+event_id,
            type: 'POST',
            data: {'started': startedRiders },
            beforeSend: function(){
                changeClassAndText( 'status_working'
                    , 'Working . . .'
                    , 'wwwstatus');
            },
            success: function(json){
               changeClassAndText( 'status_ok'
                    , 'Sending: OK'
                    , 'wwwstatus');
                $("#data").data( json );
                },
            error: function(json){
                changeClassAndText( 'status_lazy'
                    , 'Sending: Delay'
                    , 'wwwstatus');
                $("#data").data( json );
            }
        }).done(function( json ) {
        })
    };

    function changeClassAndText(incoming, newText, element){
        $('#' + element).removeClass( );
        $('#' + element).addClass( incoming ).val( newText );
    }

    function startTimer(){
        if( $('#start').val() !== 'Start' ){
            clearInterval( smallTimer );
            clearInterval( bigTimer );
            $('#start').val('Start');
        }else{
            $('#start').val('Pause');
            bob( 'up' );
            bigTimer = setInterval( function(){
                bob( 'up' );
            },30000 );
        }
    }

    function bob ( el ){
        $.each( $('#data').data(), function(){
            numero = this.rider_num;
            if( !( numero in startedRiders ) ){
                nombre = this.name;
                tiempo = this.start_time;
                $('#'+el).text( "Up is : #" + numero + ' ' + nombre );
                TotalSeconds = 30;
                Tick( );
                return false;
            }
        });
    }

    function Tick( ) {
        TotalSeconds -= 1;

        if( TotalSeconds == 0 ){ StopTimer(); }
        else{
            UpdateTimer()
            smallTimer=setTimeout("Tick( )", 1000);
        }
    }

    function UpdateTimer(  ) {
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
        startedRiders[ numero ] = d;
        setData( <?php echo $model->event_id;?> );
    }

</script>

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
<div id="buttons" class="clear">
    <input type="button"
           value="Status: OK"
           name="wwwstatus"
           id="wwwstatus"
           class="status_ok"
           onclick="setData( <?php echo $model->event_id;?> );" />
    <input type="button"
           value="Get Riders"
           name="pull"
           id="pull"
           class="brown_button"
           onclick="getData( <?php echo $model->event_id;?> );" />
    <input type="button"
           value="Start"
           name="start"
           id="start"
           class="gray_button"
           onclick="startTimer('timer', 25);" />
</div>
<div id="data"></div>
<div id="data-start-time"></div>
<div class='up' id="up"></div>
<div id="Timer"></div>
<div class='ondeck' id="ondeck"></div>
<div class='inthehole' id="inthehole"></div>
    </b></div>