<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';

	// Move the HTML to be there regardless of the POST?

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// pg 487
		// This will need updating with the new form

		$sql = "UPDATE pages SET times_visited = times_visited + 1 WHERE id = {$_POST['id']}";

		$file_path = "pages/" . $_POST['category'] . "/" . $_POST['sub_category'] . "/" . $_POST['file_name'];
		$file = fopen($file_path, 'w') or die("OH BALLS");
		fwrite($file, $_POST['text']);
		fclose($file);
		?> <a href="topic.php?topic=<?= $_POST['abbreviation'] ?>">Return</a> <?php
	} else {
	$topic = filter_input(INPUT_GET, 'topic');
	$sql = "SELECT title, abbreviation, pages.id AS id, file_name, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE abbreviation = '$topic'";
	$page_info = pdo($pdo, $sql)->fetch();

	add_header("Edit Topic", ['tooltip.css', 'htmarkl.css']);
?>

	
	<div class="column-full">
		<h1>Edit page</h1>
	</div>
	<div class="column-half">
		<form action="edit_topic.php" method="POST">
			<!-- The full title of the page -->
			<!-- CSS tooltip on W3 -->
			<label for="title">Title:</label><br>
			<input type="text"  id="title" name="title" value="<?= $page_info['title'] ?>" readonly><br>

			<!-- This is apparently an insecure way to pass ID --> 
			<input type="hidden" id="id" name="id" value="<?= $page_info['id'] ?>">

			<!-- This is going to pass the filename over to the POST request -->
			<input type="hidden" id="file_name" name="file_name" value="<?= $page_info['file_name'] ?>">

			<!-- This is going to pass the abbreviation over to the POST request -->
			<input type="hidden" id="abbreviation" name="abbreviation" value="<?= $page_info['abbreviation'] ?>">

			<!-- for now you don't get to update the category -->
			<input type="hidden" id="category" name="category" value="<?= $page_info['category'] ?>">
			<input type="hidden" id="sub_category" name="sub_category" value="<?= $page_info['sub_category'] ?>">

			<!-- Big old text area for the text to go -->
			<label for="text">Text:</label><br>
			<textarea id=text name="text"><?php 
			$file_path = "pages/" . $page_info['category'] . "/" . $page_info['sub_category'] . "/" . $page_info['file_name'];
			$file = fopen($file_path, 'r') or die("OH BALLS");
			echo fread($file, filesize($file_path));
			fclose($file); ?>
			</textarea><br>

			<!-- Submit button -->
			<input type="submit"><br>
		</form>
	</div>
	<div class="column-half">
		<?php include 'includes/markup_instructions.php'; ?>
	</div> 
<?php } ?>
</body>
</html>


