let inputPassword = document.getElementById("id_password");
let length = document.getElementById("length");
//cand apas pe celula, apare textul
inputPassword.onfocus = function () {
    document.getElementById("messageForPass").style.display = "block";
}
//cand iese, dispare
inputPassword.onblur = function () {
    document.getElementById("messageForPass").style.display = "none";
}
//cand incepe sa tasteze, apar mesajele
inputPassword.onkeyup = function () {
    //litere mici
    let lowerCaseLetters = /[a-z]/g;
    if (inputPassword.value.match(lowerCaseLetters)) {
        document.getElementById("letter").style.display = "none";

    } else {
        document.getElementById("letter").style.display = "block";
    }
    //litere mari
    let upperCaseLetters = /[A-Z]/g;
    if (inputPassword.value.match(upperCaseLetters)) {
        document.getElementById("capital").style.display = "none";
    } else {
        document.getElementById("capital").style.display = "block";
    }
    //cifre
    let numbers = /[0-9]/g;
    if (inputPassword.value.match(numbers)) {
        document.getElementById("number").style.display = "none";
    } else {
        document.getElementById("number").style.display = "block";
    }
    //lungimea sa fie minima 8
    if (inputPassword.value.length >= 8) {
        document.getElementById("length").style.display = "none";
    } else {
        document.getElementById("length").style.display = "block";
    }
}