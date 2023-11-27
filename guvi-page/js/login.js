const backgroundImages = [
    '/assets/mount.jpeg',
    '/assets/desktop.jpeg'
];
let currentImageIndex = 0;
const body = document.body;

function changeBackgroundImage() {
    currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
    body.style.backgroundImage = `url(${backgroundImages[currentImageIndex]})`;
}

var myButton = document.getElementById("regbtn");


myButton.addEventListener("click", function() {
  
  alert("Registration Successful");
  
});
setInterval(changeBackgroundImage, 3000);

function showRegisterForm() {
    const loginContainer = document.getElementById("login-container");
    const registerContainer = document.getElementById("register-container");

    loginContainer.querySelector(".form-inner").classList.add("flipped");
    registerContainer.querySelector(".form-inner").classList.remove("flipped");

    setTimeout(() => {
        loginContainer.classList.add("hidden");
        registerContainer.classList.remove("hidden");
    }, 500);
}

function showLoginForm() {
    const loginContainer = document.getElementById("login-container");
    const registerContainer = document.getElementById("register-container");

    registerContainer.querySelector(".form-inner").classList.add("flipped");
    loginContainer.querySelector(".form-inner").classList.remove("flipped");

    setTimeout(() => {
        loginContainer.classList.remove("hidden");
        registerContainer.classList.add("hidden");
    }, 500);
}

function togglePasswordVisibility(passwordFieldId) {
    const passwordField = document.getElementById(passwordFieldId);
    const showPasswordButton = passwordField.nextElementSibling;
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        showPasswordButton.textContent = "Hide Password";
    } else {
        passwordField.type = "password";
        showPasswordButton.textContent = "Show Password";
    }
}
async function loginUser(event) {
    event.preventDefault();
    const emailInput = document.getElementById("login-form").elements.email;
    const passwordInput = document.getElementById("login-password");
    try {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: emailInput.value,
                password: passwordInput.value
            })
        });
        if (response.ok) {
            window.location.href = "profile.html";
        } else {
            alert("Invalid email or password");
        }
    } catch (error) {
        console.error(error);
        alert("An error occurred during login");
    }
}

async function registerUser(event) {
    event.preventDefault();
    const formData = {
        fullName: document.getElementById("full-name").value,
        email: document.getElementById("register-email").value,
        password: document.getElementById("register-password").value
    };
    try {
        await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        }).then((response)=>{
            alert("Registration successful");
            console.log(response)

        }).catch((error)=>{
            alert("Registration failed: " + error);

        })
        
        
    } 
    catch (error) {
        console.error(error);
        alert("An error occurred during registration");
    }
}
