<?php
// A bunch of functions in case we need them

function display_page($page) {
	// The page argument should have values for title, abbreviation, description, category, and sub_category
	$path = $page['category'] . "/" . $page['sub_category'];
				?> <a class="non-link" href="topic.php?topic=<?= $page['abbreviation'] ?>">
				<div class="bordered textbox">
					<h2 class="non-link"><?= $page['title'] ?></h2>
					<p class="small grey non-link"><?= $path ?></p>
					<p class="non-link"><?= $page['description'] ?></p>
				</div>
				</a>
<?php }

function display_search_results($array_of_arrays) {
	// This is going to take a list of SQL results and go through them one by one
	// As well as the values needed for display_page(), it also needs page IDs

	$displayed_pages = [];

	foreach ($array_of_arrays as $list_of_results) {
		foreach ($list_of_results as $result) {
			if (!in_array($result['id'], $displayed_pages)) {
				// If the page has not been displayed already
				display_page($result);
				$displayed_pages[] = $result['id'];
			}
		}
	}
}
?>