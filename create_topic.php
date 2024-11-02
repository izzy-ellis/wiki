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
		$sql = "INSERT INTO pages (name, file) VALUES (:title, :file)";
		$insert['title'] = $_POST['title'];
		$filename = $_POST['title'] . ".txt";
		$insert['file'] = $filename;
		pdo($pdo, $sql, $insert);

		$file = fopen($filename, 'w');
		fwrite($file, $_POST['text']);
		fclose($file);
		// Can we get the ID of the entry we just created and link to that?
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