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


