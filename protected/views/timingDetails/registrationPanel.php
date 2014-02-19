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
    <input type="hidden" value="<?php echo $model->event_id;?>" id="event_id" name="event_id" />
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
                <label for="riderRaceNumber">Race Number: </label>
            </td>
            <td style="min-width:175px">
                <input id="raceFirstNumber" type="hidden" value="<?php
                    echo isset( $model->attrMap[ 'startNumber' ] )
                        ? $model->attrMap[ 'startNumber' ]
                        :1;?>"/>
                <input type="text" id="riderRaceNumber" name="riderRaceNumber"
                       value="<?php echo $model->rider_num?>"/><br />
            </td>
            <td  style="min-width:300px" id="rightCol" rowspan="10" >
                <table>
                    <tr>
                        <td style="min-width:100px">
                            <label for="rider_fastestTime">Fastest: </label>
                        </td>
                        <td rowspan="2" style="min-width:175px">
                            <input id="rider_fastestTime" disabled="disabled" class="stats" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rider_handicap_open">Open Handicap: </label>
                        </td>
                        <td rowspan="2">
                            <input id="rider_handicap_open" disabled="disabled" class="stats" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rider_handicap_stock">Stock Handicap: </label>
                        </td>
                        <td rowspan="2">
                            <input id="rider_handicap_stock" disabled="disabled" class="stats" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rider_countOfRaces">Race&nbsp;Count: </label>
                        </td>

                        <td rowspan="2">
                            <input id="rider_countOfRaces" disabled="disabled" class="stats" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rider_lastRace">Last&nbsp;Race: </label>
                        </td>
                        <td rowspan="2">
                            <input id="rider_lastRace" disabled="disabled" class="stats" />
                        </td>
                    </tr>
                 <!--   <tr>
                        <td></td>
                    </tr> -->
                    <tr>
                        <td colspan="2">
                            <div class="tooltip inline">
                                <div id="dd" class="inline" ></div>
                                <span>
                                    Double-Down
                                </span>
                            </div>
                             <div class="tooltip inline">
                                <div id="pass" class="inline" ></div>
                                <span>
                                    Credits
                                </span>
                            </div>
                            <div class="tooltip inline">
                                <div id="s_winner" class="inline"></div>
                                <span>
                                    <!-- <img class="callout" src="src/callout_black.gif" /> -->
                                    Scratch Wins
                                </span>
                            </div>
                            <div class="tooltip inline">
                                <div id="h_winner" class="inline"></div>
                                <span>
                                    <!-- <img class="callout" src="src/callout_black.gif" /> -->
                                    Handicap Wins
                                </span>
                            </div>
                            <div class="tooltip inline">
                                <div id="pr" class="inline"></div>
                                <span>
                                    <!-- <img class="callout" src="src/callout_black.gif" /> -->
                                    Personal&nbsp;Records
                                </span>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>
                <label for="riderStartTime">Est. Start Time: </label>
            </td>
            <td>
                <?php //$event = TimingEvents::model()->find( 'id=:i', array( ':i'=>$model->event_id) ); ?>
                <input id="raceStartTime" type="hidden" value="<?php echo $args[ 'startTime' ];?>"/>
                <input id="raceStartInterval" type="hidden" value="<?php
                    echo $args['interval'];?>"/>
                <span id="riderStartTime"></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="riderFirstName">First Name: </label>
            </td>
            <td>
                <input id="riderId" name="riderId"
                       value="<?php echo $model->rider_id;?>"
                       type="text" class="hideMe" />
                <input id="riderFirstName" name="riderFirstName"
                       value="<?php echo isset( $model->rider->first_name )
                       ? $model->rider->first_name
                               : '';?>"
                       type="text" class="registrationForm" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="riderLastName">Last Name: </label>
            </td>
            <td>
                <input id="riderLastName" name="riderLastName"
                       value="<?php echo isset( $model->rider->last_name )
                            ? $model->rider->last_name
                            : '';?>"
                       type="text"  class="registrationForm" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_contact_home_email">Email: </label>
            </td>
            <td>
                <input class ="registrationForm"
                       type="text" id="rider_contact_home_email"
                       name="rider_contact_home_email" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_team">Team or Club: </label>
            </td>
            <td>
                <input class ="registrationForm"
                       type="text" id="rider_team"
                       name="rider_team" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_gender">Gender: </label>
            </td>
            <td>
                <?php
                echo CHtml::dropDownList('rider_gender'
                        , ''
                        , array( 'Male'=>'Male', 'Female'=>'Female' )
                        , array( 'prompt'=>'Choose One . . .'
                            , 'id'=>'rider_gender'
                            , 'class'=>"registrationForm" ) ) ;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_defaultClass">Class: </label>
            </td>
            <td>
                <?php
                $classId = TimingAttributes::getTimingAttribute(
                          'TimingEvents'
                        , $model->event_id
                        , 'class' )->id;
                $classList = TimingAttributes::getTimingAttribute(
                          'class'
                        , $classId
                        , null
                        , null
                        , null
                        , 'all' );
                $classes = array();
                foreach ( $classList as $class )
                {
                    if( isset( $class->name ) )
                        $classes[ $class->name ] = $class->value;
                }
                echo CHtml::dropDownList( 'rider_defaultClass'
                        , ''
                        ,  $classes
                        , array( 'prompt'=>'Choose One . . .'
                            , 'id'=>'rider_defaultClass'
                            , 'class' =>"registrationForm")
                        ) ;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_defaultCategory">Category: </label>
            </td>
            <td>
                <?php
                $categoryId = TimingAttributes::getTimingAttribute( 'TimingEvents', $model->event_id, 'category' )->id;
                $categoryList = TimingAttributes::getTimingAttribute( 'category'
                        , $categoryId, null, null, null, 'all' );
                $categories = array();
                foreach ( $categoryList as $category )
                {
                    if ( isset( $category->name ) )
                        $categories[ $category->name ] =
                            isset( $category->value )
                                ? $category->value
                                : '';
                }
                echo CHtml::dropDownList( 'rider_defaultCategory'
                        , ''
                        ,  $categories
                        , array( 'prompt'=>'Choose One . . .'
                            , 'id'=>'rider_defaultCategory'
                            ,  'class' =>"registrationForm" ) ) ;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="rider_payment">Payment: </label>
            </td>
            <td><div id="rider_payment_div">
                <?php
               $payment = array( 'Full Season', 'Half Season', 'Check', 'Cash', 'Other');
               echo CHtml::dropDownList( 'rider_payment_event' . $model->event_id, '',  $payment
                        , array( 'prompt'=>'Choose One . . .', 'id'=>'rider_payment'  ));//,'class' =>"registrationForm" ) ) ;
                ?></div>
            </td>
        </tr>
        <tr>
            <td colspan="200">

                <input type="button" style="float:left;" value="Register Rider" id="submitRider" name="submitRider"  />
                <?php
                //$ajaxOptions = array('succes'=>'function(e,u) { $("#registrationForm").reset(); }');
                echo CHtml::resetButton('Reset', array( 'style'=>"float:left", 'id'=>'racerReset'));
                ?>
                <input type="button" value="Edit Racer" name="editRiderButton" id="editRiderButton" />
                <input type="button" value="Lock Racer" style="display:none;" name="lockRiderButton" id="lockRiderButton" />
            </td>
        </tr>


    </table>
</form>

<script type='text/javascript'>
    $("#activeRiderList").load(
        "/eman/index.php/timingDetails/ajax?a=ridersLeft&event_id=<?php echo $_REQUEST['event_id'] ; ?>"
    );
</script>