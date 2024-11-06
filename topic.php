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

	$sql = "SELECT * FROM pages WHERE abbreviation = $topic";
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
		<h1><?= $page_info['title'] ?></h1>
		<p><?= $page_info['description'] ?></p>
		<a href="edit_topic.php?topic=<?= $page_info['id'] ?>">Edit page</a>
		<md-block untrusted src="/pages/<?= $page_info['category'] ?>/<?= $page_info['sub_category'] ?>/<?= $page_info['file_name'] ?>"></md-block>
	</div>
</body>
</html>