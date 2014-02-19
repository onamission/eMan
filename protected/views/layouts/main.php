<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en
<?php
    Yii::app()->db;
    if ( !Yii::app()->user->isGuest )
    {
        $thisUser=  TimingRider::model()->with('owner')->findByPk( Yii::app()->user->id );
    }

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css.php?v=1" />
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/f9861b16/jquery_1.8.2.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/f9861b16/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">

	<div id="header">
            <a href="<?php echo Yii::app()->request->baseUrl;?>" ><div id="logo"></div></a>
            <span id="headline"><?php echo CHtml::encode(Yii::app()->name); ?></span>
	</div><!-- header -->

	<div id="mainmenu">
		<?php
        $eventidQuery = ( isset( $_REQUEST['event_id' ] ) )? "?event_id=". $_REQUEST['event_id' ]: '';
        if ( isset( $_REQUEST['id' ] ) )$eventidQuery = "?event_id=". $_REQUEST['id' ];
        $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Event Control Panel', 'url'=>array("/timingDetails/controlPanel$eventidQuery"), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Event Results', 'url'=>array("/timingEvents/eventResults") ),
                array('label'=>'Rider Profiles', 'url'=>array("/timingRider/riderProfile") ),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Admin', 'url'=>array('/site/page?view=eventAdmin'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
	</div><!-- mainmenu -->
	<?php /* if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif  */?>
    <?php
    $this->pageTitle=Yii::app()->name; ?>


    <?php if ( ( Yii::app()->user->isGuest && $this->getAction()->getId() != 'login' && $this->getAction()->getId() != 'resultPanel' && $this->getAction()->getId() != 'seriesRank')  )
    {?>
        <div class="indent10">
            <h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
        </div>
        <div class="indent10">
            Please <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/login" >login</a> to use the system
        </div>
    <?php
    }
    elseif ( ( Yii::app()->user->isGuest && ( $this->getAction()->getId() == 'resultPanel' ||  $this->getAction()->getId() == 'seriesRank') ) )
    {
    	// do nothing
    }
    elseif ( !Yii::app()->user->isGuest )
    {
        $event = false;
        if( isset( $_REQUEST[ 'event_id' ] ) )
        {
            $event = TimingEvents::model()->findByPk( $_REQUEST[ 'event_id' ] );
        }

        $eventName = $event ? $event->name : '';
    ?>
       <div class='indent10'>
           <h1><?php echo Yii::app()->user->ownerName ?></h1>
           <h1 class='floatRight' ><?php echo $eventName ?></h1>
       </div>
        <?php if( $this->getAction()->getId() != 'index' ) { ?>
        <div class='indent10'>
            <h2>
                <?php echo brUtils::explodeCamelCase( $this->getAction()->getId() ) ?>
            </h2>
        </div>
        <?php }
     }
     else
     {
         ?>
        <div class="indent10"><h1>Login</h1></div>
        <div class="indent10"><p>Please fill out the following form with your login credentials:</p></div>
<?php
     }
    ?>


	<?php echo $content;

 //       $p = print_r( $thisUser, true );
 //   echo "1 2 3 <pre>$p</pre>";

    ?>

    <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <a href="bigringsoftware.com" target="">BigRing Software</a>.<br/>
		All Rights Reserved.<br/>

	</div><!-- footer -->

</div><!-- page -->

</body>
</html>