// DOM Selection
const loginForm = document.querySelector("#login-form");

const userEmail = document.querySelector("#user-email");
const emailError = document.querySelector("#email-error");

const userPassword = document.querySelector("#user-password");

const strengthMeter = document.querySelector("#strength-meter");
const strengthText = document.querySelector("#strength-text");

// =========================
// Real-Time Email Validation
// =========================

userEmail.addEventListener("input", function () {

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailRegex.test(userEmail.value)) {

        userEmail.classList.remove("border-red-500");
        userEmail.classList.add("border-green-500");

        emailError.classList.add("hidden");

    }

    else {

        userEmail.classList.remove("border-green-500");
        userEmail.classList.add("border-red-500");

        emailError.classList.remove("hidden");

    }

});

// =========================
// Password Strength
// =========================

userPassword.addEventListener("input", function () {

    const value = userPassword.value;

    let score = 0;

    if (value.length >= 8) score++;

    if (/[A-Z]/.test(value)) score++;

    if (/[0-9]/.test(value)) score++;

    if (/[^A-Za-z0-9]/.test(value)) score++;

    if (value.length === 0) {

        strengthMeter.style.width = "0%";

        strengthText.textContent = "Strength : Empty";

    }

    else if (score <= 1) {

        strengthMeter.style.width = "25%";

        strengthMeter.className = "bg-red-500 h-2 rounded";

        strengthText.textContent = "Strength : Weak";

    }

    else if (score <= 3) {

        strengthMeter.style.width = "60%";

        strengthMeter.className = "bg-yellow-500 h-2 rounded";

        strengthText.textContent = "Strength : Moderate";

    }

    else {

        strengthMeter.style.width = "100%";

        strengthMeter.className = "bg-green-500 h-2 rounded";

        strengthText.textContent = "Strength : Strong";

    }

});

// =========================
// Login Button
// =========================

loginForm.addEventListener("submit", function (event) {

    event.preventDefault();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(userEmail.value)) {

        alert("Please Enter a Valid Email");

    }

    else if (userPassword.value.length < 8) {

        alert("Password Must Be At Least 8 Characters");

    }

    else {

        alert("Login Successful!");

    }

});
// Search Button
const searchButton=document.querySelector(".btn-search");

searchButton.addEventListener("click",function(){

alert("Searching Jobs...");

});

// Apply Button

const applyButtons=document.querySelectorAll(".btn-card-apply");

applyButtons.forEach(function(button){

button.addEventListener("click",function(){

alert("Application Submitted Successfully!");

});

});

// Newsletter

const newsletterForm=document.querySelector(".newsletter-form");

const emailInput=document.querySelector(".newsletter-form input");

newsletterForm.addEventListener("submit",function(event){

event.preventDefault();

if(emailInput.value===""){

alert("Please Enter Email");

}

else{

alert("Subscription Successful!");

}

});