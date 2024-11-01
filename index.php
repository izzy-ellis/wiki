<html>
<head>
	<title>Wiki</title>
<body>
	<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	$alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"
	for ($i = 0; $i < strlen($alphabet); $i++){
   		$sql = "SELECT name from pages WHERE name LIKE ($alphabet[$i]+'%') ORDER BY name DESC";
   		$titles = pdo($pdo, $sql)->fetch();
   		// This could make 26 calls to the database, is that the move?
	}

