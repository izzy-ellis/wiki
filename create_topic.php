<?php
	declare(strict_types=1);
	require_once 'includes/database-connection.php';
	require_once 'includes/functions.php';
	require "includes/page_creation.php";
	include 'includes/header.php';

	function add_tooltip($tooltiptext) {
		?>
		<div class="tooltip">(?)
			<span class="tooltiptext"><?= $tooltiptext ?></span>
		</div> <?php
	}

	add_header("Create page", ['tooltip.css']);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		create_page($_POST);
		
	?> <a href="topic.php?topic=<?= $_POST['abbreviation'] ?>">Return to new page</a> <?php
	} else {
		?>
		<h1>Create page</h1>
		<script type="text/javascript" src="js/form.js"></script>
		<script type="text/javascript" src="js/autocomplete.js"></script>
		<form name="create_page" action="create_topic.php" method="POST" onsubmit="return validateForm(['title', 'abbreviation', 'category', 'sub-category'])" autocomplete="off">
			<!-- The full title of the page -->
			<!-- CSS tooltip on W3 -->
			<label for="title">
				Title: <?= add_tooltip("This is the title of the page") ?>
			</label><br>
			<input type="text"  id="title" name="title"><br>

			<!-- Abbreviation -->
			<label for="abbreviation">
				Abbreviation: <?= add_tooltip("A short form name (no spaces)") ?>
			</label><br>
			<input type="text" id="abbreviation" name="abbreviation"><br>

			<label for="description">
				Description: <?= add_tooltip("A description of the page") ?>
			</label><br>
			<input type="text" id="description" name="description"><br>

			<!-- Drop down menu for the categories -->
			<!-- These datalists work on the basis that additions can be made
				 and if empty, will still function -->
			<label for="category">
				Category: <?= add_tooltip("The category of the page") ?>
			</label><br>
			<input list="category" name="category" id="category">
				<datalist id="category">
					<!-- Get the available categories and dump them here -->
					<?php 
					$sql = "SELECT DISTINCT name FROM category";	// Get the distinct categories
					$categories = pdo($pdo, $sql)->fetchAll();
					foreach($categories as $category) {
						?>
						<!-- We need to use <option></option> in order to be able to use the "selected" property -->
						<option value="<?= $category['name'] ?>"><?= $category['name'] ?></option> <?php 
					}
					?>
				</datalist><br>

			<!-- Drop down menu for sub-categories -->
			<!-- Ideally we want this to dynamically update when the category is selected but that requires more JavaScript and willpower than I have right now -->
			<label for="sub_category">
				Sub-category: <?= add_tooltip("The sub-category of the page") ?>
			</label><br>
			<input list="sub_category" name="sub_category" id="sub_category">
				<datalist id="sub_category">
					<!-- Get the available sub-categories and slap them here -->
					<?php 
					$sql = "SELECT sub_category.name AS sub_category_name, category.name AS category_name FROM sub_category JOIN category on category.id = sub_category.parent_id"; // This should get a distinct list of sub-categories
					$sub_categories = pdo($pdo, $sql)->fetchAll();
					echo var_dump($sub_categories);
					foreach($sub_categories as $sub_category) {
						// This is by no means optimal, but it will do the job for now
						?> 
						<option value="/<?= $sub_category['category_name'] ?>/<?= $sub_category['sub_category_name'] ?>">
							<?= $sub_category['category_name'] . "/" . $sub_category['sub_category_name'] ?>
						</option> <?php
					}
					?> 
				</datalist><br>

			
			<label for="tags">
				Tags: <?= add_tooltip("Tags to help with categorising pages") ?>
			</label><br>
			<?php
				// We need to get the array for the contents of the search box
				$sql = "SELECT name FROM tags";
				$tags = pdo($pdo, $sql)->fetchAll();
				$plain_tags = [];
				foreach ($tags as $tag) {
					$plain_tags[] = $tag['name'];
				}
			?>
			
			<div class="autocomplete">
				<input id="tag_box" type="text" name="tag_box">
			</div>
			<button type="button" onclick="add_tag()">Add tag</button><br>
			<textarea id="tag_list" name="tag_list"></textarea><br>
			<script>
				autocomplete(document.getElementById("tag_box"), <?= json_encode($plain_tags) ?>);
			</script>
			<!-- Keywords -->
			<!-- Here we just want a bunch of comma-separated words to aid with searching -->
			<label for="keywords">
				Keywords: <?= add_tooltip("A list of comma separated keywords") ?>
			</label><br>
			<input type="text" id="keywords" name="keywords"><br>

			<!-- Big old text area for the text to go -->
			<label for="text">
				Text: <?= add_tooltip("The main body of Markdown for the page") ?>
			</label><br>
			<textarea id=text name="text"></textarea><br>

			<!-- Submit button -->
			<input type="submit">

		</form> <?php
	} ?>