<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once('../yii/framework/yii.php');
$configFile='protected/config/main.php';

Yii::createWebApplication($configFile)->run();