<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

?>
<html>
<head>
	<title>Wiki</title>
	<script type="module" src="md-block.js"></script>
</head>
<body>
	<div>
		<?php include 'bar.php'; ?>
		<h1>Home page</h1>

		<md-block src="README.md">
		</md-block>
	</div>
	</p>
</body>
</html>