<?php
$GLOBALS['db'] = new Zebra_Database();

$GLOBALS['db']->connect($config->databaseHost, $config->databaseUser, $config->databasePassword, $config->databaseName);

$db->debug = false;

$GLOBALS['db']->set_charset ( 'utf8' ,  'utf8_general_ci');