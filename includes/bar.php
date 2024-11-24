<!-- This is the fun top bar on the page -->
<!-- W3 How To - Autocomplete -->
<!--
	We can get a variable from PHP to JavaScript using JSON like so:
	<script> function('<\?php echo json_encode($php_variable)?>'); </script>
-->
<!-- W3 How To - Hoverable Dropdown --> 

<?php 
	require_once 'includes/database-connection.php';
	require_once 'includes/functions.php';
?>
<div class="column-full">
	<table style="width:100%">
		<td><a href="index.php">Home</a></td>
		<td>
			<form name="search" action="search.php">
				<label for="search">Search:</label>
				<input type="search" id="search" name="search">
				<input type="submit">
			</form>
		</td>
		<td>
			<ul class="navlist">
				<li><a href="indeks.php">Index</a></li>
				<li>
					<div class="dropdown">
						<a class="droplink">Reference Pages</a>
						<div class="dropdown-content">
							<?php 
							$reference_sql = "SELECT title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id WHERE pages.category_id = 1";
							$references = pdo($pdo, $reference_sql)->fetchAll();

							foreach($references as $reference) {
								?> <a href="topic.php?topic=<?= $reference['abbreviation'] ?>"><?= $reference['title'] ?></a> <?php
							}
							?>
						</div>
					</div>
				</li>
				<li><a href="create_topic.php">Create page</a></li>
			</ul>
		</td>
	</table>
	<hr>
</div>
