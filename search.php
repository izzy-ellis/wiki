<?php
	declare(strict_types=1);
	require_once 'includes/database-connection.php';
	require_once 'includes/functions.php';
	include 'includes/header.php';
	include 'includes/more_functions.php';
	
	

	$search_term = filter_input(INPUT_GET, 'search');
	// This seems to throw an error on $topic = 0, but hey I want string page identifiers
	if (!$search_term) {
		add_header("Search");
		echo "<h1>No search term entered</h1><p>Click <a href='index.php'>here</a> to return home</p>";
		include 'includes/footer.php';
		exit;
	}

	add_header("Search: $search_term");

	$wildcard_search = "%" . $search_term . "%";

	// Collect the IDs of the pages we pull so we can avoid displaying duplicates

	// Check titles first
	$titles_sql = "SELECT pages.id, title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE title LIKE '$wildcard_search'";

	$title_results = pdo($pdo, $titles_sql)->fetchAll();

	// Check tags
	$tags_sql = "SELECT pages.id, pages.title, pages.abbreviation, pages.description, tags.name, category.name AS category, sub_category.name AS sub_category FROM `tags` JOIN tag_page_relation ON tag_page_relation.tag_id = tags.id JOIN pages ON tag_page_relation.page_id = pages.id JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE tags.name LIKE '$wildcard_search'";

	$tag_results = pdo($pdo, $tags_sql)->fetchAll();

	// Check descriptions
	$description_sql = "SELECT pages.id, title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE description LIKE '$wildcard_search'";

	$description_results = pdo($pdo, $description_sql)->fetchAll();

	// Check keywords
	$keywords_sql = "SELECT pages.id, title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE keywords LIKE '$wildcard_search'";

	$keywords_results = pdo($pdo, $keywords_sql)->fetchAll();

	display_search_results([$title_results, $tag_results, $description_results, $keywords_results]);
?>