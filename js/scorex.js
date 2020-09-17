//login
function beginIndex(){
    fadeIn(document.getElementById('sign_in_content'), 1);
    fadeIn(document.getElementById('register_content'), 1);
}

function openForm(id){
    document.getElementById(id).style.display='block';
}

function closeForm(id){
    document.getElementById(id).style.display='none';
}

function validateRegisterForm(){
    var username = document.forms["registerForm"]["username"].value;
    var email = document.forms["registerForm"]["email"].value;
    var telefono = document.forms["registerForm"]["telefono"].value;
    var password = document.forms["registerForm"]["password"].value;
    var confirmPassword = document.forms["registerForm"]["confirmPassword"].value;

    //RegExp
    var patternUsername = /^[A-Za-z0-9 ]+$/;    //no carattere speciali
    var patternEmail = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/; //RegExp COPIATA
    var patternTelefono = /^\d+$/;              //solo numeri
    var patternPassword = /^[A-Za-z0-9 ]+$/;    //almeno una carattere speciale

    //username check
    if (/\s/.test(username)) {
        window.alert("L'username non può contenere spazi");
        return false;
    }

    if(username.charAt(0) >= 0 || username.charAt(0) <= 9){
        window.alert("L'username non può iniziare con un numero");
        return false;
    }
    if(username.length < 3){
        window.alert("L'username deve avere almeno 3 caratteri");
        return false;
    }
    
    if(!patternUsername.test(username)){
        window.alert("L'username non deve contenere caratteri speciali");
        return false;
    }
    
    //email check
    if (!patternEmail.test(email)) {
        window.alert("Indirizzo email non valido");
        return false;
    }

    //telefono check
    if (!patternTelefono.test(telefono) || telefono.length != 10 ) {
        window.alert("Numero di telefono non valido");
        return false;
    }

    //password check    
    if (/\s/.test(password)) {
        window.alert("La password non può contenere spazi");
        return false;
    }

    if(password.length < 8){
        window.alert("La password deve avere almeno 8 caratteri");
        return false;
    }
    
    if(patternPassword.test(password)){
        window.alert("La password deve contenere almeno un carattere speciale");
        return false;
    }  
    
    if(password != confirmPassword ){
        window.alert("Le password non corrispondono");
        return false;
    }
    return true;
}

//home
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}
  
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

//prenota
function beginPrenota(){
    fadeIn(document.getElementById('countfields'), 1);
    fadeIn(document.getElementById('countusers'), 1);
    fadeIn(document.getElementById('countbookings'), 1);
}

function checkPrenotazione(){
    var dalle = document.forms["bookingForm"]["dalle"].value;
    var alle = document.forms["bookingForm"]["alle"].value;

    if(parseInt(dalle) >= parseInt(alle)){      //converto stringhe numeriche in interi
        window.alert("Orario non è valido");
        return false;
    }

    if(Abs(alle - dalle) > 2){
        window.alert("Too many hours");
        return false;
    }
}

//detailed_field
function update(){
    document.forms['updateStatusForm'].submit();

}

//add_your_field
function checkField(){
    var citta = document.forms["fieldForm"]["citta"].value;
    var cap = document.forms["fieldForm"]["cap"].value;
    var telefono = document.forms["fieldForm"]["telefono"].value;

    if(/\d/.test(citta)){
        window.alert("nome di citta non valido");
        return false;
    }

    if(isNaN(cap) || !/^\d+$/.test(cap) || cap.length != 5){
        window.alert("CAP non valido");
        return false;
    }

    if(isNaN(telefono) || (telefono.length != 10 && telefono.length != 9)){
        window.alert("numero di telefono non valido");
        return false;
    }

    return checkSchedule();
}

