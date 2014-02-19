<?php
    header("Content-type: text/css; charset: UTF-8");

    include_once("csscolor.php");
    $primaryCssColor        = new CSS_Color( "C07730" );
    $secondaryCssColor           = new CSS_Color( "98272B" );
    $thirdCssColor        = new CSS_Color( "ebebaa" );
    $BckgrndCssColor          = new CSS_Color( "333333" );

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
table.detail-view .null
{
	color: <?php echo $primaryCssColor->bg['+4'];?>;
}

table.detail-view
{
	background: white;
	border-collapse: collapse;
	width: 100%;
	margin: 0;
}

table.detail-view th, table.detail-view td
{
	font-size: 0.9em;
	border: 1px white solid;
	padding: 0.3em 0.6em;
	vertical-align: top;
}

table.detail-view th
{
	text-align: right;
	width: 160px;
}

table.detail-view tr.odd
{
	background:#<?php echo $primaryCssColor->bg['+4'];?>;
}

table.detail-view tr.even
{
	background:#<?php echo $primaryCssColor->bg['+5'];?>;
}

table.detail-view tr.odd th
{
}

table.detail-view tr.even th
{
}
