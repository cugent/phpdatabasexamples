<?php

$hostname = 'localhost';
$username = 'cody';
$pword = 'djfk99poi';

$dbname = 'glacierhull';

$conn = mysql_connect($localhost, $username, $pword);

if(!$conn) {
	die('Could not connect ' . mysql_error());
}

$db_selected = mysql_select_db($dbname, $conn);

if(!$db_selected){
	die("Can't use database: " . $dbname . mysql_error());
}


?>