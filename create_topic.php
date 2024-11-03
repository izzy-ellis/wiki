<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

	?>

	<html>
	<head>
		<title>Wiki</title>
	</head>
	<body> 

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// This will need updating with the new form
		$sql = "INSERT INTO pages (abbreviation, title, description, category, sub_category, file_name, keywords) VALUES (:abbreviation, :title, :description, :category, :sub_category, :file_name, :keywords)"

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

		// Making the path to the file
		$file_path = "/pages/" . $_POST['category'] . "/" . $_POST['sub_category'] . $file_name;

		// Writing the Markdown file
		$file = fopen($file_name, "w") or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file);
		// We're moving to linking with abbreviations to make it more user friendly
	?> <a href="topic.php?topic=<?= $_POST['abbreviation'] ?>">Return to new page</a> <?php
	} else {
		?>
		<h1>Create page</h1>
		<form action="create_topic.php" method="POST">
			<!-- The full title of the page -->
			<!-- CSS tooltip on W3 -->
			<label for="title">Title:</label><br>
			<input type="text"  id="title" name="title"><br>

			<!-- Abbreviation -->
			<label for="abbreviation">Abbreviation:</label><br>
			<input type="text" id="abbreviation" name="abbreviation"><br>

			<!-- Drop down menu for the categories -->
			<!-- These datalists work on the basis that additions can be made
				 and if empty, will still function -->
			<input list="category">
				<datalist id="category">
					<!-- Get the available categories and dump them here -->
					<?php 
					$sql = "SELECT DISTINCT category FROM pages";	// Get the distinct categories
					$categories = pdo($pdo, $sql)->fetchAll();
					foreach($categories as $category) {
						?>
						<!-- We need to use <option></option> in order to be able to use the "selected" property -->
						<option value="<?= $category ?>">
							<?= $category ?>
						</option> <?php 
					}
					?>
				</datalist>

			<!-- Drop down menu for sub-categories -->
			<!-- Ideally we want this to dynamically update when the category is selected but that requires more JavaScript and willpower than I have right now -->
			<input list="sub_category">
				<datalist>
					<!-- Get the available sub-categories and slap them here -->
					<?php 
					$sql = "SELECT DISTINCT category, sub_category FROM pages"; // This should get a distinct list of sub-categories
					$sub_categories = pdo($pdo, $sql)->fetchAll();
					foreach($csub_categories as $sub_category) {
						// This is by no means optimal, but it will do the job for now
						?>
						<option value="/<?= $sub_category['category'] ?>/<?= $sub_category['sub_category'] ?>">
							<?= echo $sub_category['category'] . "/" . $sub_category['sub_category'] ?>
						</option> <?php
					}
					?> 
				</datalist>

			<!-- Tags -->
			<!-- Can we handle tags by just having a big old list of check boxes? It's not neat but it would beat learning JavaScript -->

			<!-- Keywords -->
			<!-- Here we just want a bunch of comma-separated words to aid with searching -->
			<label for="keywords">Keywords:</label><br>
			<input type="text" id="keywords" name="keywords"><br>

			<!-- Big old text area for the text to go -->
			<label for="text">Text:</label><br>
			<textarea id=text name="text">
			</textarea><br>

			<!-- Submit button -->
			<input type="submit">

		</form> <?php
	} ?>