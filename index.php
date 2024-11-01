<?php
	declare(strict_types=1);
	require 'database-connection.php';
	require 'functions.php';

?>
<html>
<head>
	<title>Wiki</title>
</head>
<body>
	<div>
		<h1>Home page</h1>
		<a href="create_topic.php">Create page</a>
	<?php
	$sql = "SELECT * FROM pages";
	$results = pdo($pdo, $sql)->fetchAll();
	
	foreach ($results as $result) {
	?>

		<p><a href="topic.php?topic=<?= $result['id'] ?>"> <?= $result['name'] ?> </a></p>
		<?php
		echo "\n";
	} ?>
	</div>
	</p>
</body>
</html>