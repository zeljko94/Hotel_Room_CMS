<?php

require_once('core/App.php');
require_once('core/Controller.php');
require_once('core/DB.php');


function dateToMySqlDate($date, $format=null)
{
	$date = explode('/', $date);
	$day = $date[0];
	$month = $date[1];
	$year = $date[2];

	return $year.'/'.$month.'/'.$day;
}
error_reporting(0);