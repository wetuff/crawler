<?php

	define('DB_SERVER', '107.180.51.22');
	define('DB_USERNAME', 'crawler');    // DB username
	define('DB_PASSWORD', 'checkin@2018');    // DB password
	define('DB_DATABASE', 'crawler');      // DB name
	$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
	$database = mysqli_select_db($connection, DB_DATABASE);

	mysqli_query($connection, "SET NAMES 'utf8'");
	mysqli_query($connection, 'SET character_set_connection=utf8');
	mysqli_query($connection, 'SET character_set_client=utf8');
	mysqli_query($connection, 'SET character_set_results=utf8');

?>