// This should stop form submission if there are empty fields
function validateForm(fields) {
	for (let field in fields) {												// Iterate through the fields
		var field_value = document.forms["create_page"][field].value;		// Get the value
		if (field_value.replaceAll(" ", "") == "") {											// If it is empty
			alert("Missing fields!")										// Throw an alert
			return false;													// Stop looking and return false.
		}
	}

}