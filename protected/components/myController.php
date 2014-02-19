<?php

class myController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
            return array(
                    'accessControl', // perform access control for CRUD operations
            );
    }

    public function actionAjax()
    {
            $this->renderPartial( 'ajax/' . $_GET[ 'a' ] );
    }
    public function actionIframe()
    {
            $this->renderPartial( $_GET[ 'i' ] );
    }
}