<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';

	add_header("Wiki");
?>

	<div id="content" class="column-full">
		<div id="side-nav-bar" class="column-third">
			<!-- Here we are going to list all the categories and their sub-categories -->
			<?php
				$category_sql = "SELECT id, name FROM category";
				$categories = pdo($pdo, $category_sql)->fetchAll();

				foreach($categories as $category) {
				?><h2><?= $category['name']; ?></h2>
					<ul>
						<?php 
						$sub_category_sql = "SELECT id, name FROM sub_category WHERE parent_id = {$category['id']}";
						$sub_categories = pdo($pdo, $sub_category_sql)->fetchAll();
						foreach ($sub_categories as $sub_category) {
							?> <li><a href=""><?= $sub_category['name'] ?></a></li> <?php
						} ?> </ul> <?php
				}
			?>
		</div>
		<div id="main-bar" class="column-two-thirds">
			<!-- List a number of recent projects here -->
		</div>
		
		
	</div>
</body>
</html>