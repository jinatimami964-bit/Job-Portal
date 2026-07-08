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