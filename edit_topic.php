<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo "You submitted the following details";
		$name = $_POST['title'];
		echo $name;
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
		<label for="title">Title:</label><br>
		<input type="text"  id="title" name="title" value="<?= $page_info['name'] ?>"><br>
		<label for="id">ID:</label><br>
		<input type="text" id="id" name="id" value="<?= $page_info['id'] ?>"><br>
		<label for="text">Text:</label><br>
		<textarea id=text name="text"><?php $file = fopen($page_info['file'], 'r') or die("OH BALLS");
		echo fread($file, filesize($page_info['file']));
		fclose($file); ?>
		</textarea><br>
		<input type="submit"><br>
	</form>
<?php } ?>
</body>
</html>


