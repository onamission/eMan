<?php
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Event Man CLI',
    'preload'=>array('log'),
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.utils.brUtils',
    ),
        // application components
        'components'=>array(
            'user'=>array(
                'class' => 'consoleUser',
            ),
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=bigrings_timing',
                'emulatePrepare' => true,
                'username' => 'bigrings_user2',
                'password' => 'hope4@ll',
                'charset' => 'utf8',
                'class'            => 'CDbConnection',
            ),
            'dbDemo'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=bigrings_timing_demo',
                'emulatePrepare' => true,
                'username' => 'bigrings_user2',
                'password' => 'hope4@ll',
                'charset' => 'utf8',
                'class'            => 'CDbConnection',
            ),
            'dbTest'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=bigrings_timing_test',
                'emulatePrepare' => true,
                'username' => 'bigrings_user2',
                'password' => 'hope4@ll',
                'charset' => 'utf8',
                'class'            => 'CDbConnection',
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                            'class'=>'CFileLogRoute',
                            'logFile'=>'cron.log',
                            'levels'=>'error, warning',
                    ),
                    array(
                            'class'=>'CFileLogRoute',
                            'logFile'=>'cron_trace.log',
                            'levels'=>'trace',
                    ),
                ),
            ),
            'functions'=>array(
                    'class'=>'application.extensions.functions.Functions',
            ),
    ),
);
