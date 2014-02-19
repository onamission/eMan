<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->baseUrl.'/css/main.css.php');
?>

<head>

    <link rel="shortcut icon" href="/eman/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/eman/css/main.css.php?v=1" />
    <script type="text/javascript" src="/eman/assets/f9861b16/jquery_1.8.2.js"></script>
    <script type="text/javascript" src="/eman/assets/f9861b16/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
</head>

<table>
    <tr>

<?php
$allRiders = TimingDetails::model()->with( "rider")->findAll( array( 'condition'=>'event_id=:e'
        , 'params' => array( ":e"=>$_REQUEST['event_id']), 'order'=>'rider_num' ));
$colCounter = 0;
foreach ( $allRiders as $rider )
{
    if( $colCounter % 10 == 0 )
    {
        echo "</tr><tr>";
    }
    $riderId = $rider->rider_num;
    $riderName = $rider->rider->name;
    $class =  "notStarted";
    if ( $rider->start_time != '' && $rider->start_time != 0 )
    {
        $class = "stillOut" ;
    }
//    if ($rider->duration != '' && $rider->duration != 0) {
    if (strlen( $rider->duration ) > 1 )
    {
    $class = "finishedRiding";
    }
    echo "<td class='noPad noMarg'><div id='rider_$riderId' "
            . "class='$class riderStatus noPad' "
            . "onmouseover='showMe(\"tooltip$riderId\");' "
            . "onmouseout='hideMe(\"tooltip$riderId\");'>"
            . $riderId . "</div>";
    ?>
        <div class="tooltip2"
             id="tooltip<?php echo $riderId;?>"
             style="z-index:<?php echo $riderId + 100;?>">
            <?php echo $riderName; ?>
        </div>
    </td>
<?php
    $colCounter++;
}
?>
    </tr>
</table>

<script>
    function showMe( elementId ){
        $('#'+elementId).show();
    }
    function hideMe( elementId ){
        $('#'+elementId).hide();
    }
</script>
