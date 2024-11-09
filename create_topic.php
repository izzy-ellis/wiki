<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';

	function add_tooltip($tooltiptext) {
		?>
		<div class="tooltip">(?)
			<span class="tooltiptext"><?= $tooltiptext ?></span>
		</div> <?php
	}


	function check_membership($value, $table, $parent_id=0) {
		/*
		This function is going to get the name of a category and a value that might be in it.
		*/
		global $pdo;
		$sql = "SELECT id FROM $table WHERE name = '$value'";
		$id = pdo($pdo, $sql)->fetch();

		if (!$id) {
			// This runs if we have no ID
			if ($parent_id == 0) {
				// This is run if we are checking a category
				$sql = "INSERT INTO $table (name) VALUES ('$value')";
				
			} else {
				// This is run if we are checking a sub-category
				$sql = "INSERT INTO $table (name, parent_id) VALUES ('$value', $parent_id)";
			}
			
			pdo($pdo, $sql);
			// We have added the category, so now we need to get it's ID
			// THERE IS A BETTER WAY
			return $pdo->lastInsertId();
		} else {
			// We have an ID so we can return it
			return $id['id'];
		}
	}

	function folder_exists($folder) {
		/* Checks if a folder exists and return canonicalised absolute pathname
		@param string $folder the path being checked
		@return mixed returns the canonicalized absolute pathname on success, otherwise FALSE
		*/
		// Get canonicalised absolute pathname
		$path = realpath($folder);

		// If it exists check if its a directory
		if ($path != false AND is_dir($path)) {
			// Return canonicalised absolute pathname
			return $path;
		}

		// Path/folder does not exist
		return false;
	}

	function check_tag($tag) {
		// We're going to check if a tag exists in the table
		global $pdo;
		$sql = "SELECT name FROM tags WHERE name = '$tag'";
		$tag = pdo($pdo, $sql)->fetch();

		if(!$tag) {
			return false;
		} else {
			return true;
		}
	}

	function create_page($post) {
		// We don't need to insert ID, updated_at, or times_visited because they can all default.
		global $pdo;

		$page_sql = "INSERT INTO pages (abbreviation, title, description, category_id, sub_category_id, file_name, keywords) VALUES (:abbreviation, :title, :description, :category_id, :sub_category_id, :file_name, :keywords)";

		// Create the file name
		$file_name = $post['abbreviation'] . ".md";

		// Collate all the values into an array
		$values['abbreviation'] = $post['abbreviation'];				// Get the abbreviation
		$values['title'] = $post['title'];								// Get the title
		$values['description'] = $post['description'];					// Get the description

		// We need to convert categories to ID
		$category_id = check_membership($post['category'], 'category');
		$values['category_id'] = $category_id;

		// Converting sub-categories to ID
		$sub_category_id = check_membership($post['sub_category'], 'sub_category', $category_id);
		$values['sub_category_id'] = $sub_category_id;						// Get the sub-category
		$values['file_name'] = $file_name;								// Create the file name
		$values['keywords'] = $post['keywords'];						// Get the keywords

		// Run the SQL
		pdo($pdo, $page_sql, $values);

		// Get the Id of the page we just made, need this for later
		$page_id = $pdo->lastInsertId();

		// Before running the file creation, we need to check for the existence of the directories
		if (!folder_exists(("pages/" . $post['category']))) {
			// This is such a counter intuitive if statement because it only runs if category DOES NOT exist
			echo "Made " . $post['category'] . " directory";
			mkdir(("pages/" . $post['category']), 0755);
		}

		if (!folder_exists(("pages/" . $post['category'] . $post['sub_category']))) {
			// This is such a counter intuitive if statement because it only runs if category DOES NOT exist
			echo "Made " . $post['sub_category'] . " directory";
			mkdir(("pages/" . $post['category'] . "/" . $post['sub_category']), 0755);
		}

		// Save the tags, will need to save individual tags, and the match up of tags 
		// We can use explode(",", $string) to get individual tags

		if (str_replace(" ", "", $post['tag_list']) != "") {
			// If we have some tags to work with
			// Check for null tags
			$list_of_tags = explode(",", $post['tag_list']);
			foreach($list_of_tags as $tag) {
				$tag_exists = check_tag($tag);
				if ($tag_exists) {
					// Increment the tag count by 1
					$update_sql = "UPDATE tags SET count = count + 1 WHERE name = '$tag'";
					pdo($pdo, $update_sql);

					// Add a record linking the tag and the project
					$relation_sql = "INSERT INTO tag_page_relation (page_id, tag_id) VALUES ($page_id, (SELECT id FROM tags WHERE name = '$tag'))";
					pdo($pdo, $relation_sql);
				} else {
					// Create an entry for the tag
					$insert_sql = "INSERT INTO tags (name) VALUES ('$tag')";
					pdo($pdo, $insert_sql);

					$last_tag_id = $pdo->lastInsertId();
					// Add a record linking the tag and the project
					$relation_sql = "INSERT INTO tag_page_relation (page_id, tag_id) VALUES ($page_id, $last_tag_id)";
					pdo($pdo, $relation_sql);
				}
			}
		}

		// Making the path to the file
		$file_path = "/pages/" . $_POST['category'] . "/" . $_POST['sub_category'] . $file_name;

		// Writing the Markdown file
		$file = fopen($file_name, "w") or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file);
	}



	add_header("Create page", ['tooltip.css']);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Can we move this whole section to a separate function, passing $_POST as an arg

		// This will need updating with the new form
		create_page($_POST);
		/*
		$sql = "INSERT INTO pages (abbreviation, title, description, category, sub_category, file_name, keywords) VALUES (:abbreviation, :title, :description, :category, :sub_category, :file_name, :keywords)";

		// Create the file name
		$file_name = $_POST['abbreviation'] . ".md";

		// Collate all the values into an array
		$values['abbreviation'] = $_POST['abbreviation'];				// Get the abbreviation
		$values['title'] = $_POST['title'];								// Get the title
		$values['description'] = $_POST['description'];					// Get the description
		$values['category'] = $_POST['category'];						// Get the category
		$values['sub_category'] = $_POST['sub_category'];				// Get the sub-category
		$values['file_name'] = $file_name;								// Create the file name
		$values['keywords'] = $_POST['keywords'];						// Get the keywords

		// Run the SQL
		pdo($pdo, $sql, $values);

		// Before running the file creation, we need to check for the existence of the directories

		// Save the tags, will need to save individual tags, and the match up of tags 

		// Making the path to the file
		$file_path = "/pages/" . $_POST['category'] . "/" . $_POST['sub_category'] . $file_name;

		// Writing the Markdown file
		$file = fopen($file_name, "w") or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file); */

		// We're moving to linking with abbreviations to make it more user friendly
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

			<!-- Tags -->
			<!-- Can we handle tags by just having a big old list of check boxes? It's not neat but it would beat learning JavaScript -->
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