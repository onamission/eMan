<?php
    header("Content-type: text/css; charset: UTF-8");
    $cssColor1 = ( isset( $_REQUEST[ 'cc1' ] ) ) ? $_REQUEST[ 'cc1' ] : "C07730";
    $cssColor2 = ( isset( $_REQUEST[ 'cc2' ] ) ) ? $_REQUEST[ 'cc2' ] : "98272B";
    $cssColor3 = ( isset( $_REQUEST[ 'cc3' ] ) ) ? $_REQUEST[ 'cc3' ] : "ebebaa";
    $cssColor4 = ( isset( $_REQUEST[ 'cc4' ] ) ) ? $_REQUEST[ 'cc4' ] : "333333";
    $logo = ( isset( $_REQUEST[ 'logo' ] ) ) ? $_REQUEST[ 'logo' ] : "";
    include_once("csscolor.php");
    $imagesFolder = "../images/";
    $primaryCssColor   = new CSS_Color( $cssColor1 );
    $secondaryCssColor = new CSS_Color( $cssColor2 );
    $thirdCssColor     = new CSS_Color( $cssColor3 );
    $BckgrndCssColor   = new CSS_Color( $cssColor4 );

    /* * * * * * * * * * * COLOR USAGE * * * * * * * * * * * * * *
     *
     * Use the base color, two shades darker
     * background:#<?= $base->bg['-2'] ?>;
     *
     * Use the corresponding foreground color
     * color:#<?= $base->fg['-2'] ?>;
     *
     * Use the highlight color as a border
     * border:5px solid #<?= $highlight->bg['0'] ?>
     */
?>

body
{
    margin: 0;
    padding: 0;
    color: #<?php echo $BckgrndCssColor->fg['+5'];?>;;
    font: normal 10pt Arial,Helvetica,sans-serif;
    background: #<?php echo $BckgrndCssColor->bg['0'];?>;
}

h1
{
    color:#<?php echo $primaryCssColor->bg['0'];?>;
    font-size:30px;
    text-shadow: 2px 2px #<?php echo $BckgrndCssColor->bg['0'];?>;
    text-align: left;
    float: left;
}
h2
{
    color:#<?php echo $secondaryCssColor->bg['0'];?>;
}
h3
{
    color:#<?php echo $BckgrndCssColor->bg['0'];?>;
}
h4
{
    color:#<?php echo $primaryCssColor->bg['0'];?>;
}
h5
{
    color:#<?php echo $secondaryCssColor->bg['0'];?>;
}
.floatRight
{
    text-align: right;
    float: right;

}

a
{
    color:#<?php echo $secondaryCssColor->bg['0'];?>;
}

a:hover
{
    color: #<?php echo $primaryCssColor->bg['-1'];?>;
    background-color: #<?php echo $primaryCssColor->bg['+5'];?>;
}

#page
{
	margin-top: 5px;
	margin-bottom: 5px;
	background: white;
	border: 1px solid #<?php echo $secondaryCssColor->bg['0'];?>;
}

#header
{
	margin: 0;
	padding: 0;
	border-top: 3px solid #<?php echo $primaryCssColor->bg['0'];?>;
}

#content
{
    padding: 20px;
}

#sidebar
{
	padding: 20px 20px 20px 0;
}

#footer
{
	padding: 10px;
	margin: 10px 20px;
	font-size: 0.8em;
	text-align: center;
	border-top: 1px solid #<?php echo $primaryCssColor->bg['0'];?>;
}

#headline
{
    padding: 30px 20px 0px 10px;
	font-size: 225%;
    color: #<?php echo $secondaryCssColor->bg['0'];?>;
    float: left;
}
#header
{
    display: block;
    height: 60px;
    padding : 10px;
}
#logo
{
    float: left;
    height: 75px;
    width: 169px;
    background:url('<?php echo $imagesFolder;?>br_logo_169x75_trans.png');
    padding: 0px;
    margin: -5px 0 0 0;
    z-index:2;
}

#mainmenu
{
/*	background:white url(bg.gif) repeat-x left top; */
	background:#<?php echo $primaryCssColor->bg['0'];?> url(clear_bg.png) repeat-x left top;
}

#mainmenu ul
{
	padding:6px 20px 5px 20px;
	margin:0px;
}

#mainmenu ul li
{
	display: inline;
}

#mainmenu ul li a
{
	color:#<?php echo $primaryCssColor->fg['0'];?>;
	background-color:transparent;
	font-size:12px;
	font-weight:bold;
	text-decoration:none;
	padding:7px 8px 5px;
}

#mainmenu ul li a:hover{
	color: #<?php echo $primaryCssColor->fg['+2'];?>;
	background:#<?php echo $primaryCssColor->bg['+2'];?> url(clear_bg.png) repeat-x left top;
	text-decoration:none;
}

