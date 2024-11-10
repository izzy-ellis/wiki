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

	$sql = "UPDATE pages SET times_visited = times_visited + 1 WHERE abbreviation = '{$page_info['abbreviation']}'"
	pdo($pdo, $sql);

	add_header($page_info['title'], ["htmarkl.css"]);
?>

	<div class="column-three-quarters">
		<h1><?= $page_info['title'] ?></h1>
		<p><?= $page_info['description'] ?></p>
	</div>
	<div class="column-quarter">
		<a href="edit_topic.php?topic=<?= $page_info['abbreviation']; ?>">Edit page</a>
	</div>
	<div class="column-full content">
		<?php
		$file_path = "pages/" . $page_info['category'] . "/" . $page_info['sub_category'] . "/" . $page_info['file_name'];

		$file = fopen($file_path, "r") or die("OH BALLS");
		echo fread($file, filesize($file_path));
		fclose($file);

		?>
	</div>
</body>
</html>