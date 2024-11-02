<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	// Probably add Markdown rendering
	// Will markdown alter the way it handles links

	$topic = filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT);
	// This seems to throw an error on $topic = 0, but hey I want string page identifiers
	if (!$topic) {
		echo "OH SHIT";
	}

	$sql = "SELECT * FROM pages WHERE id = $topic";
	$page_info = pdo($pdo, $sql)->fetch();

	if (!$page_info) {
		echo "OH FUCK";
	}
?>
<html>
<head>
	<title>Wiki</title>
</head>
<body>
	<div>
		<h1><?= $page_info['name'] ?></h1>
		<a href="edit_topic.php?topic=<?= $page_info['id'] ?>">Edit page</a>
		<?php
		$file = fopen($page_info['file'], "r") or die("OH BALLS");
		echo fread($file, filesize($page_info['file']));
		fclose($file);
		?>
	</div>
</body>
</html>