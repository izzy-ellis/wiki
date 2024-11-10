<?php
	declare(strict_types=1);

	function add_header($title="Wiki", $css_includes=[], $js_includes=[]) {
		$variable = "text";
		// This is going to make the header code for each page
		// I want to pass the CSS and JS as args so we don't have to load everything for every page
		?>
		<html>
		<head>
			<title><?= $title ?></title>

			<?php
			// Adding the CSS includes
			foreach ($css_includes as $css_file) {
				// We can auto-include autocomplete.css as every page will have the search bar
				?> <link rel="stylesheet" href="css/<?= $css_file ?>"> <?php
			} ?>
			<link rel="stylesheet" href="css/autocomplete.css">
			<link rel="stylesheet" href="css/liquid.css">

			<?php
			// Add the JavaScript includes
			foreach ($js_includes as $js_file) {
				// We can auto-include autocomplete.js as every page will have the search bar
				?> <script type="text/javascript" src="js/<?= $js_file ?>"></script> <?php
			} ?> 

			<script type="text/javascript" src="js/autocomplete.js"></script>

		</head>

		<body>
			<?php
			include 'includes/bar.php';
} ?>