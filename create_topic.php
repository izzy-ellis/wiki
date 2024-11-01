<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	?>

	<html>
	<head>
		<title>Wiki</title>
	</head>
	<body> 

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	} else {
		?>
		<h1>Create page</h1>
		<form action="create_topic.php" method="POST">
			<label for="title">Title:</label><br>
			<input type="text" id="title" name="title" value="Enter title..."><br>
			<label for="text">Text:</label><br>
			<textarea id="text" name="text">Enter text here...</textarea><br>
			<input type="submit">
		</form> <?php
	} ?>