#mainmenu ul li.active a
{
	color: #<?php echo $primaryCssColor->fg['-2'];?>;
	background:#<?php echo $rorange->bg['-2'];?> url(clear_bg.png) repeat-x left top;
	text-decoration:none;
}

div.flash-error, div.flash-notice, div.flash-success
{
	padding:.8em;
	margin-bottom:1em;
	border:2px solid #ddd;
}

div.flash-error
{
	background:#<?php echo $secondaryCssColor->bg['0'];?>;
	color:#<?php echo $secondaryCssColor->bg['0'];?>;
	border-color:#<?php echo $BckgrndCssColor->bg['0'];?>;
}

div.flash-notice
{
	background:#<?php echo $primaryCssColor->bg['0'];?>;
	color:#<?php echo $primaryCssColor->fg['0'];?>;
	border-color:#<?php echo $BckgrndCssColor->bg['0'];?>;
}

div.flash-success
{
	background:#<?php echo $primaryCssColor->bg['0'];?>;
	color:#<?php echo $primaryCssColor->fg['0'];?>;
	border-color:#<?php echo $BckgrndCssColor->bg['0'];?>;
}

div.flash-error a
{
	color:#<?php echo $secondaryCssColor->bg['0'];?>;
}

div.flash-notice a
{
	color:#<?php echo $primaryCssColor->bg['0'];?>;
}

div.flash-success a
{
	color:#<?php echo $primaryCssColor->bg['0'];?>;
}

div.form .rememberMe label
{
	display: inline;
}

div.view
{
	padding: 10px;
	margin: 10px 0;
	border: 1px solid #<?php echo $secondaryCssColor->bg['0'];?>;
}

div.breadcrumbs
{
	font-size: 0.9em;
	padding: 5px 20px;
}

div.breadcrumbs span
{
	font-weight: bold;
}

div.search-form
{
	padding: 10px;
	margin: 10px 0;
	background: #eee;
}

.portlet
{

}

.portlet-decoration
{
	padding: 3px 8px;
	background: #<?php echo $primaryCssColor->bg['+2'];?>;
	border-left: 5px solid #<?php echo $BckgrndCssColor->bg['+2'];?>;
}

.portlet-title
{
	font-size: 12px;
	font-weight: bold;
	padding: 0;
	margin: 0;
	color: #<?php echo $primaryCssColor->fg['+2'];?>;
}

.portlet-content
{
	font-size:0.9em;
	margin: 0 0 15px 0;
	padding: 5px 8px;
	background:#<?php echo $primaryCssColor->bg['+4'];?>;
}

.portlet-content ul
{
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
	margin: 0;
	padding: 0;
}

.portlet-content li
{
	padding: 2px 0 4px 0px;
}

.operations
{
	list-style-type: none;
	margin: 0;
	padding: 0;
}

.operations li
{
	padding-bottom: 2px;
}

.operations li a
{
	font: bold 12px Arial;
	color: #<?php echo $primaryCssColor->bg['0'];?>;
	display: block;
	padding: 2px 0 2px 8px;
	line-height: 15px;
	text-decoration: none;
}

.operations li a:visited
{
	color: #<?php echo $primaryCssColor->bg['-2'];?>;
}

.operations li a:hover
{
	background: #<?php echo $primaryCssColor->bg['5'];?>;
}

#controlPanelMenu li a
{
    line-height: 150%;
    font-size: 150%
}

/* Start Line Panel */
.startButton
{
    margin: 10px 20px;
    padding: 20px;
    width: 150px ;
    -moz-border-radius: 5px;
    border-radius: 5px;
}


#countdown
{
    line-height: 150px;
    position: absolute;
    top: 150px;
    left: 500px;
    width:450px;
    text-align: right
}
.up
{
    font-size:  50px;
    padding: 20px ;
    color: green
}
.ondeck
{
    font-size: 25px;
    padding: 20px
}
.inthehole
{
    font-size: 16px;
    padding: 20px
}
.nextup
{
    padding: 20px
}

.notStarted
{
    color: #<?php echo $BckgrndCssColor->bg['+4'];?>;
    font-weight: normal;
}

.stillOut
{
    color: #<?php echo $primaryCssColor->bg['0'];?>;
    font-weight: bold;
}
.finishedRiding
{
    color: #<?php echo $secondaryCssColor->fg['0'];?>;
    font-weight: bold;
    background: url(finishedRiderBg.png) center center no-repeat;
}

.riderStatus
{
    width: 25px;
    padding: 2px 10px;
    text-align: center;
}

#activeRiderList
{
    position:  relative;
    float: right;
}

#finishLineDetail
{
    width: 800px;
    height: 50px;
    overflow:scroll;
}

