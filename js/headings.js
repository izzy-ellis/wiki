document.addEventListener("DOMContentLoaded", function() {

	// Get all the headings
	headings = document.querySelectorAll("h1, h2, h3");					// Get a list of all headings in the page
	current_indentation = 1;											// The current indentation level
	list_to_append = [];											
	list_to_append[1] = document.getElementById("heading-list");		// The main list
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

		working_indentation = Number(headings[i].tagName[1]);			// Get the new indentation
		if (current_indentation == working_indentation) {
			// This means we can just add a li element to the working list
			list_to_append[current_indentation].appendChild(createBulletPoint(headings[i], id));
		}
		else if (current_indentation < working_indentation) {
			// We need to add a new working list, and move it all around
			for (j = 0; j < (working_indentation - current_indentation); j++) {
				list_to_append[current_indentation + (i + 1)] = document.createElement('ul');
				list_to_append[current_indentation].lastChild.appendChild(list_to_append[current_indentation + (i + 1)]);
			}
			current_indentation = working_indentation;
			alert(list_to_append[2])
		} else {
			// We need to find the parent of the working list, at least once
		}

	}

	function createBulletPoint(heading_element, id) {
		bullet_point = document.createElement('li');
		link = document.createElement('a');
		link.setAttribute('href', ("#" + id));
		link.appendChild(document.createTextNode(heading_element.textContent));
		bullet_point.appendChild(link);
		return bullet_point;
	}
});