<?php
	declare(strict_types=1);
	require 'includes/database-connection.php';
	require 'includes/functions.php';

?>
<html>
<head>
	<title>Wiki</title>
	<script type="module" src="js/md-block.js"></script>
</head>
<body>
	<div>
		<?php include 'includes/bar.php'; ?>
		<h1>Home page</h1>

		<!-- Rudimentary testing suggests that "untrusted" will prevent PHP execution
			and the code will only be displayed if it is in a code block -->
		<md-block unstrusted src="link-test.md" >
		</md-block>
	</div>
</body>
</html>