<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$autoload = dirname(__FILE__).'/vendor/autoload.php';
// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
require_once($autoload);

Yii::createWebApplication($config)->run();
