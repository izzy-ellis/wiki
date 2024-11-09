<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';
	
	// Probably add Markdown rendering
	// Will markdown alter the way it handles links

	$topic = filter_input(INPUT_GET, 'topic');
	// This seems to throw an error on $topic = 0, but hey I want string page identifiers
	if (!$topic) {
		echo "OH SHIT";
	}

	$sql = "SELECT pages.title, pages.abbreviation, pages.description, pages.file_name, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON pages.category_id = category.id JOIN sub_category ON pages.sub_category_id = sub_category.id WHERE pages.abbreviation = '$topic';";

	$page_info = pdo($pdo, $sql)->fetch();

	if (!$page_info) {
		echo "OH FUCK";
	}

	add_header($page_info['title'], [], ["md-block.js"]);
?>

	<div>
		<h1><?= $page_info['title'] ?></h1>
		<p><?= $page_info['description'] ?></p>
		<a href="edit_topic.php?topic=<?= $page_info['abbreviation']; ?>">Edit page</a>
		<!-- Testing suggests that this method of echoing Markdown is not vulnerable, but I should test it some more -->
		<p>
			<md-block untrusted src="pages/<?= $page_info['category'] ?>/<?= $page_info['sub_category'] ?>/<?= $page_info['file_name'] ?>"></md-block>
		</p>
	</div>
</body>
</html>