function checkSchedule(){       //controllo che almeno un giorno abbia un orario
    var x;
    for(x = 0; x < 7; x++){
        var dalle = document.forms["fieldForm"]["dalle" + x].value;
        var alle = document.forms["fieldForm"]["alle" + x].value;
        
        if(dalle != 0 && alle != 0){
            break;
        }
    }
    if(x == 7){
        window.alert("Orario non valido");
        return false;
    }

    //controllo che ogni giorno abbia un orario valido
    for(x = 0; x < 7; x++){
        var dalle = document.forms["fieldForm"]["dalle" + x].value;
        var alle = document.forms["fieldForm"]["alle" + x].value;
        
        if(pardeInte(dalle) >= parseInte(alle) && dalle != 0 && alle != 0){
            window.alert("Orario non valido");
            return false;
        }
    }
}

function submitUpdateFieldForm(fieldId){
    document.forms["updateFieldForm"+fieldId].submit();
}

//MODAL

//apre modal
function openPopUp() {
    var modal = document.getElementById("PopUpModal");
    modal.style.display = "block";
}
function closePopUp() {
    var modal = document.getElementById("PopUpModal");
    modal.style.display = "none";
}
  
  //Se clicco fuori dal modal lo chiude 
window.onclick = function(event) {
    var modal = document.getElementById("PopUpModal");
    if (event.target == modal) {
      modal.style.display = "none";
   }
}

function showSuggestions(suggestions){
    document.getElementById("suggestions").textContent = suggestions;
}

//reviews
function checkReview(){
    var rating = document.forms["reviewForm"]["rating"].value;

    if(isNaN(rating) || !rating){
        window.alert("Seleziona una valutazione in stelline");
        return false;
    }
    return true;
}

function rate(value){
    for(i=1; i<=value; i++){
        document.getElementById("star"+i).style.backgroundImage = "url(../css/images/checkedStar.png)";
    }
    while (i<=5){
        document.getElementById("star"+i).style.backgroundImage = "url(../css/images/uncheckedStar.png)";
        i++;
    }
    document.getElementById("rating").value = value;
}

function charCountUpdate(str) {
	var lng = str.length;
	document.getElementById("charcount").textContent = 250 - lng + ' caratteri rimanenti';
}

//profile
function changePassword(){
    document.getElementById("changeLink").remove();
    div = document.getElementById("change_box");
    form = div.childNodes[0]; 

    var inputPassword = document.createElement("input");
    var inputConfirmPassword = document.createElement("input");
    var labelPassword = document.createElement("label");
    var labelConfirmPassword = document.createElement("label");
    var button = document.createElement("button");

    labelPassword.textContent = "Nuova Password";
    labelConfirmPassword.textContent = "Conferma Nuova Password";
    button.textContent = "Cambia Password";
    
    inputPassword.setAttribute("type", "password");
    inputPassword.setAttribute("name", "password");
    inputPassword.required = true;
    inputConfirmPassword.setAttribute("type", "password");
    inputConfirmPassword.setAttribute("name", "confirmPassword");
    inputConfirmPassword.required = true;
    button.setAttribute("type", "submit");
    button.setAttribute("name", "submit");


    form.appendChild(labelPassword);
    form.appendChild(inputPassword);
    form.appendChild(labelConfirmPassword);
    form.appendChild(inputConfirmPassword);
    form.appendChild(button);
}

function validatePassword(){
    var password = document.forms["psw_form"]["password"].value;
    var confirmPassword = document.forms["psw_form"]["confirmPassword"].value;

    var patternPassword = /^[A-Za-z0-9 ]+$/;    //almeno una carattere speciale

    if (/\s/.test(password)) {
        window.alert("La password non può contenere spazi");
        return false;
    }

    if(password.length < 8){
        window.alert("La password deve avere almeno 8 caratteri");
        return false;
    }

   if(patternPassword.test(password)){
        window.alert("La password deve contenere almeno un carattere speciale");
        return false;
    }  

    if(password != confirmPassword ){
        window.alert("Le password non corrispondono");
        return false;
    }
    return true;
}

