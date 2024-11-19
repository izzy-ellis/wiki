document.addEventListener("DOMContentLoaded", function() {
	// Get the headings box
	heading_box = document.getElementById("headings-list-pre");

	// Get all the headings
	headings = document.querySelectorAll("h1, h2, h3");

	for (i = 0; i < (headings.length - 1); i++) {
		// Check for an id on the heading
		id = "head" + i.toString();
		if (headings[i].hasAttribute('id')) {
			// If the heading has an id, we overwrite the variable
			id = headings[i].getAttribute('id');
		} else {
			// Otherwise, we give the heading the id
			headings[i].setAttribute('id', id);
		}

		paragraph = document.createElement('p');			// Create a p tag
		link = document.createElement('a');					// Create a link
		link.setAttribute('href', ("#" + id));				// Get the link to point to something
		link.appendChild(document.createTextNode(headings[i].textContent));	// Get the appropriate text for the link
		// Add some whitespace depending on the level of the heading
		paragraph.appendChild(document.createTextNode("	".repeat(headings[i].tagName[1] - 1)));
		paragraph.appendChild(link);						// Add the link object to the paragraph
		heading_box.appendChild(paragraph);					// Add the paragraph to the heading box
	}
});