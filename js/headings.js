document.addEventListener("DOMContentLoaded", function() {

	// Get all the headings
	headings = document.querySelectorAll("h1");					// Get a list of all headings in the page
	
	bar = document.getElementById("headings-list");				// Get the bar to write to

	for (i = 0; i < headings.length; i++) {
		link = document.createElement('a');
		link.appendChild(document.createTextNode(headings[i].textContent));
		link.setAttribute('href', ("#" + headings[i].getAttribute('id')));
		list = document.createElement('li');
		list.className = "indeks-header";
		list.appendChild(link);
		bar.appendChild(list);
	}
});