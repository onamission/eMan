<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			// uncomment the following to provide test database connection
		'db'=>array(
			'connectionString' => 'mysql:host=bigringsoftware.com;dbname=bigrings_timing',
			'emulatePrepare' => true,
			'username' => 'bigrings',
			'password' => 'hope4@ll',
			'charset' => 'utf8',
		),			),
			
	)
);
