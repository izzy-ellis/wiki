<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';
	include 'includes/more_functions.php';

	add_header("Wiki");
?>

	<div id="content" class="column-full">
		<div id="side-nav-bar" class="column-fifth">
			<!-- Here we are going to list all the categories and their sub-categories -->
			<?php
				$category_sql = "SELECT id, name FROM category";
				$categories = pdo($pdo, $category_sql)->fetchAll();

				foreach($categories as $category) {
				?><h2><?= $category['name']; ?></h2>
					<ul>
						<?php 
						$sub_category_sql = "SELECT id, name, child_count FROM sub_category WHERE parent_id = {$category['id']}";
						$sub_categories = pdo($pdo, $sub_category_sql)->fetchAll();
						foreach ($sub_categories as $sub_category) {
							?> <li><a href="sub_category.php?id=<?= $sub_category['id'] ?>"><?= $sub_category['name'] ?> (<?= $sub_category['child_count'] ?>)</a></li> <?php
						} ?> </ul> <?php
				}
			?>
		</div>
		<div class="column-two-fifths">
			<h1>Popular pages</h1>
			<?php
			$popular_sql = "SELECT title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id ORDER BY pages.times_visited DESC LIMIT 3";

			$popular_pages = pdo($pdo, $popular_sql)->fetchAll();

			foreach ($popular_pages as $page) {
				display_page($page);
			}
			?>
		</div>
		<div id="recents" class="column-two-fifths">
			<h1>Recent pages</h1>
			<!-- List a number of recent projects here -->
			<?php
			$recents_sql = "SELECT title, abbreviation, description, category.name AS category, sub_category.name AS sub_category FROM pages JOIN category ON category.id = pages.category_id JOIN sub_category ON sub_category.id = pages.sub_category_id ORDER BY pages.updated_at DESC LIMIT 3";
			$recent_pages = pdo($pdo, $recents_sql)->fetchAll();

			foreach($recent_pages as $page) {
				display_page($page);
			}
			?>
		</div>	
	</div>

<?php include "includes/footer.php"; ?>