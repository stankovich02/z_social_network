document.addEventListener("click", function (event) {
    if (event.target.parentElement.classList.contains("post-more-options")) {
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-post-option");

        chooseOption.style.display = (chooseOption.style.display === "block") ? "none" : "block";
    }
    if (event.target.classList.contains("delete-post")) {
        const postId = event.target.getAttribute("data-id");
        $.ajax({
            url: "/posts/" + postId,
            type: "DELETE",
            success: function(){
                event.target.parentElement.parentElement.parentElement.remove();
                /*if(location.href.includes("profile")){

                }*/
            },
            error: function(err){
                console.log(err);
            }
        })
    }
});
/*document.addEventListener("DOMContentLoaded", function () {
    let observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let post = entry.target;
                let postId = post.getAttribute("data-id");
                if (!post.dataset.viewed) {
                    post.dataset.viewed = "true";
                    $.ajax({
                        url: "/register-view",
                        type: "POST",
                        data: {
                            post_id: postId
                        },
                        success: function (data) {
                            if (data.success) {

                            }
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    })
                }
            }
        });
    }, { threshold: 1.0 });

    document.querySelectorAll(".single-post").forEach(post => {
        observer.observe(post);
    });
});*/
document.addEventListener("click", function (event) {
    if(!event.target.classList.contains("more-opt-ic")){
        document.querySelectorAll(".choose-post-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
    }
});
const postMoreOptionsBlock = document.querySelectorAll(".post-more-options");
postMoreOptionsBlock.forEach(postMoreOption => {
    postMoreOption.addEventListener("click", function () {
            const chooseOption = this.parentElement.querySelector(".choose-post-option");
            if(chooseOption.style.display === "block"){
                chooseOption.style.display = "none";
            }
            else{
                chooseOption.style.display = "block";
            }
    })
});
const blockUserBtns = document.querySelectorAll(".block-user");
blockUserBtns.forEach(blockUserBtn => {
    blockUserBtn.addEventListener("click", function () {
        const userId = this.getAttribute("data-id");
        $.ajax({
            url: "/block-user",
            type: "POST",
            data: {
                user_id: userId
            },
            success: function(){
                blockUserBtn.parentElement.parentElement.parentElement.remove();
            },
            error: function(err){
                console.log(err);
            }
        })
    })
});
function newPostLogic(){
    function writeInputAndIcon(){
        let form = document.querySelector("#feedNewPost form");
        let fileInput = document.createElement("input");
        fileInput.type = "file";
        fileInput.id = "fileInput";
        fileInput.name = "post-image";
        fileInput.classList.add("hidden-file-input");
        form.appendChild(fileInput);
        let postOptions = document.querySelector("#feedNewPost .post-options");
        postOptions.style.justifyContent = 'space-between';
        let uploadPostImage = document.createElement("div");
        uploadPostImage.classList.add("upload-post-image");
        uploadPostImage.classList.add("w-embed");
        uploadPostImage.classList.add("icon-embed-xsmall");
        uploadPostImage.innerHTML = `
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--carbon"
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
                        </svg>
                            `;
        postOptions.insertAdjacentHTML('afterbegin', uploadPostImage.outerHTML);
    }
    document.querySelector("#feedNewPost .post-options .upload-post-image").addEventListener("click", function () {
        document.querySelector("#feedNewPost #fileInput").click();
    });

    document.querySelector("#feedNewPost #fileInput").addEventListener("change", function () {
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
                const FormBlock = document.querySelector("#feedNewPost #newFormBlock");
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
                let uploadPostImage = document.querySelector("#feedNewPost .post-options .upload-post-image");
                let fileInput = document.querySelector("#feedNewPost #fileInput");
                fileInput.remove();
                uploadPostImage.remove();
                let postOptions = document.querySelector("#feedNewPost .post-options");
                postOptions.style.justifyContent = "flex-end";
                const removePhotoIcon = document.querySelector("#feedNewPost .remove-photo");
                const postBtn = document.querySelector("#feedPostBtn");
                removePhotoIcon.addEventListener("click", function () {
                    $.ajax({
                        url: "/delete-post-image?imgPath=" + encodeURIComponent(imgPath),
                        type: "DELETE",
                        success: function(){
                            uploadedPostImageDiv.remove();
                            writeInputAndIcon();
                            let textArea = document.querySelector("#feedNewPost .new-post-body");
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
    document.querySelector("#feedPostBtn").addEventListener("click",function (){
        const textarea = document.querySelector("#post-body");
        const addedImage = document.querySelector("#newFormBlock .uploaded-post-image img");
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
                        <div class="post-stats-icon w-embed">
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--fe"
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 24 24"
                            >
                                <path
                                        fill="currentColor"
                                        d="M5 21v-4.157c-1.25-1.46-2-3.319-2-5.343C3 6.806 7.03 3 12 3s9 3.806 9 8.5s-4.03 8.5-9 8.5a9.35 9.35 0 0 1-4.732-1.268zm7-3c3.866 0 7-2.91 7-6.5S15.866 5 12 5s-7 2.91-7 6.5S8.134 18 12 18"
                                ></path>
                            </svg>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-reposted-stats">
                        <div class="post-stats-icon w-embed">
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--bx"
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 24 24"
                            >
                                <path fill="currentColor" d="M19 7a1 1 0 0 0-1-1h-8v2h7v5h-3l3.969 5L22 13h-3zM5 17a1 1 0 0 0 1 1h8v-2H7v-5h3L6 6l-4 5h3z"></path>
                            </svg>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-likes-stats">
                        <div class="post-stats-icon w-embed">
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--ph"
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 256 256"
                            >
                                <path
                                        fill="currentColor"
                                        d="M178 40c-20.65 0-38.73 8.88-50 23.89C116.73 48.88 98.65 40 78 40a62.07 62.07 0 0 0-62 62c0 70 103.79 126.66 108.21 129a8 8 0 0 0 7.58 0C136.21 228.66 240 172 240 102a62.07 62.07 0 0 0-62-62m-50 174.8c-18.26-10.64-96-59.11-96-112.8a46.06 46.06 0 0 1 46-46c19.45 0 35.78 10.36 42.6 27a8 8 0 0 0 14.8 0c6.82-16.67 23.15-27 42.6-27a46.06 46.06 0 0 1 46 46c0 53.61-77.76 102.15-96 112.8"
                                ></path>
                            </svg>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-views-stats">
                        <div class="post-stats-icon w-embed">
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
                                <path fill="currentColor" d="M4 9h4v11H4zm12 4h4v7h-4zm-6-9h4v16h-4z"></path>
                            </svg>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                </div>
                    </div></div`;
                    postsSection.insertAdjacentHTML('afterbegin', newPostHtml);
                if(!document.querySelector("#feedNewPost #fileInput")){
                    writeInputAndIcon();
                    newPostLogic();
                }
                document.querySelector("#feedPostBtn").classList.add("disabled-new-post-btn");
                document.querySelector("#feedPostBtn").disabled = true;
            },
            error: function (err){
                console.log(err)
            }
        })
    })
}
sendPost();
newPostLogic();
document.querySelector("#feedNewPost .new-post-body").addEventListener("keyup", function () {
    const postBtn = document.querySelector("#feedPostBtn");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-post-btn") : postBtn.classList.remove("disabled-new-post-btn");
});

