<style>
    .odd-row{
        background-color: #eeeeee;
        color: #333333
    }
    .even-row{
        background-color: #cccccc;
        color: #333333
    }
    .not-set{
        background-color: orange;
        color: #fff
    }
    .duplicate{
        background-color: black;
        color: #fff
    }
    .fake-link{
        cursor: pointer;
    }
</style>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/timerUtils.js');
/*
$bob = $model;
$riderList = array();
$counterStart = 100;
$counterStop = 0;
foreach ( $bob as $key => $value )
{
    if ( $value->rider_num < $counterStart ) $counterStart = $value->rider_num;
    if ( $value->rider_num > $counterStop ) $counterStop = $value->rider_num;
    $returnStr = "<span class='fake-link' onclick='updateRiderNum({$value->id}, \"{$value->rider->name}\")'>{$value->rider->name}</span>";
    $riderList[ $value->rider_num ][ 'Rider Name' ] = isset($riderList[ $value->rider_num ][ 'Rider Name' ])
            ? $riderList[ $value->rider_num ][ 'Rider Name' ] . " <br /> " . $returnStr
            : $returnStr;
}
echo "<table><tr><th>Number</th><th>Name</th></tr>";
for ( $i = $counterStart; $i<=$counterStop; $i++ ){
    $className = ( $i % 2 == 0 ) ? 'even-row' : 'odd-row';
    if ( !isset( $riderList[ $i ][ 'Rider Name' ] ) ) $className = 'not-set';
    if ( stristr( $riderList[ $i ][ 'Rider Name' ] , " <br /> " ) ) $className = 'duplicate';
    echo "<tr class='$className'><td>$i</td><td>{$riderList[ $i ][ 'Rider Name' ]}</td></tr>";
}*/
?>
<div id="preRaceCheck"></div>
<script type='text/javascript'>
    $('#preRaceCheck').load('/eman/index.php/timingDetails/ajax?a=getPreRaceCheck&event_id=' + <?php echo $_REQUEST['event_id'] ; ?>);
    function updateRiderNum( riderId, riderName ){
        var newNum = prompt( "Enter new rider number for" + riderName );
        if( newNum !=null && newNum != '' ){
            setRiderNum(riderId, newNum, <?php echo $_REQUEST['event_id'] ; ?> )
        }
    }
</script>