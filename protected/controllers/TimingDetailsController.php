<?php

class TimingDetailsController extends myController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='/layouts/column1';
    public $event_id = null;

/**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionPreRaceCheck()
    {
        $model=TimingDetails::model()->findAll('event_id=:e'
                , array(':e'=>$_GET['event_id']));
        $this->render('preRaceCheck',array(
            'model'=>$model,
        ));
    }

    public function actionGetResults()
    {
        $args = array();
        if ( !isset( $_REQUEST[ 'riderRaceNumber' ] ) || $_REQUEST[ 'riderRaceNumber' ] == null  )
        {
            $model=new TimingDetails('search');
            $model->unsetAttributes();  // clear any default values
        }
        else
        {
            $model = TimingDetails::model()->with('rider')->find( 'rider_number=:r'
                    , array( ':r'=>$_REQUEST[ 'riderRaceNumber' ] ) );
        }
        if(isset($_REQUEST['riderRaceNumber'] ))
        {
            $eventId = ( isset( $_REQUEST['event_id'] ) )
                    ?  $_REQUEST['event_id']
                    :  $_REQUEST['id'] ;
            $myEvent = TimingEvents::model()->findByPk( $eventId );
            if( isset( $_REQUEST[ 'riderFirstName' ] )
                    && isset( $_REQUEST[ 'riderLastName' ] ) )
            {
                $processed = $this->processRider( $myEvent );
                die( "died here " . $processed);
            }
            //$eventDate = $myEvent->eventDate;
            $args[ 'startTime' ] = brUtils::getTimeInSeconds( $myEvent->startTime ) ;
            $args[ 'startNumber' ] = TimingAttributes::getTimingAttributeValue(
                    'TimingEvents', $args[ 'eventId' ], 'first_number');
          //  $eventInterval = TimingAttributes::getTimingAttributeValue(
          //          'TimingEvents', $args[ 'eventId' ], 'start_differential');
           // list( $h, $m, $s) = explode(':', $eventInterval );
           // $args[ 'interval' ] = $h * 3600 + $m * 60 + $s;
            $args[ 'interval' ] = brUtils::convertSecondsToTime(
                TimingAttributes::getTimingAttributeValue(
                          'TimingEvents'
                        , $myEvent->id
                        , 'start_differential'
                        )
                    );

            $model->attributes=$_GET['TimingDetails'];
        }

        $this->renderPartial( 'getResults'
                , array(
                      'model'=>$model
                    , 'args'=> $args
                )
                , false, true);
    }

    public function actionSaveTime()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->renderPartial( 'saveTime', array( 'model'=>$model));
    }

    public function actionEditTime()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->renderPartial( 'editTime', array( 'model'=>$model));
    }

    public function actionFinishLineDetail()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->renderPartial( 'finishLineDetail', array( 'model'=>$model));
    }
    public function actionRidersLeft()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->renderPartial( 'ridersLeft', array( 'model'=>$model));
    }
    public function actionActiveRiderList()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->renderPartial( 'activeRiderList', array( 'model'=>$model));
    }

    public function actionFinishLinePanel()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        $model->event_id = $_REQUEST[ 'event_id' ];
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->render( 'finishLinePanel', array( 'model'=>$model));
    }
    public function actionFinishLinePanel3()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        $model->event_id = $_REQUEST[ 'event_id' ];
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];
        $this->render( 'finishLinePanel3', array( 'model'=>$model));
    }

    public function actionRegistrationPanel( )
    {
        $args = array();
        //$model=new TimingDetails('search');
        $model = new TimingDetails();
        $model->event_id = CHttpRequest::getParam( 'event_id' );
        if ( CHttpRequest::getParam( 'riderRaceNumber' ) !== null  )
        {
            $model->rider_id = CHttpRequest::getParam( 'riderId' );
            $model->rider_category = CHttpRequest::getParam( 'riderId' );
            $model->rider_class = CHttpRequest::getParam( 'riderId' );
            $model->rider_num = CHttpRequest::getParam( 'riderRaceNumber' );
        }

        $myEvent = TimingEvents::model()->findByPk( CHttpRequest::getParam( 'event_id' ) );
        foreach( $_REQUEST as $key => $value )
        {
            if ( stripos( $key, 'rider_' ) == 0 )
            {
                $model->addStringToAttrMap( str_replace('rider_', '', $key ), $value, '_' );
            }
        }


        $args[ 'startTime' ] = brUtils::getTimeInSeconds( isset( $myEvent->startTime)
                ?$myEvent->startTime
                :'19:00:00') ;
        $args[ 'startNumber' ] = isset( $myEvent->attrMap[ 'first_number'] )
                ? $myEvent->attrMap[ 'first_number']
         //       TimingAttributes::getTimingAttributeValue(
         //       'TimingEvents', $_REQUEST[ 'event_id' ], 'first_number')
               : 1;
        $args[ 'interval' ] = brUtils::getTimeInSeconds(
               isset( $myEvent->attrMap[ 'start_differential' ] )
               ? $myEvent->attrMap[ 'start_defferential' ]
               : '00:00:30' );
        if(isset($_REQUEST['riderRaceNumber'] ))
        {
            if( isset( $_REQUEST[ 'riderFirstName' ] )
                    && isset( $_REQUEST[ 'riderLastName' ] ) )
            {
                $processed = $this->processRider( $model, $args );
                $model->unsetAttributes();  // clear any default values
                $model->rider = null;
            }
        }
        $this->render( 'registrationPanel'
                , array(
                      'model'=>$model
                    , 'args'=> $args
                )
                , false );

            }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionControlPanel()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];

        $this->render('controlPanel',array(
            'model'=>$model,
        ));
    }

    public function actionStartLinePanel()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        $model->event_id = $_REQUEST[ 'event_id' ] ;
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];

        $this->render('startLinePanel',array(
            'model'=>$model,
        ));
    }

    public function actionStartLinePanel3()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        $model->event_id = $_REQUEST[ 'event_id' ] ;
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];

        $this->render('startLinePanel3',array(
            'model'=>$model,
        ));
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionResultPanel()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
            $model->attributes=$_GET['TimingDetails'];

        $this->render('resultPanel',array(
                'model'=>$model,
        ));
    }

/**
 *                                Yii Generated below this line
 */
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new TimingDetails;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TimingDetails']))
        {
            $model->attributes=$_POST['TimingDetails'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TimingDetails']))
        {
            $model->attributes=$_POST['TimingDetails'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('TimingDetails');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new TimingDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimingDetails']))
                $model->attributes=$_GET['TimingDetails'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=TimingDetails::model()->with('rider')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='timing-details-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function processRider( $model, $args )
    {
        if ( !isset( $model->rider_id ) || $model->rider_id == null  )
        {
            $rider = new TimingRider();
            $rider->owner_id = Yii::app()->user->owner_id;
        }
        else
        {
            $rider = TimingRider::model()->findByPk( $model->rider_id );
        }
        // Just in case edits were done to the rider's name or this is a new rider
        $rider->first_name = isset( $_REQUEST['riderFirstName'] )
                ? $_REQUEST['riderFirstName']
                : '' ;
        $rider->last_name = isset( $_REQUEST['riderLastName']  )
                ? $_REQUEST['riderLastName']
                : '';
        $rider->attrMap[ 'defaultClass'] = isset( $_REQUEST['rider_defaultClass']  )
                ? $_REQUEST['rider_defaultClass']
                : '';
        $rider->attrMap[ 'defaultCategory'] = isset( $_REQUEST['rider_defaultCategory']  )
                ? $_REQUEST['rider_defaultCategory']
                : '';
        $rider->attrMap[ 'gender'] = isset( $_REQUEST['rider_gender']  )
                ? $_REQUEST['rider_gender']
                : '';
        $ed = TimingDetails::model()->findAll( 'rider_id=:r and event_id=:e'
                , array( ':r'=>$rider->id, ':e'=>$model->event_id ) );
        if( isset( $rider->attrMap[ 'credit' ])
                && $rider->attrMap[ 'credit' ]> 0
                && count( $ed ) < 1 )
        {
            $rider->adjustCredit( -1 );
        }
        // Check to see if they have ridden this ride yet, if so, it is a Double Down
        else if ( isset( $rider->attrMap[ 'dd_credit' ])
                && $rider->attrMap[ 'dd_credit' ]> 0
                && count( $ed ) >= 1 )
        {
            $rider->adjustDdCredit( -1 );
        }
        $rider->save();

        /**
         *   Make sure Rider Attributes are saved
         */
        foreach ( $args as $elementTag=>$elementValue )
        {
            $prefix = 'rider_';
            if ( stristr( $elementTag, $prefix ) )
            {
    //            $rider->saveAttributesFromString( $elementTag, $elementValue, $prefix, '_' );
            }
        }

        /**
         *  Save the Rider Details
         */
        $riderDetails = new TimingDetails();
        $riderDetails->rider_id = $rider->id;
        $riderDetails->event_id = $model->event_id;
        $riderDetails->rider_category = $_REQUEST[ 'rider_defaultCategory' ];
        $riderDetails->rider_class = $_REQUEST[ 'rider_defaultClass' ];
        $riderDetails->rider_num = $_REQUEST[ 'riderRaceNumber' ];
        $riderDetails->save();
    }
}