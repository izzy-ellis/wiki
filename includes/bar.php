<!-- This is the fun top bar on the page -->
<!-- W3 How To - Autocomplete -->
<!--
	We can get a variable from PHP to JavaScript using JSON like so:
	<script> function('<\?php echo json_encode($php_variable)?>'); </script>
-->
<!-- W3 How To - Hoverable Dropdown --> 
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
				<li><a href="create_topic.php">Create page</a></li>
			</ul>
		</td>
	</table>
</div>
<hr>