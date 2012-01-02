// Script for the zoo animal sponsor form

var totalCost = 0;
var numAnimals = 0;


function checkAnimals() {
    var animalSelector = document.getElementById("animals");
    
    totalCost = 0;
    numAnimals = 0;
    
    if(animalSelector[0].selected) {
        numAnimals++;
        totalCost += 2000;
    }
    
    if(animalSelector[1].selected) {
        numAnimals++;
        totalCost += 1900;
    }
    
    if(animalSelector[2].selected) {
        numAnimals++;
        totalCost += 1800;
    }
    
    if(animalSelector[3].selected) {
        numAnimals++;
        totalCost += 1050;
    }
    
    if(animalSelector[4].selected) {
        numAnimals++;
        totalCost += 180;
    }
    
    return (numAnimals > 0);
}

function checkCards() {
    var cardInput = document.getElementById("cardNum");
    var cardNum   = cardInput.value;
    var numDigits = 0;
    
    for (var i=0; i < cardNum.length; i++) {
        var ch = cardNum.charAt(i);
        if ((ch >= '0') && (ch <= '9')) numDigits++;
    }
    
    return (numDigits == 16);
}

function confirmSubmit() {
    if (!checkAnimals()) {
        alert("You didn't select any animals.")
        return false;
    }
    
    if (!checkCards()) {
        alert("Invalid credit card details entered.");
        return false;
    }
    
    msg = "Thank you for offering to sponsor ";
    if (numAnimals == 1) 
        msg = msg + "one of our zoo's residents. ";
    else 
        msg = msg + numAnimals + " of our zoo's residents. ";
    msg = msg + "The cost of sponsorship is $" + totalCost + ". Confirm order?";
    
    return confirm(msg);
}