const postBtn = document.querySelector(".post-btn");
postBtn.addEventListener("click", () => {
    const newPostPopup = document.querySelector("#new-post-popup-wrapper");
    newPostPopup.style.display = "block";
    document.body.style.overflow = "hidden";
    const closeIcon = document.querySelector(".close-new-post");
    closeIcon.addEventListener("click", () => {
       newPostPopup.style.display = "none";
        document.body.style.overflow = "auto";
    })

})

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
    if (!loggedInUserInfo.contains(event.target)) {
        logoutWrapper.style.display = "none";
    }
    if(event.target.parentElement.classList.contains("close-icon")){
        let popup = document.querySelectorAll(".popup-wrapper");
        popup.forEach(popup => {
            popup.style.display = "none";
            document.body.style.overflow = "auto";
        })

    }
});
function writeInputAndIcon(){
    let form = document.querySelector(".new-post-popup-create form");
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "fileInput";
    fileInput.name = "post-image";
    fileInput.classList.add("hidden-file-input");
    form.appendChild(fileInput);
    let postOptions = document.querySelector(".new-post-popup-create .post-options");
    postOptions.style.justifyContent = 'space-between';
    let uploadPostImage = document.createElement("div");
    uploadPostImage.classList.add("upload-post-image");
    uploadPostImage.classList.add("w-embed");
    uploadPostImage.classList.add("icon-embed-xsmall");
    uploadPostImage.innerHTML = `
<i class="fa-regular fa-image"></i>
                            <!--<svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify&#45;&#45;carbon"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 32 32"
                        >
                            <path fill="currentColor" d="M19 14a3 3 0 1 0-3-3a3 3 0 0 0 3 3m0-4a1 1 0 1 1-1 1a1 1 0 0 1 1-1"></path>
                            <path
                                    fill="currentColor"
                                    d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2m0 22H6v-6l5-5l5.59 5.59a2 2 0 0 0 2.82 0L21 19l5 5Zm0-4.83l-3.59-3.59a2 2 0 0 0-2.82 0L18 19.17l-5.59-5.59a2 2 0 0 0-2.82 0L6 17.17V6h20Z"
                            ></path>
                        </svg>-->
                            `;
    postOptions.insertAdjacentHTML('afterbegin', uploadPostImage.outerHTML);
}
function newPostLogic(){

    document.querySelector(".new-post-popup-create .upload-post-image").addEventListener("click", function () {
        document.querySelector(".new-post-popup-create #fileInput").click();
    });

    document.querySelector(".new-post-popup-create #fileInput").addEventListener("change", function () {
        let image = this.files[0];
        let formData = new FormData();
        formData.append("image", image);
        $.ajax({
            url: "/upload-post-image",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function(imgPath){
                const FormBlock = document.querySelector("#popupFormBlock");
                let uploadedPostImageDiv = document.createElement('div');
                uploadedPostImageDiv.classList.add("uploaded-post-image");
                let img = document.createElement("img");
                img.src = imgPath;
                uploadedPostImageDiv.appendChild(img);
                let removePhotoDiv = document.createElement("div");
                removePhotoDiv.classList.add("remove-photo");
                removePhotoDiv.classList.add("w-embed");
                removePhotoDiv.innerHTML = `
         <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--ic"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"></path>
                        </svg>

        `;
                uploadedPostImageDiv.appendChild(removePhotoDiv);
                FormBlock.appendChild(uploadedPostImageDiv);
                let uploadPostImage = document.querySelector(".new-post-popup-create .upload-post-image");
                let fileInput = document.querySelector(".new-post-popup-create #fileInput");
                fileInput.remove();
                uploadPostImage.remove();
                let postOptions = document.querySelector(".new-post-popup-create .post-options");
                postOptions.style.justifyContent = "flex-end";
                const removePhotoIcon = document.querySelector(".new-post-popup-create .remove-photo");
                const postBtn = document.querySelector("#popupPostBtn");
                removePhotoIcon.addEventListener("click", function () {
                    $.ajax({
                        url: "/delete-post-image?imgPath=" + encodeURIComponent(imgPath),
                        type: "DELETE",
                        success: function(){
                            uploadedPostImageDiv.remove();
                            writeInputAndIcon();
                            let textArea = document.querySelector("#post-body-2");
                            if(textArea.value.trim() === ""){
                                postBtn.classList.add("disabled-new-post-btn");
                                postBtn.disabled = true;
                            }
                            newPostLogic();
                        },
                        error: function(err){
                            console.log(err)
                        }
                    })
                })
                postBtn.classList.contains("disabled-new-post-btn") ? postBtn.classList.remove("disabled-new-post-btn") : null;
                postBtn.disabled ? postBtn.disabled = false : null;
            },
            error: function(err){
                console.log(err)
            }
        })
    });
}
function sendPost(){
    document.querySelector("#popupPostBtn").addEventListener("click",function (){
        const textarea = document.querySelector("#post-body-2");
        const addedImage = document.querySelector("#popupFormBlock .uploaded-post-image img");
        $.ajax({
            url: '/posts',
            type: 'POST',
            data: {
                content: textarea.value,
                image: addedImage ? addedImage.src : null
            },
            success: function (post){
                textarea.value = "";
                addedImage ? addedImage.parentElement.remove() : null;
                if(document.querySelector("#posts")){
                    const postsSection = document.querySelector("#posts");
                    let newPostHtml = `
                    <div class="single-post" data-id="${post.id}">
                    <div class="post-more-options-wrapper">
                        <div class="more-options w-embed post-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-post-option">
                                <div class="single-post-option delete-post" data-id="${post.id}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                        </div>
                    </div>
            <img src="${post.user.photo}" loading="eager" alt="" class="user-image" />
            <div class="post-info-and-body">
                <div class="post-info">
                    <div class="posted-by-fullname">${post.user.full_name}</div>
                    <div class="posted-by-username">@${post.user.username}</div>
                    <div class="dot">·</div>
                    <div class="posted-on-date-text">now</div>
                </div>
                <div class="post-body"><p class="post-body-text">${post.content}</p></div>`;
                    if(post.image){
                        newPostHtml += `<img
                            src="${post.image}"
                            loading="lazy"
                            sizes="100vw"
                            alt=""
                            class="post-image"
                    />`;
                    }
                    newPostHtml += `<div class="post-reactions">
                    <div class="post-comment-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                            <i class="fa-regular fa-comment post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-reposted-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-solid fa-retweet post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-likes-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-regular fa-heart post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-views-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-solid fa-chart-simple post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                </div>
                    </div></div`;
                    postsSection.insertAdjacentHTML('afterbegin', newPostHtml);
                }
                if(!document.querySelector(".new-post-popup-create #fileInput")){
                    writeInputAndIcon();
                    newPostLogic();
                }
                document.querySelector("#popupPostBtn").classList.add("disabled-new-post-btn");
                document.querySelector("#popupPostBtn").disabled = true;
                const popupWrapper = document.querySelector("#new-post-popup-wrapper");
                popupWrapper.style.display = "none";
                document.body.style.overflow = "auto";
                if(!document.querySelector("#posts")){
                    let newPostMessage = document.createElement('div')
                    newPostMessage.id = "message-popup";
                    newPostMessage.innerHTML = `<p>Your post was sent.</p><a href="${post.post_link}">View</a>`;
                    document.body.appendChild(newPostMessage);
                    setTimeout(function (){
                        newPostMessage.classList.add('show-message-popup');
                    },200);
                    setTimeout(function (){
                        newPostMessage.remove();
                    }, 6000);
                }
            },
            error: function (err){
                console.log(err)
            }
        })
    })
}
sendPost();
newPostLogic();
document.querySelector("#popupFormBlock #post-body-2").addEventListener("input", function () {
    const postBtn = document.querySelector("#popupPostBtn");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-post-btn") : postBtn.classList.remove("disabled-new-post-btn");
});






