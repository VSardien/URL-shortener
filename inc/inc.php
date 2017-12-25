<?php
require_once __DIR__.'/../vendor/autoload.php';
session_start();
$config = include('./config.php');
require_once __DIR__.'/database.php';
require_once __DIR__.'/cache.php';

