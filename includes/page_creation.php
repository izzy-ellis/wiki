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
			$update_sql = "UPDATE $table SET child_count = $child_count + 1 WHERE name = '$value'";
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
			echo "Made " . $post['category'] . " directory";
			mkdir(("pages/" . $post['category']), 0755);
		}

		if (!folder_exists(("pages/" . $post['category'] . "/" . $post['sub_category']))) {
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
				// Skip adding the tag if it is null
				if (str_replace(" ", "", $tag)) { continue; }
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
		$file_path = "pages/" . $post['category'] . "/" . $post['sub_category'] . "/" . $file_name;

		// Writing the Markdown file
		$file = fopen($file_path, "w") or die("OH BALLS");
		fwrite($file, $post['text']);
		fclose($file);
	}
?>