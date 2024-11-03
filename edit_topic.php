<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	// Move the HTML to be there regardless of the POST?

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// pg 487
		$sql = "UPDATE pages SET name = :title WHERE id = :id";
		$update['id'] = $_POST['id']; // Will this need casting, who knows, not me, an uncertain fisherman
		$update['title'] = $_POST['title'];
		pdo($pdo, $sql, $update);

		$file = fopen($_POST['file'], 'w') or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file);
		?> <a href="topic.php?topic=<?= $_POST['id'] ?>">Return</a> <?php
	} else {
	$topic = filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT);
	$sql = "SELECT * FROM pages WHERE id = $topic";
	$page_info = pdo($pdo, $sql)->fetch();

	var_dump($_GET);
	var_dump($_POST);
?>
<html>
<head>
	<title>Wiki</title>
</head>
<body>
	<h1>Edit page</h1>
	<form action="edit_topic.php" method="POST">
		<!-- The full title of the page -->
		<!-- CSS tooltip on W3 -->
		<label for="title">Title:</label><br>
		<input type="text"  id="title" name="title" value="<?= $page_info['name'] ?>"><br>

		<!-- This is apparently an insecure way to pass ID --> 
		<input type="hidden" id="id" name="id" value="<?= $page_info['id'] ?>"><br>

		<!-- This is going to pass the filename over to the POST request -->
		<input type="hidden" id="file" name="file" value="<?= $page_info['file'] ?>"><br>

		<!-- Drop down menu for the categories -->
		<input list="category">
			<datalist id="category">
				<!-- Get the available categories and dump them here -->
			</datalist>

		<!-- Drop down menu for sub-categories -->
		<input list="sub_category">
			<datalist>
				<!-- Get the available sub-categories and slap them here -->
			</datalist>

		<!-- Big old text area for the text to go -->
		<label for="text">Text:</label><br>
		<textarea id=text name="text"><?php $file = fopen($page_info['file'], 'r') or die("OH BALLS");
		echo fread($file, filesize($page_info['file']));
		fclose($file); ?>
		</textarea><br>

		<!-- Submit button -->
		<input type="submit"><br>
	</form>
<?php } ?>
</body>
</html>


