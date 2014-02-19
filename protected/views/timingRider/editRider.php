<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/timerUtils.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/registrationUtils.js?v=2');
/*$path = $_SERVER[ 'PATH_TRANSLATED' ];
$path = str_replace( 'index.php', '', $path );*/
?>
<div id="notification"></div>
<div id="activeRiderList"></div>
<form id="registrationForm" name="registrationForm" method="POST">
    <!--<input type="hidden" value="<?php //echo $args[ 'event_id' ];?>" id="event_id" name="event_id" /> -->
    <table class="regFormTable" >
        <tr>
            <td rowspan="50"  style="min-width:120px"  valign="top">
                <table>
                    <tr>
                        <td>
                            <label for="existingRiderNameInput">Check for Rider: </label><br />
                            <input id="existingRiderNameInput" type="text" />
                            <div id="loading_data"></div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="min-width:175px">
                <input id="riderId" name="rider_id"
                       value=""
                       type="text" class="hideMe" />
                First Name<input type="text" name="first_name" >
                <br />Last Name<input type="text" name="first_name" >
                <br />email<input type="text" name="email" >
            </td>
        </tr>
        <tr><td><input type="submit" /></td></tr>
    </table>
</form>

