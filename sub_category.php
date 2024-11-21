<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';
	include 'includes/more_functions.php';

	$sub_category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
	if (!$sub_category_id) {
		// This behaves strangely on $id = 0
		echo "OH SHIT";
	}

	$sql = "SELECT pages.title, pages.abbreviation, pages.description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON pages.category_id = category.id JOIN sub_category ON pages.sub_category_id = sub_category.id WHERE pages.sub_category_id = $sub_category_id;";

	$topics = pdo($pdo, $sql)->fetchAll();

	add_header(("Sub-category: " . $topics[0]['sub_category']));

?>
	<div class="column-full">
		<h1>Sub-category: <?= $topics[0]['sub_category'] ?></h1>
		<ul>
		<?php
		foreach ($topics as $topic) {
			?> <li> <?= display_page($topic); ?> </li> <?php
		} ?>
	</div>