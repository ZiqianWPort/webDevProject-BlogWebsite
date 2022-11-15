<?php
	// Content of database.php
	// require this file in other files to access the database

	$mysqli = new mysqli('localhost', 'm3group', 'm3group', 'm3groupwebsite');

	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}

?>