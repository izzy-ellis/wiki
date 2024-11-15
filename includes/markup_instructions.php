<h3>Markup Guide</h3>

<p>This is how to link between projects. Topics and their matching abbreviations can be found below</p>

<div class="code-block">
<code>&lt<span class="comment">a</span> <span class="builtin">href</span>=<span class="string">"topic.php?topic=[abbreviation]"</span>&gtLink text&lt/<span class="comment">a</span>&gt</code>
</div>

<p>An inline command can be displayed using the code block with the command class</p>

<div class="code-block">
<code>&lt<span class="comment">p</span>&gtThis is a &lt<span class="comment">code</span> <span class="builtin">class</span>=<span class="string">"command"</span>&gtcommand&lt/<span class="comment">code</span>&gt in a line&lt/<span class="comment">p</span>&gt</code>
</div>

<p>This is how to display a block of code. The pre tags allow the whitespace formatting to remain. Note that whitespace is measured from the edge of the page and is not relative. There are several different span classes that can be used to add colour to a block of code</p>

<div class="code-block">
<pre>
<code>&lt<span class="comment">div</span> <span class="builtin">class</span>=<span class="string">"code-block"</span>&gt
&lt<span class="comment">pre</span>&gt
&lt<span class="comment">code</span>&gt&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"keyword"</span>&gtdef&lt/<span class="comment">span</span>&gt &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"function"</span>&gtfunc&lt/<span class="comment">span</span>&gt():
	&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"comment"</span>&gt# A comment&lt/<span class="comment">span</span>&gt
	x = &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"string"</span>&gt"Hello World"&lt/<span class="comment">span</span>&gt
	y = &lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"builtin"</span>&gtstr&lt/<span class="comment">span</span>&gt(1)
	&lt<span class="comment">span</span> <span class="builtin">class</span>=<span class="string">"keyword"</span>&gtreturn&lt/<span class="comment">span</span>&gt x + y&lt/<span class="comment">code</span>&gt
&lt/<span class="comment">pre</span>&gt
&lt/<span class="comment">div</span>&gt
</code>
</pre>
</div>

<p>A table is made using the tags below. Setting the scope of the headings will help with table formatting</p>

<div class="code-block">
<pre>
<code>
&lt<span class="comment">table</span>&gt
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
&lt/<span class="comment">table</span>&gt
</code>
</pre>
</div>