<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';

	add_header("Wiki");
?>

	<div>
		<h1>Home page</h1>

		<?php
			$sql = "SELECT * FROM pages";
			$pages = pdo($pdo, $sql)->fetchAll();

			$sql = "INSERT INTO tag_page_relation (page_id, tag_id) VALUES (1, 1)";
			pdo($pdo, $sql);
			echo var_dump($pdo->lastInsertId());

			/*foreach ($pages as $page) {
				$file_path = "/pages/" . $page['category'] . "/" . $page['sub_category'] . "/" . $page['file_name'];
				?>
				<p><a href="<?= $file_path ?>"><?= $page['title'] ?></a></p> <?php
			} */
		?>
	</div>
</body>
</html>