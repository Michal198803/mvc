document.addEventListener('DOMContentLoaded', function () {
    var tableIncomes = document.getElementById("tableIncomes"), sumVal = 0;

    for (var i = 1; i < tableIncomes.rows.length; i++) {
        sumVal = sumVal + parseInt(tableIncomes.rows[i].cells[0].innerHTML);
    }

    document.getElementById("incomesValue").innerHTML = sumVal;


    var tableExpences = document.getElementById("tableExpences"), sumVal2 = 0;

    for (var i = 1; i < tableExpences.rows.length; i++) {
        sumVal2 = sumVal2 + parseInt(tableExpences.rows[i].cells[0].innerHTML);
    }
    document.getElementById("expencesValue").innerHTML = sumVal2;

    var balance = sumVal - sumVal2

    if (balance >= 0) {
        document.getElementById("balanceValue").innerHTML = balance + " Your balance is positive! Keep it up !";
        document.getElementById("balance").style.color = "green";
    }
    else {
        document.getElementById("balanceValue").innerHTML = balance + " Your balance is negative! Organise better your budget !";
        document.getElementById("balance").style.color = "red";
    }
}, false);