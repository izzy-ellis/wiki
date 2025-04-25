<?php
// A bunch of functions in case we need them

function display_page($page) {
	// The page argument should have values for title, abbreviation, description, category, and sub_category
	?> 
	<div id="<?= $page['abbreviation'] ?>" style="border-style: solid; border-width: 2px; padding: 5px; margin-bottom: 2px;" class="column-half">
		<h3 style="display: inline"><a href="topic.php?topic=<?= $page['abbreviation'] ?>"><?= $page['title'] ?> (<?= $page['abbreviation'] ?>)</a></h3>
		<p style="display: inline"><code><?= $page['category'] . "/" . $page['sub_category'] ?></code></p>
		<p><?= $page['description'] ?></p>
	</div>
<?php }

function display_search_results($array_of_arrays) {
	// This is going to take a list of SQL results and go through them one by one
	// As well as the values needed for display_page(), it also needs page IDs

	$displayed_pages = [];
	?>  <?php 
	foreach ($array_of_arrays as $list_of_results) {
		foreach ($list_of_results as $result) {
			if (!in_array($result['id'], $displayed_pages)) {
				// If the page has not been displayed already
				?> <?php
				display_page($result);
				$displayed_pages[] = $result['id']; ?>  <?php
			}
		}
	}
}
?>