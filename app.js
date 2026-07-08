// ==========================================
// APP ROOT DOM LOCATORS
// ==========================================
const appContainer = document.getElementById('app');
const mainDashboard = document.getElementById('main-dashboard');

// ==========================================
// SCREEN 1: REGISTER VIEW RENDERER
// ==========================================
function renderRegister() {
    // Hide dashboard view container while authenticating
    mainDashboard.classList.add('hidden');
    appContainer.classList.remove('hidden');
    
    appContainer.innerHTML = `
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700 transition-all duration-300">
        <header class="mb-6 text-center">
            <h1 class="text-2xl font-extrabold text-blue-400">AOSH <span class="text-white">Portal</span></h1>
            <p class="text-slate-400 text-sm mt-1">Secure Account Registration</p>
        </header>

        <main>
            <form id="registration-form" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                    <input type="email" id="user-email" class="w-full bg-slate-900 border border-slate-600 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition" placeholder="you@example.com" required>
                    <p id="email-error" class="text-red-400 text-xs mt-1 hidden">Please enter a valid email address.</p>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium text-slate-300">Password</label>
                        <span class="text-xs text-blue-400 hover:underline cursor-pointer" id="go-signin">
                            Requirements &rarr;
                        </span>
                    </div>
                    <input type="password" id="user-password" class="w-full bg-slate-900 border border-slate-600 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition" placeholder="••••••••" required>

                    <div class="h-1.5 bg-slate-700 rounded-full mt-3 overflow-hidden">
                        <div id="strength-meter" class="h-full w-0 bg-red-500 transition-all duration-300"></div>
                    </div>
                    <p id="strength-text" class="text-xs text-slate-400 mt-1">Strength: Empty</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 shadow-lg shadow-blue-900/30">
                    Create Account
                </button>
            </form>
        </main>
    </div>
    `;

    initRegisterEvents();
}
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

// ==========================================
// SCREEN 2: PASSWORD PARAMS REQUIREMENT PAGE
// ==========================================
function renderSignInPage() {
    appContainer.innerHTML = `
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700 transition-all duration-300">
        <h2 class="text-xl font-bold text-blue-400 mb-4">Password Security Protocol</h2>
        <p class="text-sm text-slate-300 mb-4">To safeguard your engineering credentials, passwords must meet the following mandatory metrics:</p>

        <ul class="text-sm text-slate-400 space-y-2.5 mb-6">
            <li class="flex items-center gap-2"><span class="text-blue-400">✔</span> Minimum 8 characters in length</li>
            <li class="flex items-center gap-2"><span class="text-blue-400">✔</span> At least one uppercase letter (A-Z)</li>
            <li class="flex items-center gap-2"><span class="text-blue-400">✔</span> At least one numeric digit (0-9)</li>
            <li class="flex items-center gap-2"><span class="text-blue-400">✔</span> At least one special character (!@#%^&*...)</li>
        </ul>

        <button id="back-register" class="w-full bg-slate-700 hover:bg-slate-600 text-white font-medium py-2 px-4 rounded-lg transition">
            Back to Registration
        </button>
    </div>
    `;

    document.getElementById("back-register").addEventListener("click", renderRegister);
}

