<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';

	/*
	The plan behind this is to move all the page creation into a single function that will be passed a $_POST array. This is to make the mess that is create_topic.php a tad tidier */

	function check_membership($value, $table, $parent_id=0) {
		/*
		This function is going to get the name of a category and a value that might be in it.
		*/
		$sql = "SELECT id FROM $table WHERE name = '$value'";
		$id = pdo($pdo, $sql, $values)->fetch()

		if (!$id) {
			// This runs if we have no ID
			if ($parent_id == 0) {
				// This is run if we are checking a category
				$sql = "INSERT INTO $table (name) VALUES ('$value')";
				
			} else {
				// This is run if we are checking a sub-category
				$sql = "INSERT INTO :table (name, parent_id) VALUES (:name, :parent_id)";
				$values['table'] = $table;
				$values['name'] = $value;
				$values['parent_id'] = $parent_id;
			}
			
			pdo($pdo, $sql);
			// We have added the category, so now we need to get it's ID
			// Is this the best way to do this?
			// Do we want to add parent_id back into this call in case it tries to add it again
			check_membership($value);
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

	function create_page($post) {
		// We don't need to insert ID, updated_at, or times_visited because they can all default.
		$page_sql = "INSERT INTO pages (abbreviation, title, description, category_id, sub_category_id, file_name, keywords) VALUES (:abbreviation, :title, :description, :category_id, :sub_category_id, :file_name, :keywords)";

		// Create the file name
		$file_name = $post['abbreviation'] . ".md";

		// Collate all the values into an array
		$values['abbreviation'] = $post['abbreviation'];				// Get the abbreviation
		$values['title'] = $post['title'];								// Get the title
		$values['description'] = $post['description'];					// Get the description

		// We need to convert categories to ID
		$category_id = check_membership($post['category']);
		$values['category_id'] = $category_id;

		// Converting sub-categories to ID
		$sub_category_id = check_membership($post['sub_category'], $category_id);
		$values['sub_category_id'] = $sub_category_id;						// Get the sub-category
		$values['file_name'] = $file_name;								// Create the file name
		$values['keywords'] = $post['keywords'];						// Get the keywords

		// Run the SQL
		pdo($pdo, $sql, $values);

		// Before running the file creation, we need to check for the existence of the directories

		// Save the tags, will need to save individual tags, and the match up of tags 
		// We can use explode(",", $string) to get individual tags

		// Making the path to the file
		$file_path = "/pages/" . $_POST['category'] . "/" . $_POST['sub_category'] . $file_name;

		// Writing the Markdown file
		$file = fopen($file_name, "w") or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file);
	}
?>