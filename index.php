<?php
error_reporting( -1 );
ini_set( 'display_errors', 1 );
ini_set("log_errors", 1);

// Output errors to log file
ini_set("error_log", dirname(__FILE__) . "/php.log");


require_once "WikiBlender/WikiBlender.php";
WikiBlender::execute();