// ==========================================
// CAPTURE AUTHENTICATION EVENTS
// ==========================================
function initRegisterEvents() {
    const email = document.getElementById("user-email");
    const emailError = document.getElementById("email-error");
    const password = document.getElementById("user-password");
    const meter = document.getElementById("strength-meter");
    const text = document.getElementById("strength-text");
    const form = document.getElementById("registration-form");

    document.getElementById("go-signin").addEventListener("click", renderSignInPage);

    // EMAIL ANALYSERS
    email.addEventListener("input", () => {
        const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
        if (valid || email.value === "") {
            email.classList.replace("border-red-500", "border-slate-600");
            emailError.classList.add("hidden");
        } else {
            email.classList.add("border-red-500");
            emailError.classList.remove("hidden");
        }
    });

    // PASSWORD PROGRESS INTERACTION
    password.addEventListener("input", () => {
        const val = password.value;
        let score = 0;

        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        if (val.length === 0) {
            meter.style.width = "0%";
            text.textContent = "Strength: Empty";
            text.className = "text-xs text-slate-400 mt-1";
        } else if (score <= 1) {
            meter.style.width = "25%";
            meter.className = "h-full bg-red-500";
            text.textContent = "Weak Ruleset";
            text.className = "text-xs text-red-400 mt-1";
        } else if (score <= 3) {
            meter.style.width = "60%";
            meter.className = "h-full bg-yellow-500";
            text.textContent = "Moderate Protection";
            text.className = "text-xs text-yellow-400 mt-1";
        } else {
            meter.style.width = "100%";
            meter.className = "h-full bg-green-500";
            text.textContent = "Strong Passkey";
            text.className = "text-xs text-green-400 mt-1";
        }
    });

    // SUBMIT ACTIONS WITH CORRECTED COMPILER SYNTAL
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
        const passwordStrong =
            password.value.length >= 8 &&
            /[A-Z]/.test(password.value) &&
            /[0-9]/.test(password.value) &&
            /[^A-Za-z0-9]/.test(password.value);

        if (emailValid && passwordStrong) {
            showSuccess();
        } else {
            alert("Error: Core security metrics unfulfilled. Please construct a stronger key sequence.");
        }
    });
}

// ==========================================
// SCREEN 3: SUCCESS PROVISION DISPLAY
// ==========================================
function showSuccess() {
    appContainer.innerHTML = `
    <div class="w-full max-w-md text-center bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700 dynamic-fade">
        <div class="w-16 h-16 bg-green-500/10 text-green-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">✓</div>
        <h2 class="text-xl font-bold text-white mb-2">Account Provisioned Successfully</h2>
        <p class="text-sm text-slate-400 mb-6">Your authentication parameters have been verified and integrated securely.</p>
        <button id="go-dashboard" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200">
            Access Portal Ecosystem
        </button>
    </div>
    `;

    document.getElementById("go-dashboard").addEventListener("click", loadDashboardScreen);
}

// ==========================================
// TRANSITION TO MAIN INTERFACE LAYOUT
// ==========================================
function loadDashboardScreen() {
    appContainer.classList.add('hidden'); // Clear login app viewport
    mainDashboard.classList.remove('hidden'); // Smooth swap reveal portal track

    attachOldEvents();
    renderStatsSection();
}

// ==========================================
// CORE LAYOUT DOM INTERACTION CAPTURES
// ==========================================
function attachOldEvents() {
    document.querySelector(".btn-search").addEventListener("click", () => {
        alert("Initializing Database Query For Live Global Positions...");
    });

    const applyButtons = document.querySelectorAll(".btn-card-apply");
    applyButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            alert("Application Stack Transmitted to Selected Corporation Nodes!");
        });
    });

    const form = document.querySelector(".newsletter-form");
    const input = form.querySelector("input");

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        alert(`Success! Node tracking connection confirmed for: ${input.value}`);
        input.value = "";
    });

    document.getElementById("logout-btn").addEventListener("click", (e) => {
        e.preventDefault();
        renderRegister();
    });
}

// ==========================================
// MULTI-PARAM STATS CARD GENERATION
// ==========================================
function StatsCardComponent(title, count, color) {
    return `
    <div class="bg-slate-800/60 border border-slate-700/60 p-5 rounded-xl flex items-center justify-between shadow-md">
        <div>
            <h4 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">${title}</h4>
            <p class="text-3xl font-extrabold tracking-tight mt-1 text-white">${count}</p>
        </div>
        <div class="w-3 h-3 rounded-full ${color} animate-pulse"></div>
    </div>
    `;
}

const systemStats = [
    { name: "Verified Engineers", count: "2,844", color: "bg-green-500" },
    { name: "Active Architecture Openings", count: "142", color: "bg-blue-500" },
    { name: "Interviews Managed", count: "19", color: "bg-yellow-500" }
];

function renderStatsSection() {
    const container = document.getElementById("stats");
    let html = "";
    systemStats.forEach(item => {
        html += StatsCardComponent(item.name, item.count, item.color);
    });
    container.innerHTML = html;
}

// ==========================================
// INITIALIZE ENGINE
// ==========================================
renderRegister();