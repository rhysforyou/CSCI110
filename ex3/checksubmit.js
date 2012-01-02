var numAdded = 0;

function doReset() {
	form = document.getElementById('pieForm');
	form.reset();
	numAdded = 0;
}

function doAdd () {
	var category = document.getElementById('category').value;
	var value = document.getElementById('value').value;

	var numPattern = new RegExp("^[0-9]+\.?[0-9]*$")

	if (!numPattern.test(value)) {
		alert("Invalid value entered\nCan only contain numbers.");
		return;
	}

	var catPattern =  new RegExp("^[A-Za-z0-9 ]+$");
	
	if (!catPattern.test(category)) {
		alert("Invalid category entered.\nMust consist of alphanumeric characters and spaces only.")
		return;
	}

	var categories = document.getElementById("categories");
	var values = document.getElementById("values");

	if (numAdded > 0) {
		categories.value = categories.value + "\n"
		values.value = values.value + "\n"
	}

	numAdded++;

	categories.value = categories.value + category
	values.value = values.value + value;
}

function doSubmit () {

}