#stopButton
{   float: left;
    padding: 20px;
    width: 150px;
    height: 180px;
    background-color: #<?php echo $BckgrndCssColor->bg['+4'];?>;
    color: #<?php echo $secondaryCssColor->bg['0'];?>;
    border: #<?php echo $secondaryCssColor->bg['0'];?> solid 2px;
    font-size: 150%;
    font-weight: bold;
    cursor: pointer;-moz-border-radius: 15px;
    border-radius: 15px;
}

#finishLineDetail
{
    position: relative;
    right: 0px;
    min-width: 800px;
    height:  350px;
    border: #<?php echo $primaryCssColor->bg['0'];?> solid 2px;
    -moz-border-radius: 15px;
    border-radius: 15px;
}

#finishLineDetailHead
{
    margin: 0px 50px; 0px 0px;
    position: relative;
    right: 0px;
    min-width: 800px;
}

input[type='text']
{
    padding-left: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}
textarea
{
    -moz-border-radius: 5px;
    border-radius: 5px;
 /*   min-height: 50px; */
 -webkit-appearance: textfield;
padding: 1px;
background-color: white;
border: 2px inset;
border-image: initial;
-webkit-rtl-ordering: logical;
-webkit-user-select: text;
cursor: auto;
}

input:disabled, textarea:disabled
{
    box-shadow: inset 0 0 2px #<?php echo $BckgrndCssColor->bg['+5'];?>;
    color     : #<?php echo $BckgrndCssColor->bg['+3'];?>;
}
input:enabled, textarea:enabled
{
    box-shadow: inset 0 0 2px #<?php echo $BckgrndCssColor->bg['0'];?>;
}

input.stats
{
    background : white;
}

/* Override the JS CSS to not display this */
.ui-helper-hidden-accessible
{
    display : none;
    color   : white;
}
.ui-corner-all
{
    cursor : pointer;
    width  : 150px;
}
.registrationForm
{

}

div.registrationForm
{
    border : 1px #<?php echo $secondaryCssColor->bg['0']?> solid;
    -moz-border-radius: 5px;
    border-radius: 5px;
    width : 200px;
    min-height : 50px;
}

td, th, div
{
    padding : 5px 10px;
    margin: 5px 10px;
    vertical-align:top;
}

.hideMe
{
    display : none;
}

.loading_class
{
    background:url('/eman/images/biker.gif') no-repeat right center
}

#loading_data
{
    min-width : 85px;
    min-height : 100px;
}

#rightCol
{
    border-left : 2px #<?php echo $secondaryCssColor->bg['0']?> solid;
}

#rightCol td
{
    min-height : 50px;
}

#rightCol td input
{
    font-size : 200%;
    color : #<?php echo $secondaryCssColor->bg['0']?>;
    border : 0px white solid;
    box-shadow: inset 0 0 0px white;
    max-width : 175px;
}

.regFormTable tr, .regFormTable td
{
    height : 35px;
}

#notification
{
    font-weight:bold;
    font-size: 150%;
    text-align: center;
    position:absolute;
    height: 45px;
    line-height: 40px;
}

#notification.warning
{
    border-top : 6px solid #<?php echo $primaryCssColor->bg['0']; ?>;
    border-bottom : 6px solid #<?php echo $primaryCssColor->bg['0']; ?>;
    color: #<?php echo $primaryCssColor->bg['0']; ?>;
    background-color :#<?php echo $primaryCssColor->bg['+5']; ?>;
}
#notification.success
{
    border-top : 6px solid #<?php echo $BckgrndCssColor->bg['0']; ?>;
    border-bottom : 6px solid #<?php echo $BckgrndCssColor->bg['0']; ?>;
    color: #<?php echo $BckgrndCssColor->bg['0']; ?>;
    background-color :#<?php echo $BckgrndCssColor->bg['+5']; ?>;
}
#notification.error
{
    border-top : 6px solid #<?php echo $secondaryCssColor->bg['0']; ?>;
    border-bottom : 6px solid #<?php echo $secondaryCssColor->bg['0']; ?>;
    color: #<?php echo $secondaryCssColor->bg['0']; ?>;
    background-color :#<?php echo $secondaryCssColor->bg['+5']; ?>;
}

div.inline
{
    display: inline;
    padding: 0;
    margin: 0px 5px;
}
div.absolute
{
    position : absolute;
}

