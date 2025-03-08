const postBtn = document.querySelector(".post-btn");
postBtn.addEventListener("click", () => {
    const newPostPopup = document.querySelector("#new-post-popup-wrapper");
    newPostPopup.style.display = "block";
});
const textareas = document.querySelectorAll('textarea');
textareas.forEach(textarea => {
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
})
const loggedInUserInfo = document.querySelector(".logged-in-user");
loggedInUserInfo.addEventListener("click", () => {
    const logoutWrapper = document.querySelector("#logout-wrapper");
    if(logoutWrapper.style.display === "flex"){
        logoutWrapper.style.display = "none";
    }
    else{
        logoutWrapper.style.display = "flex";
    }
})
document.addEventListener("click", function (event) {
    const loggedInUserInfo = document.querySelector(".logged-in-user");
    const logoutWrapper = document.querySelector("#logout-wrapper");
    console.log(event.target)
    if (!loggedInUserInfo.contains(event.target)) {
        logoutWrapper.style.display = "none";
    }
});


