

function newPostLogic(){
    document.querySelector(".post-options .upload-post-image").addEventListener("click", function () {
        document.getElementById("fileInput").click();
    });

    document.getElementById("fileInput").addEventListener("change", function () {
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
                const newFormBlock = document.querySelector("#newFormBlock");
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
                newFormBlock.appendChild(uploadedPostImageDiv);
                const postBtn = document.querySelector("#feedPostBtn");
                postBtn.classList.contains("disabled-new-post-btn") ? postBtn.classList.remove("disabled-new-post-btn") : postBtn.classList.add("disabled-new-post-btn");
                postBtn.disabled ? postBtn.disabled = false : postBtn.disabled = true;

                const removePhotoIcon = document.querySelector(".remove-photo");
                removePhotoIcon.addEventListener("click", function () {
                    $.ajax({
                        url: "/delete-post-image",
                        type: "POST",
                        data: {
                            imgPath: imgPath
                        },
                        success: function(){
                            uploadedPostImageDiv.remove();
                            postBtn.classList.add("disabled-new-post-btn");
                            postBtn.disabled = true;
                        },
                        error: function(err){
                            console.log(err)
                        }
                    })
                })
            },
            error: function(err){
                console.log(err)
            }
        })
    });
    document.querySelector("#feedNewPost .new-post-body").addEventListener("keyup", function () {
        const postBtn = document.querySelector("#feedPostBtn");
        postBtn.disabled = this.value.trim() === "";
        this.value.trim() === "" ? postBtn.classList.add("disabled-new-post-btn") : postBtn.classList.remove("disabled-new-post-btn");
    });
    document.querySelector("#feedPostBtn").addEventListener("click",function (){
        const textarea = document.querySelector("#feedNewPost .new-post-body");
        $.ajax({
            url: '/posts',
            type: 'POST',
            data: {
                content: textarea.value
            },
            success: function (post){
                textarea.value = "";
                const postsSection = document.querySelector("#posts");
                const newPostHtml = `
                   <div class="single-post">
            <img src="${post.user.photo}" loading="eager" alt="" class="user-image" />
            <div class="post-info-and-body">
                <div class="post-info">
                    <div class="posted-by-fullname">${post.user.full_name}</div>
                    <div class="posted-by-username">@${post.user.username}</div>
                    <div class="dot">·</div>
                    <div class="posted-on-date-text">now</div>
                </div>
                <div class="post-body"><p class="post-body-text">${post.content}</p></div>
                <div class="post-reactions">
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
                        <div class="post-reaction-stats-text">0</div>
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
                        <div class="post-reaction-stats-text">0</div>
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
                        <div class="post-reaction-stats-text">0</div>
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
                        <div class="post-reaction-stats-text">0</div>
                    </div>
                </div>
            </div>
        </div
            `;
                postsSection.insertAdjacentHTML('afterbegin', newPostHtml);
                newPostLogic();
            },
            error: function (err){
                console.log(err)
            }
        })
    })
}
newPostLogic();
//id za sliku,fileinput,id za formu gde se dodaje slika, id za postBtn, id za textareu
//*dodati fleg na kraju ako je popup i onda ga zatvoriti kad se post upise u bazu

