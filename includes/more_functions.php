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

?>