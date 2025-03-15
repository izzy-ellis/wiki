<div class="tab">
	<button class="tablinks" onclick="openTab(event, 'markup')" id="defaultOpen">Mark-up</button>
	<button class="tablinks" onclick="openTab(event, 'abbreviations')">Abbreviations</button>
	<button class="tablinks" onclick="openTab(event, 'latex')">LaTeX</button>
</div>

<!-- Tab content -->
<div id="markup" class="tabcontent">
	<h3>Markup Guide</h3>

	<p>This is how to link between projects. Topics and their matching abbreviations can be found in the "Abbreviations" tab.</p>

	<div class="code-block">
	<code>&lt<span class="comment">a</span> <span class="builtin">href</span>=<span class="string">"topic.php?topic=[abbreviation]"</span>&gtLink text&lt/<span class="comment">a</span>&gt</code>
	</div>

	<p>An inline command can be displayed using the code block with the command class</p>

	<div class="code-block">
	<code>&lt<span class="comment">p</span>&gtThis is a &lt<span class="comment">code</span> <span class="builtin">class</span>=<span class="string">"command"</span>&gtcommand&lt/<span class="comment">code</span>&gt in a line&lt/<span class="comment">p</span>&gt</code>
	</div>

	<p>This is how to display a block of code. The pre tags allow the whitespace formatting to remain. Note that whitespace is measured from the edge of the page and is not relative. There are several different span classes that can be used to add colour to a block of code</p>

	<div class="code-block">
	<pre><code>&lt<span class="comment">div</span> <span class="builtin">class</span>=<span class="string">"code-block"</span>&gt
	&lt<span class="comment">pre</span>&gt
	&lt<span class="comment">code</span>&gt&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"keyword"</span>&gtdef&lt/<span class="comment">span</span>&gt &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"function"</span>&gtfunc&lt/<span class="comment">span</span>&gt():
		&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"comment"</span>&gt# A comment&lt/<span class="comment">span</span>&gt
		x = &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"string"</span>&gt"Hello World"&lt/<span class="comment">span</span>&gt
		y = &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"builtin"</span>&gtstr&lt/<span class="comment">span</span>&gt(1)
		&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"keyword"</span>&gtreturn&lt/<span class="comment">span</span>&gt x + y&lt/<span class="comment">code</span>&gt
	&lt/<span class="comment">pre</span>&gt
	&lt/<span class="comment">div</span>&gt</code></pre>
	</div>

	<p>A table is made using the tags below. Setting the scope of the headings will help with table formatting</p>

	<div class="code-block">
	<pre><code>&lt<span class="comment">table</span>&gt
		&lt<span class="comment">tr</span>&gt
			&lt<span class="comment">th</span> <span class="builtin">scope</span>=<span class="string">"col"</span>&gtProtocol&lt/<span class="comment">th</span>&gt
			&lt<span class="comment">th</span> <span class="builtin">scope</span>=<span class="string">"col"</span>&gtDescription&lt/<span class="comment">th</span>&gt
		&lt/<span class="comment">tr</span>&gt
		&lt<span class="comment">tr</span>&gt
			&lt<span class="comment">td</span>&gtFTP&lt/<span class="comment">td</span>&gt
			&lt<span class="comment">td</span>&gtUsed to transfer files between a server and client&lt/<span class="comment">td</span>&gt
		&lt/<span class="comment">tr</span>&gt
		&lt<span class="comment">tr</span>&gt
			&lt<span class="comment">td</span>&gtHTTP&lt/<span class="comment">td</span>&gt
			&lt<span class="comment">td</span>&gtUsed to retrieve web pages from a client&lt/<span class="comment">td</span>&gt
		&lt/<span class="comment">tr</span>&gt
	&lt/<span class="comment">table</span>&gt</code></pre>
	</div>
</div>

<div id="abbreviations" class="tabcontent scroller" style="max-height: 800px;">
	<h3>Abbreviations</h3>
	<?php
	$sql = "SELECT abbreviation, title FROM pages ORDER BY abbreviation ASC";
	$abbreviations = pdo($pdo, $sql)->fetchAll();

	foreach ($abbreviations as $abbreviation) {
		echo("<b>" . strtolower($abbreviation['abbreviation']) . "</b>" . " - " . $abbreviation['title'] . "<br>");
	} 
	?>
</div>

<div id="latex" class="tabcontent">
	<h3>LaTeX instructions</h3>
	<p>Mathematics that is written in TeX or LaTeX format is indicated using math delimiters that surround the mathematics, telling MathJax what part of your page represents mathematics and what is normal text. There are two types of equations: ones that occur within a paragraph (in-line mathematics), and larger equations that appear separated from the rest of the text on lines by themselves (displayed mathematics).</p>

	<p>The default math delimiters are <code class="command">$$...$$</code> and <code class="command">\[...\]</code> for displayed mathematics, and <code class="command">\(...\)</code> for inline mathematics. Details on LaTeX markdown can be found <a href="https://oeis.org/wiki/List_of_LaTeX_mathematical_symbols" target="_blank">online</a> (opens in a new window)</p>

	<p>The following HTML options are available to make the mathmatics look nice. For inline mathematics:</p>

	<div class="code-block">
		<code>&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"maths"</span>&gt&lt/<span class="comment">span</span>&gt</code>
	</div>

	<p>For displayed mathematics:</p>
	<div class="code-block">
		<pre><code>&lt<span class="function">div</span> <span class="builtin">class</span>=<span class="string">"maths"</span>&gt
    		$$ maths $$
		&lt/<span class="comment">div</span>&gt</code></pre>
	</div>
</div>

<script>
	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>