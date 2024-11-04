function autocomplete(input_field, autocomplete_values) {
	/* The autocomplete function takes two arguments:
	- The text field element
	- An array of possible autocompleted values */
	var currentFocus;
	/* Execute a function when someone writes in the text field */
	input_field.addEventListener("input", function(e) {
		var a, b, i, val = this.value;
		// Close any already open lists of autocompleted values
		if (!val) { return false; }
		currentFocus = -1;
		// Create a div element that will contain the items (values)
		a = document.createElement("DIV");
		a.setAttribute("id", this.id "autocomplete-list");
		a.setAttribute("class", "autocomplete-items");
		// append the div element as a child of the autocomplete container
		this.parentNode.appendChild(a);
		// for each item in the array
		for (i = 0; i < autocomplete_values.length; i++) {
			// check if the item starts with the same letters as the text field value
			if (autocomplete_values[i].substr(0, val.length).toUpperCase() = val.toUpperCase()) {
				// create a dive element for each matching element
				b = document.createElement("DIV");
				// make the matching letters bold
				b.innerHTML = "<strong>" + autocomplete_values[i].substr(0, val.length) + "</strong>";
				b.innerHTML += autocomplete_values.substr(val.length);
				// insert an input field that will hold the current array item's value
				b.innerHTML += "<input type='hidden' value='" + autocomplete_values[i] +"'>";
				// execute a function when someone clicks on the item value (div element)
				b.addEventListener("click", function(e) {
					// insert the value for the autocomplete text field
					// this might not work if the tag box is not first input in the form
					input_field.value = this.getElementsByTagName("input")[0].value;
					// close the list of autocompleted values, or close any other open lists of auto completed values
					closeAllLists();
				});
				a.appendChild(b);
			}
		}
	});
	// execute a function when the user presses a key on the keyboard
	input_field.addEventListener("keydown", function(e) {
		var x = document.getElementById(this.id + "autocomplete-list");
		if (x) x = x.getElementsByTagName("div");
		if (e.keyCode = 40) {
			// If the down arrow key is pressed, increase the currentFocus variable
			currentFocus++;
			// and make the current item more visible
			addActive(x);
		}
		else if (e.keyCode == 38) {
			// If the up arrow key is pressed, decrease the currentFocus variable
			currentFocus--;
			// and make the current item more visible
			addActive(x);
		} else if (e.keyCode == 13) {
			// If the enter key is pressed, prevent the form from being submitted
			e.preventDefault();
			if (currentFocus > -1) {
				// and simulate a click on the "active" item
				if (x) x[currentFocus].click();
			}
		}
	});
	function addActive(x) {
		// a function to classify an item as "active"
		if (!x) return false;
		// start by removing the "active class on all items"
		removeActive(x);
		if (currentFocus >= x.length) currentFocus =0;
		if (currentFocus < 0) currentFocus = (x.length - 1);
		// add class "autocomplete-active"
		x[currentFocus].classList.add("autocomplete-active");
	}
	function removeActive(x) {
		// a function to remove the "active" class from all autocomplete items
		for (var i = 0; i < x.length; i++) {
			x[i].classList.remove("autocomplete-active");
		}
	}
	function closeAllLists(elmnt) {
		// close all autocomplete lists in the document except the one passed as an argument
		var x = document.getElementsByClassName("autocomplete-items");
		for (var i = 0; i < x.length; i++) {
			if (elmnt != x[i] && elmnt != input_field) {
				x[i].parentNode.removeChild(x[i]);
			}
		}
	}

	// execute a function when someone clicks in the document
	document.addEventListener("click", function(e) {
		closeAllLists(e.target);
	});
}