<?php
	declare(strict_types=1);
	require_once 'includes/database-connection.php';
	require_once 'includes/functions.php';
	/*
	The plan behind this is to move all the page creation into a single function that will be passed a $_POST array. This is to make the mess that is create_topic.php a tad tidier */

	function check_membership($value, $table, $parent_id=0) {
		/*
		This function is going to get the name of a category and a value that might be in it.
		*/
		global $pdo;
		if ($parent_id != 0) {
			// Working with a sub category
			$sql = "SELECT id FROM $table WHERE name = '$value' AND parent_id = $parent_id";
			$id = pdo($pdo, $sql)->fetch();
		} else {
			$sql = "SELECT id FROM $table WHERE name = '$value'";
			$id = pdo($pdo, $sql)->fetch();
		}
		

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
			if ($parent_id != 0) {
				// Working with a sub category
				$update_sql = "UPDATE $table SET child_count = child_count + 1 WHERE name = '$value' AND parent_id = $parent_id";
				pdo($pdo, $update_sql);
			} else {
				$update_sql = "UPDATE $table SET child_count = child_count + 1 WHERE name = '$value'";
				pdo($pdo, $update_sql);
			}
			
			
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

	function create_page($post) {
		// We don't need to insert ID, updated_at, or times_visited because they can all default.
		global $pdo;

		$page_sql = "INSERT INTO pages (abbreviation, title, description, category_id, sub_category_id, file_name, keywords) VALUES (:abbreviation, :title, :description, :category_id, :sub_category_id, :file_name, :keywords)";

		// Create the file name
		$file_name = $post['abbreviation'] . ".html";

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
			mkdir(("pages/" . $post['category']), 0755);
		}

		if (!folder_exists(("pages/" . $post['category'] . "/" . $post['sub_category']))) {
			// This is such a counter intuitive if statement because it only runs if category DOES NOT exist
			mkdir(("pages/" . $post['category'] . "/" . $post['sub_category']), 0755);
		}

		// Making the path to the file
		$file_path = "pages/" . $post['category'] . "/" . $post['sub_category'] . "/" . $file_name;

		// Writing the Markdown file
		$file = fopen($file_path, "w") or die("OH BALLS");
		fwrite($file, $post['text']);
		fclose($file);
	}
?>