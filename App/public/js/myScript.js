const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const formID = document.querySelector("#register-form");

function isEmail (email){
    return /\S+@\S+\.\S+/.test(email);
}

function isPasswordSecure (password){
    const upperCaseLetters = /[A-Z]/g;
    const numbers = /[0-9]/g;
    const lowerCaseLetters = /[a-z]/g;

    if (!password.match(upperCaseLetters))  return false;
    if (!password.match(lowerCaseLetters))  return false;
    if (!password.match(numbers))  return false;
    return password.length >= 8;
}

function markValidation(element, condition){
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value))
        }
        , 10);
}

function validatePassword(){
    setTimeout(function (){
        const condition = isPasswordSecure(
            passwordInput.value
        );
        markValidation(passwordInput,condition);
    }
    ,10);
}

emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePassword);

formID.addEventListener("submit", function(event) {
    const noValidElement = formID.querySelector(".no-valid");
    if (noValidElement) {
        event.preventDefault();
        alert("Fix input data!")
    }
});