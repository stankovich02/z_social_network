const registerBtn = document.querySelector("#register-btn");
const loginBtn = document.querySelector("#login-btn");
registerBtn.addEventListener("click", () => {
    const registerLoginPopup = document.querySelector("#register-login-wrapper");
    const registerContainer = document.querySelector("#register-login-wrapper #register-container");
    const loginContainer = document.querySelector("#register-login-wrapper #login-container");
    registerLoginPopup.style.display = "block";
    loginContainer.style.display = "none";
    registerContainer.style.display = "block";
})
loginBtn.addEventListener("click", () => {
    const registerLoginPopup = document.querySelector("#register-login-wrapper");
    const registerContainer = document.querySelector("#register-login-wrapper #register-container");
    const loginContainer = document.querySelector("#register-login-wrapper #login-container");
    registerLoginPopup.style.display = "block";
    registerContainer.style.display = "none";
    loginContainer.style.display = "block";
})
const closeIcon = document.querySelector(".close-icon");
closeIcon.addEventListener("click", () => {
    const popupWrapper = document.querySelector(".popup-wrapper");
    popupWrapper.style.display = "none";
})
const registerInputs = document.querySelectorAll("#register-login-wrapper input");
registerInputs.forEach(input => {
    input.addEventListener("focus", () => {
        input.parentElement.style.border = "1px solid #009dff";
    })
    input.addEventListener("blur", () => {
        input.parentElement.style.border = "1px solid rgba(136, 136, 136, 0.5)";
    })
})
const fullNameInput = document.querySelector("#register-fullname");
const usernameInput = document.querySelector("#register-username")
fullNameInput.addEventListener("input", () => {
    if(fullNameInput.value.length >= 50){
        fullNameInput.parentElement.querySelector(".num-of-characters").style.color = "red";
    }
    else{
        fullNameInput.parentElement.querySelector(".num-of-characters").style.color = "#fff6";
    }
    const numOfCharacters = fullNameInput.parentElement.querySelector(".current-num-of-characters");
    numOfCharacters.innerHTML = fullNameInput.value.length;
})
usernameInput.addEventListener("input", () => {
    if(usernameInput.value.length >= 50){
        usernameInput.parentElement.querySelector(".num-of-characters").style.color = "red";
    }
    else{
        usernameInput.parentElement.querySelector(".num-of-characters").style.color = "#fff6";
    }
    const numOfCharacters = usernameInput.parentElement.querySelector(".current-num-of-characters");
    numOfCharacters.innerHTML = usernameInput.value.length;
})
const eyeIcons = document.querySelectorAll(".eye-icon");
eyeIcons.forEach(eye => {
    eye.addEventListener("click", () =>{
        const eyeId = eye.id;
        const passwordInput = eye.parentElement.querySelector("input");

        if(eyeId === 'opened-eye'){
            const closedEye = eye.parentElement.querySelector("#closed-eye");
            passwordInput.type = "text";
            closedEye.style.display = "block";
            eye.style.display = "none"
        }
        else{
            const openedEye = eye.parentElement.querySelector("#opened-eye");
            passwordInput.type = "password";
            openedEye.style.display = "block";
            eye.style.display = "none"
        }
    })
})
const notificationPopup = document.querySelector(".notification-popup");
if(notificationPopup){
    notificationPopup.style.opacity = "1";
    setTimeout(() =>{
        notificationPopup.style.opacity = "0";
    }, 4000)
    setTimeout(() =>{
        notificationPopup.remove();
    }, 5000)
}
let currentNameLength = document.querySelector("#name-wrapper .current-num-of-characters");
let currentUsernameLength = document.querySelector("#username-wrapper .current-num-of-characters");
if(currentNameLength){
    currentNameLength.innerHTML = fullNameInput.value.length;
}
if(currentUsernameLength){
    currentUsernameLength.innerHTML = usernameInput.value.length;
}

