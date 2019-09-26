function selectedValue() {
    var select = document.getElementById("period").value;
    var formElement = document.getElementById("custom")

    if (document.getElementById("period").value == 4) {
        console.log(select);
        formElement.style.display = "block";
    }
    else {
        formElement.style.display = "none";
    }
}