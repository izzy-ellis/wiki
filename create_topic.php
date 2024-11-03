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
		$sql = "INSERT INTO pages (name, file) VALUES (:title, :file)";
		$insert['title'] = $_POST['title'];
		$filename = $_POST['title'] . ".txt";
		$insert['file'] = $filename;
		pdo($pdo, $sql, $insert);

		$file = fopen($filename, 'w');
		fwrite($file, $_POST['text']);
		fclose($file);
		// Can we get the ID of the entry we just created and link to that?
	} else {
		?>
		<h1>Create page</h1>
		<form action="create_topic.php" method="POST">
			<!-- The full title of the page -->
			<!-- CSS tooltip on W3 -->
			<label for="title">Title:</label><br>
			<input type="text"  id="title" name="title"><br>

			<!-- This is apparently an insecure way to pass ID --> 
			<input type="hidden" id="id" name="id"><br>

			<!-- This is going to pass the filename over to the POST request -->
			<input type="hidden" id="file" name="file"><br>

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

			<!-- Big old text area for the text to go -->
			<label for="text">Text:</label><br>
			<textarea id=text name="text">
			</textarea><br>
		</form> <?php
	} ?>