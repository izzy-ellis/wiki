document.addEventListener("DOMContentLoaded", function() {
	var list, i, switching, b, shouldSwitch;
	list = document.getElementById("sort-list");
	switching = true;
	/* Make a loop that will continue until no switching has been done */
	while (switching) {
		switching = false;
		b = list.getElementsByTagName("LI");
		// Loop through all list items
		for (i = 0; i < (b.length - 1); i++) {
			// Start by saying there should be no switching
			shouldSwitch = false;
			// Check if the next item should switch place with the current item
			// Might need to work this around to get the child inside the list element
			if (b[i].firstElementChild.innerHTML.toLowerCase() > b[i + 1].firstElementChild.innerHTML.toLowerCase()) {
				// If the next item is alphabetically lower than the current item, mark as a switch and break the loop
				shouldSwitch = true;
				break;
			}
		}
		if (shouldSwitch) {
			// If a switch has been marked, make the switch, and mark the switch as done
			b[i].parentNode.insertBefore(b[i + 1], b[i]);
			switching = true;
		}
	}
});