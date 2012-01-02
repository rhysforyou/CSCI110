var errors = [];

function checkValidChars() {
	var textFields = ["restaurantName", "restaurantCity", "review"];
	var textFieldNames = ["Restaurant name", "Restaurant city", "Review"];

	for (var i = 0; i < textFields.length; i++) {
		var text = document.getElementById(textFields[i]).value;

		if (text.length == 0) {
			errors.push(textFieldNames[i] + " must have content");
		}

		for (var j = 0; j < text.length; j++) {
			var ch = text[j];
			if (ch == '<' || ch == '>' || ch == '&') {
				errors.push(textFieldNames[i] + " contains illegal characters");
			}
		}
	}
}

function checkCost() {
	var cost = parseFloat(document.getElementById("cuisineCost").value);

	if (!cost) {
		errors.push("Cost must have content");
	} else if (cost < 1.0 || cost > 100.0) {
		errors.push("Cost must be between $1 and $100");
	}
}

function checkRatings() {
	var ratingFields = ["foodRating", "ambianceRating", "serviceRating", "valueRating"];
	var ratingFieldNames = ["Food", "Ambiance", "Service", "Value"];
	for (var i = 0; i < ratingFields.length; i++) {
		rating = parseFloat(document.getElementById(ratingFields[i]).value);
		if (!rating) {
			errors.push(ratingFieldNames[i] + " must be rated");
		} else if (rating < 0.0 || rating > 10.0) {
			errors.push(ratingFieldNames[i] + "'s rating must be between 0 and 10");
		}
	}
}

function checkCuisine() {
	var cuisineType = document.getElementById("cuisineType").value;
	if (cuisineType == "Select Cuisine") {
		errors.push("Must select a type of cuisine");
	}
}

function checkPostcode() {
	var postcode = document.getElementById("restaurantPostcode").value;
	var state = document.getElementById("restaurantState").value;
	if (state == "New South Wales" && postcode[0] != '2') {
		errors.push("Invalid post code");
	} else if(state == "Northern Territory" && 
		(postcode[0] != "0" || !(postcode[1] == "8" || postcode[1] == "9"))) {
		errors.push("Invalid post code");
	} else if (state == "Queensland" && postcode[0] != "4") {
		errors.push("Invalid post code");
	} else if (state == "South Australia" && postcode[0] != "5") {
		errors.push("Invalid post code");
	} else if (state == "Tasmania" && postcode[0] != "7") {
		errors.push("Invalid post code");
	} else if (state == "Victoria" && postcode[0] != "3") {
		errors.push("Invalid post code");
	} else if (state == "Western Australia" && postcode[0] != "6") {
		errors.push("Invalid post code");
	} else if (state == "Australian Capital Territory" &&
		!((parseInt(postcode, 10) >= 2600 && parseInt(postcode, 10) <= 2618) ||
		(postcode[0] == '2' && postcode[1] == '9'))) {
		errors.push("Invalid post code");
	}
}

function checkDate() {
	var dateString = document.getElementById("lastVisitDate").value;
	var date = new Date(dateString);
	if (date.toString() == "Invalid Date") {
		errors.push("Invalid date entered");
	}
}

function checkForm() {
	errors = [];
	checkValidChars();
	checkCost();
	checkRatings();
	checkCuisine();
	checkPostcode();
	checkDate();

	if (errors.length > 0) {
		var message = errors.length + " errors found:\n";
		for (var i = 0; i < errors.length; i++) {
			message += "\n" + errors[i];
		}
		alert(message);
		return false;
	}

	alert("Valid details entered!");
	return false;
}