<?php
	declare(strict_types=1);
	require_once 'includes/database-connection.php';
	require_once 'includes/functions.php';
	include 'includes/header.php';
	include 'includes/more_functions.php';

	add_header("Wiki");
?>

	<div id="content" class="column-full">
		<div id="side-nav-bar" class="column-full">
			<!-- Here we are going to list all the categories and their sub-categories -->
			<?php
				// We don't need to select the reference pages as these will be elsewhere
				$category_sql = "SELECT id, name FROM category WHERE id != 1 ORDER BY name ASC";
				$categories = pdo($pdo, $category_sql)->fetchAll();

				foreach($categories as $category) {
				?><div id="<?= $category['name'] ?>" class="column-fifth" style="height: 300px"><h2><?= $category['name']; ?></h2>
					<ul>
						<?php 
						$sub_category_sql = "SELECT id, name, child_count FROM sub_category WHERE parent_id = {$category['id']}";
						$sub_categories = pdo($pdo, $sub_category_sql)->fetchAll();
						foreach ($sub_categories as $sub_category) {
							?> <li><a href="sub_category.php?id=<?= $sub_category['id'] ?>"><?= $sub_category['name'] ?> (<?= $sub_category['child_count'] ?>)</a></li> <?php
						} ?> </ul></div> <?php
				}
			?>
		</div>	
	</div>

<?php include "includes/footer.php"; ?>