<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';
	include 'includes/header.php';
	include 'includes/more_functions.php';

	add_header("Index", [], ['sort-list.js', 'headings.js']);

?>

<div class="column-full" id="headings-bar">
	<ul class="navlist" id="headings-list"></ul>
</div>
<div class="column-full">
	<ul class="index" id="sort-list">
		<?php
		$pages_sql = "SELECT title, abbreviation FROM pages";
		$pages = pdo($pdo, $pages_sql)->fetchAll();

		$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz";

		foreach ($pages as $page) {
			?> <li> <?php
			$starting_letter = strtolower(substr($page['title'], 0, 1));
			if (substr_count($alphabet, $starting_letter)) {
				/* We're going to get the first letter of the title, convert it to lower, and see if it is in the alphabet 
					This bit of code will run if it is 
					If it is in the alphabet, we want to remove it so we don't create a new header for it */
				?> <h1 id="<?= $starting_letter ?>"><?= strtoupper($starting_letter) ?></h1> </li> <li><?php
				$alphabet = str_replace($starting_letter, "", $alphabet);
			}

			display_page($page);
			?> </li> <?php
		}
		?>
	</ul>
</div>

<?php
	include 'includes/footer.php';
?>