#pass
{
    float : left;
    width : 50px;
    text-align: center;
    height : 50px;
    font-size : 300%;
    background :url('<?php echo $imagesFolder?>ticket-op.jpg') no-repeat center center;
    text-shadow: -1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 1px #<?php echo $secondaryCssColor->bg['0']; ?>
            , 1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 -1px #<?php echo $secondaryCssColor->bg['0']; ?>
}#s_winner
{
    float : left;
    width : 50px;
    text-align: center;
    height : 50px;
    font-size : 300%;
    background :url('<?php echo $imagesFolder?>medal-br-op.jpg') no-repeat center center;
    text-shadow: -1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 1px #<?php echo $secondaryCssColor->bg['0']; ?>
            , 1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 -1px #<?php echo $secondaryCssColor->bg['0']; ?>
}
#h_winner
{
    float : left;
    display: inline;
    text-align: center;
    width : 50px;
    height : 50px;
    font-size : 300%;
    background :url('<?php echo $imagesFolder?>medal-rr-op.jpg') no-repeat center center;
    text-shadow: -1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 1px #<?php echo $secondaryCssColor->bg['0']; ?>
            , 1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 -1px #<?php echo $secondaryCssColor->bg['0']; ?>
}
#pr
{
    float : left;
    display: inline;
    width : 30px;
    height : 50px;
    font-size : 300%;
    background :url('<?php echo $imagesFolder?>trophy-op.jpg') no-repeat center center;
    text-shadow: -1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 1px #<?php echo $secondaryCssColor->bg['0']; ?>
            , 1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 -1px #<?php echo $secondaryCssColor->bg['0']; ?>
}#dd
{
    float : left;
    display: inline;
    width : 30px;
    height : 50px;
    font-size : 300%;
    background :url('<?php echo $imagesFolder?>dd-op.jpg') no-repeat center center;
    text-shadow: -1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 1px #<?php echo $secondaryCssColor->bg['0']; ?>
            , 1px 0 #<?php echo $secondaryCssColor->bg['0']; ?>
            , 0 -1px #<?php echo $secondaryCssColor->bg['0']; ?>
}
.tooltip {outline:none; }
.tooltip strong {line-height:30px;}
.tooltip:hover {text-decoration:none;}
.tooltip span
{
    z-index:10;
    display:none;
    padding:4px 10px;
    margin-top:60px;
    margin-left:-80px;
    width:100px;
    line-height:16px;
}
.tooltip:hover span
{
    display:inline;
    position:absolute;
    border:2px solid #<?php echo $secondaryCssColor->bg['0']; ?>;
    color:#<?php echo $BckgrndCssColor->bg['0']; ?>
    background:#<?php echo $secondaryCssColor->bg['0']; ?> url(src/css-tooltip-gradient-bg.png) repeat-x 0 0;
}
.callout
{
    z-index:20;
    position:absolute;
    border:0;
    top:-14px;
    left:120px;
}

/*CSS3 extras*/
.tooltip span
{
    border-radius:2px;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-box-shadow: 0px 0px 8px 4px #<?php echo $secondaryCssColor->bg['0']; ?>;
    -webkit-box-shadow: 0px 0px 8px 4px #<?php echo $secondaryCssColor->bg['0']; ?>;
    box-shadow: 0px 0px 8px 4px #<?php echo $secondaryCssColor->bg['0']; ?>;
    opacity: 0.8;
    text-align: center;
}
.tooltip2
{
    display: none;
    position: absolute;
    margin: 0;
    padding: 0;
    background-color: white;
}
div#rider_payment_div
{
    padding: 0;
    margin:0;
}

div.indent10
{
    padding: 10px 10px 0px 10px;
    clear: both;
    margin: 0px;
}

.clear
{
    clear: both;
}

.centered
{
    margin-left:auto;
    margin-right:auto;
}

.all
{
    width: 100%;
}

.finishLineInput
{
    width: 50px;
}
div.opaque
{
    opacity : 1;
}
.noPad
{
    padding: 0;
}

.noMarg
{
    margin: 0;
}

tr.even
{
    background-color:#<?php echo $BckgrndCssColor->bg['+5']; ?>
}

input[type="button"].status_ok
{
    background:green url(clear_bg.png) repeat-x left top;
}

input[type="button"].status_working
{
    background:yellow url(clear_bg.png) repeat-x left top;
}

input[type="button"].status_lazy
{
    background:#<?php echo $primaryCssColor->bg['0'];?> url(clear_bg.png) repeat-x left top;
}
input[type="button"].brown_button
{
    background:#<?php echo $primaryCssColor->bg['0'];?> url(clear_bg.png) repeat-x left top;
}
input[type="button"].gray_button
{
    background:#<?php echo $BckgrndCssColor->bg['+3'];?> url(clear_bg.png) repeat-x left top;
}

input[type="button"], #racerReset
{
    margin: 10px 20px;
    padding: 10px;
    width: 125px ;
    background : white;
    -moz-border-radius: 5px;
    border-radius: 5px;
    float : left;
}

input[type="button"]
{
    font-weight: bold;
}

#Timer{
    line-height : 150px;
    padding-left: 250px;
}

.rightTop{
    position: absolute;
    right: 20px;
    top: -100px;
}
