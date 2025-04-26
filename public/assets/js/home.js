document.addEventListener("click", function (event) {
    if (event.target.parentElement.classList.contains("post-more-options")) {
        const allChooseOptions = document.querySelectorAll(".choose-post-option");
        allChooseOptions.forEach(chooseOption => {
            if(chooseOption.style.display === "block"){
                chooseOption.style.display = "none";
            }
        })
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-post-option");

        if(chooseOption.style.display === "block"){
            chooseOption.style.display = "none";
        }
        else{
            chooseOption.style.display = "block";
        }
    }
    if (event.target.classList.contains("delete-post")) {
        const postId = event.target.getAttribute("data-id");
        const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        const confirmDelete = document.querySelector("#doActionBtn");
        confirmDelete.className = "deletePostPopupBtn";
        confirmDelete.textContent = "Delete";
        const cancelDelete = document.querySelector("#cancelAction");
        let popupHeading = document.querySelector("#action-popup-wrapper h3");
        popupHeading.textContent = "Delete post?";
        let popupText = document.querySelector("#action-popup-wrapper p");
        popupText.textContent = "This can’t be undone and it will be removed from your profile, the timeline of any accounts that follow you, and from search results.";
        actionPopupWrapper.style.display = "block";
        document.body.style.overflow = "hidden";
        confirmDelete.addEventListener("click", function () {
            $.ajax({
                url: "/posts/" + postId,
                type: "DELETE",
                success: function(){
                    event.target.parentElement.parentElement.parentElement.remove();
                    actionPopupWrapper.style.display = "none";
                    document.body.style.overflow = "auto";
                    let newPostMessage = document.createElement('div')
                    newPostMessage.id = "message-popup";
                    newPostMessage.innerHTML = `<p>Your post was deleted</p>`;
                    document.body.appendChild(newPostMessage);
                    setTimeout(function (){
                        newPostMessage.classList.add('show-message-popup');
                    },50);
                    setTimeout(function (){
                        newPostMessage.remove();
                    }, 4000);
                },
                error: function(err){
                    console.log(err);
                }
            })
        })
        cancelDelete.addEventListener("click", function () {
            actionPopupWrapper.style.display = "none";
            document.body.style.overflow = "auto";
        })
    }
    if(!event.target.classList.contains("more-opt-ic")){
        document.querySelectorAll(".choose-post-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
    }
    let disallowedPostClicks = ["user-image","posted-by-fullname","post-ic","more-opt-ic", "choose-post-option", "delete-post"];
    let allowedPostClicks = ["post-info", "single-post", "post-info-and-body", "post-body", "post-body-text", "post-reactions"];
    if(allowedPostClicks.includes(event.target.className) && !disallowedPostClicks.includes(event.target.className)){
        let post = event.target;
        if(post.classList.contains("single-post")){
            let postId = post.getAttribute("data-id");
            $.ajax({
                url: '/posts/navigate/' + postId,
                type: 'GET',
                success: function (link) {
                    window.location.href = link.post_link;
                },
                error: function () {
                    console.log("error");
                }
            });
        }
        else{
            while(!post.classList.contains("single-post")){
                post = post.parentElement;
                if(post.classList.contains("single-post")){
                    let postId = post.getAttribute("data-id");
                    $.ajax({
                        url: '/posts/navigate/' + postId,
                        type: 'GET',
                        success: function (link) {
                            window.location.href = link.post_link;
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                    break;
                }
            }
        }
    }
    if(event.target.parentElement.parentElement.classList.contains("post-likes-stats")){
        let icon = event.target;
        let postId =icon.parentElement.getAttribute("data-id");
        $.ajax({
            url: `/posts/${postId}/like`,
            type: "POST",
            success: function(data){
                let postLikesStats = event.target.parentElement.parentElement.querySelector(".post-reaction-stats-text");
                if(icon.classList.contains("fa-regular")){
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                    icon.classList.add("likedPost");
                    postLikesStats.classList.add("likedPost");
                }
                else{
                    icon.classList.remove("fa-solid");
                    icon.classList.remove("likedPost");
                    postLikesStats.classList.remove("likedPost");
                    icon.classList.add("fa-regular");
                }

                postLikesStats.textContent = data.likes > 0 ? data.likes : "";
            },
        })
    }
    if(event.target.parentElement.parentElement.classList.contains("post-reposted-stats")){
        let icon = event.target;
        let postId = icon.parentElement.getAttribute("data-id");
        $.ajax({
            url: `/posts/${postId}/repost`,
            type: "POST",
            success: function(data){
                let postRepostedStats = event.target.parentElement.parentElement.querySelector(".post-reaction-stats-text");
                if(icon.classList.contains("repostedPost")){
                    icon.classList.remove("repostedPost");
                    postRepostedStats.classList.remove("repostedPost");
                }
                else{
                    icon.classList.add("repostedPost");
                    postRepostedStats.classList.add("repostedPost");
                }

                postRepostedStats.textContent = data.reposts > 0 ? data.reposts : "";
            },
        })
    }
    if(event.target.parentElement.parentElement.classList.contains("post-comment-stats")){
        let popupWrapper = document.querySelector("#new-comment-popup-wrapper");
        let icon = event.target;
        let postId = icon.parentElement.getAttribute("data-id");
        $.ajax({
            url: `/posts/${postId}`,
            type: "GET",
            success: function(data){
                let commentOnUserImg = popupWrapper.querySelector(".comment-on-user-img img")
                let commentOnUserFullName = popupWrapper.querySelector(".commented-on-fullname");
                let commentOnUserUsername = popupWrapper.querySelector(".commented-on-username");
                let postCreatedTime = popupWrapper.querySelector(".commented-on-comment-time");
                let commentBody = popupWrapper.querySelector(".comment-body");
                let replyingTo = popupWrapper.querySelector(".replying-to-text span");
                commentOnUserImg.src = data.post.user.photo;
                commentOnUserFullName.textContent = data.post.user.full_name;
                commentOnUserUsername.textContent = "@" + data.post.user.username;
                postCreatedTime.textContent = data.post.created_at;
                let commentOnPostContent = popupWrapper.querySelector("#commentOnPostContent");
                if(commentOnPostContent){
                    commentOnPostContent.innerHTML = '';
                    if(data.post.content){
                        commentOnPostContent.innerHTML = `<p>${data.post.content}</p>`;
                    }
                    if(data.post.image){
                        commentOnPostContent.innerHTML += `<img src="${data.post.image}" alt="post-image" class="post-comment-image">`;
                    }
                }
                else{
                    let commentContentDiv = document.createElement('div');
                    commentContentDiv.id = "commentOnPostContent";
                    if(data.post.content){
                        commentContentDiv.innerHTML += `<p>${data.post.content}</p>`;
                    }
                    if(data.post.image){
                        commentContentDiv.innerHTML += `<img src="${data.post.image}" alt="post-image" class="post-comment-image">`;
                    }
                    commentBody.appendChild(commentContentDiv);
                }
                replyingTo.textContent = "@" + data.post.user.username;
                let replyBtn = document.querySelector("#replyBtn");
                replyBtn.setAttribute("data-id", postId);
                popupWrapper.style.display = "block";
                document.body.style.overflow = "hidden";
            },
            error: function (err){
                console.log(err)
            }
        })
    }
    if(event.target.className === "blockUserPopupBtn"){
        let userId = event.target.getAttribute("data-id");
        let blockUserBtns = document.querySelectorAll(`.block-user[data-id="${userId}"]`);
        let actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        $.ajax({
            url: `/users/${userId}/block`,
            type: "POST",
            success: function(){
                blockUserBtns.forEach(blockUserBtn => {
                    blockUserBtn.parentElement.parentElement.parentElement.remove();
                })
                actionPopupWrapper.style.display = "none";
                document.body.style.overflow = "auto";
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.classList.contains("cancelPopupBtn")){
        const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        actionPopupWrapper.style.display = "none";
        document.body.style.overflow = "auto";
    }
    if(event.target.classList.contains("follow-user")){
        const userId = event.target.getAttribute("data-id");
        const username = event.target.getAttribute("data-username");
        $.ajax({
            url: `/users/${userId}/follow`,
            type: "POST",
            success: function(){
                let followMessage = document.createElement('div')
                followMessage.id = "message-popup";
                followMessage.innerHTML = `<p>You followed <strong>@${username}</strong></p>`;
                document.body.appendChild(followMessage);
                let followUserBtns = document.querySelectorAll(`.follow-user[data-id="${userId}"]`);
                followUserBtns.forEach(followUserBtn => {
                    followUserBtn.classList.remove ("follow-user");
                    followUserBtn.classList.add("unfollow-user");
                    followUserBtn.innerHTML = `<i class="fa-solid fa-user-xmark"></i> Unfollow @${username}`;
                })
                setTimeout(function (){
                    followMessage.classList.add('show-message-popup');
                },50);
                setTimeout(function (){
                    followMessage.remove();
                }, 3000);
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.classList.contains("unfollow-user")){
        const userId = event.target.getAttribute("data-id");
        const username = event.target.getAttribute("data-username");
        $.ajax({
            url: `/users/${userId}/unfollow`,
            type: "POST",
            success: function(){
                let followMessage = document.createElement('div')
                followMessage.id = "message-popup";
                followMessage.innerHTML = `<p>You unfollowed <strong>@${username}</strong></p>`;
                document.body.appendChild(followMessage);
                let unfollowUserBtns = document.querySelectorAll(`.unfollow-user[data-id="${userId}"]`);
                unfollowUserBtns.forEach(unfollowUserBtn => {
                    unfollowUserBtn.classList.remove ("unfollow-user");
                    unfollowUserBtn.classList.add("follow-user");
                    unfollowUserBtn.innerHTML = `<i class="fa-solid fa-user-plus"></i> Follow @${username}`;
                })
                setTimeout(function (){
                    followMessage.classList.add('show-message-popup');
                },50);
                setTimeout(function (){
                    followMessage.remove();
                }, 3000);
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.classList.contains("block-user")){
        const userId = event.target.getAttribute("data-id");
        const username = event.target.getAttribute("data-username");
        const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        const confirmBlock = document.querySelector("#doActionBtn");
        confirmBlock.className = "blockUserPopupBtn";
        confirmBlock.textContent = "Block";
        confirmBlock.setAttribute("data-id", userId);
        confirmBlock.setAttribute("data-username", username);
        let popupHeading = document.querySelector("#action-popup-wrapper h3");
        popupHeading.textContent = `Block @${username}?`;
        let popupText = document.querySelector("#action-popup-wrapper p");
        popupText.textContent = `They will be able to see your public posts, but will no longer be able to engage with them. @${username} will also not be able to follow or message you, and you will not see notifications from them. `;
        actionPopupWrapper.style.display = "block";
        document.body.style.overflow = "hidden";
    }

});
function feedNewPostLogic(){
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
        uploadPostImage.innerHTML = `<i class="fa-regular fa-image"></i>`;
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
                postOptions.style.justifyContent = "space-between";
                const removePhotoIcon = document.querySelector("#feedNewPost .remove-photo");
                const postBtn = document.querySelector("#feedPostBtn");
                removePhotoIcon.addEventListener("click", function () {
                    $.ajax({
                        url: "/delete-post-image?imgPath=" + encodeURIComponent(imgPath),
                        type: "DELETE",
                        success: function(){
                            uploadedPostImageDiv.remove();
                            feedWriteInputAndIcon();
                            let textArea = document.querySelector("#feedNewPost .new-post-body");
                            if(textArea.value.trim() === ""){
                                postBtn.classList.add("disabled-new-post-btn");
                                postBtn.disabled = true;
                            }
                            feedNewPostLogic();
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
function feedSendPost(){
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
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-post-option">
                                <div class="single-post-option delete-post" data-id="${post.id}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true"  xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                        </div>
                    </div>
            <img src="${post.user.photo}" loading="eager" alt="" class="user-image" />
            <div class="post-info-and-body">
                <div class="post-info">
                    <div class="posted-by-fullname">${post.user.full_name}</div>
                    <div class="posted-by-username">@${post.user.username}</div>
                    <div class="dot">·</div>
                    <div class="posted-on-date-text">now</div>
                </div>`;
                let postBody = document.createElement("div");
                postBody.classList.add("post-body");
                let regex = /#(\w+)/g;
                let content = post.content.replace(regex, '<span class="hashtag">#$1</span>');
                postBody.innerHTML = `<p class="post-body-text">${content}</p>`;
                newPostHtml += postBody.outerHTML;
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
                if(!document.querySelector("#feedNewPost #fileInput")){
                    feedWriteInputAndIcon();
                    feedNewPostLogic();
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
feedSendPost();
feedNewPostLogic();
function feedWriteInputAndIcon(){
    let form = document.querySelector("#feedNewPost form");
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "fileInput";
    fileInput.name = "post-image";
    fileInput.classList.add("hidden-file-input");
    form.appendChild(fileInput);
    let postEmojiImage = document.querySelector("#feedNewPost #postEmojiImagePick");
    let uploadPostImage = document.createElement("div");
    uploadPostImage.classList.add("upload-post-image");
    uploadPostImage.classList.add("w-embed");
    uploadPostImage.classList.add("icon-embed-xsmall");
    uploadPostImage.innerHTML = `<i class="fa-regular fa-image"></i>`;
    postEmojiImage.appendChild(uploadPostImage);
}
document.querySelector("#feedNewPost .new-post-body").addEventListener("input", function () {
    const postBtn = document.querySelector("#feedPostBtn");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-post-btn") : postBtn.classList.remove("disabled-new-post-btn");
});
let observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            let post = entry.target;
            let postId = post.getAttribute("data-id");
            if (!post.dataset.viewed) {
                post.dataset.viewed = "true";
                markPostAsViewed(postId);
            }
        }
    });
}, { threshold: 0.5 });
let viewedPosts = new Set();
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#newCommentTextArea").addEventListener("input", function () {
        const replyBtn = document.querySelector("#replyBtn");
        replyBtn.disabled = this.value.trim() === "";
        this.value.trim() === "" ? replyBtn.classList.add("disabled-new-comment") : replyBtn.classList.remove("disabled-new-comment");
    });
    document.querySelector("#replyBtn").addEventListener("click", function () {
        const comment = document.querySelector("#newCommentTextArea").value;
        const postId = this.getAttribute("data-id");
        $.ajax({
            url: `/posts/${postId}/comment`,
            type: "POST",
            data: {
                comment: comment
            },
            success: function(data){
                document.querySelector("#new-comment-popup-wrapper").style.display = "none";
                document.body.style.overflow = "auto";
                document.querySelector("#newCommentTextArea").value = "";
                document.querySelector("#replyBtn").classList.add("disabled-new-comment");
                document.querySelector("#replyBtn").disabled = true;
                let newCommentMessage = document.createElement('div')
                newCommentMessage.id = "message-popup";
                newCommentMessage.innerHTML = `<p>Your comment was sent.</p><a href="${data.post_link}">View</a>`;
                localStorage.setItem('commentId', data.comment_id);
                document.body.appendChild(newCommentMessage);
                setTimeout(function (){
                    newCommentMessage.classList.add('show-message-popup');
                },200);
                setTimeout(function (){
                    newCommentMessage.remove();
                }, 6000);
            },
            error: function(err){
                console.log(err);
            }
        })
    });

    window.addEventListener("beforeunload", sendViewedPostsToServer);

    observePosts();
})
function markPostAsViewed(postId){
    viewedPosts.add(postId);
}
function sendViewedPostsToServer(){
    if(viewedPosts.size === 0) return;

    $.ajax({
        url: '/posts/mark-multiple-views',
        type: 'POST',
        data: {
            post_ids: Array.from(viewedPosts)
        },
        success: function () {
            viewedPosts.clear();
        },
        error: function (err) {
            console.log(err);
        }
    });
}
function observePosts(){
    document.querySelectorAll(".single-post").forEach(post => {
        if (!post.dataset.observing) {
            observer.observe(post);
            post.dataset.observing = "true";
        }
    });
}
let offset = 10;
let isFetching = false;
$(window).on("scroll", function () {
    let scrollHeight = $(document).height();
    let scrollTop = $(window).scrollTop();
    let windowHeight = $(window).height();

    if (scrollTop + windowHeight >= scrollHeight) {
        loadMorePosts();
    }
});

function loadMorePosts() {
    if (isFetching) return;

    isFetching = true;
    let activePostFilter = document.querySelector(".active-post-filter");
    let filter = activePostFilter.parentElement.className === 'foryou-filter' ? 'for-you' : 'following';
    $.ajax({
        url: `/posts?offset=${offset}&filter=${filter}`,
        type: "GET",
        success: function (data){
            if (data.posts.length === 0) {
                $(window).off("scroll");
                return;
            }

            const container = document.getElementById("posts");
            data.posts.forEach(post => {
                const postElement = document.createElement("div");
                postElement.classList.add("single-post");
                postElement.setAttribute("data-id", post.id);
                const postMoreOptionsWrapper = document.createElement("div");
                postMoreOptionsWrapper.classList.add("post-more-options-wrapper");
                postMoreOptionsWrapper.innerHTML = `
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg"  aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>`;
                const choosePostOption = document.createElement("div");
                choosePostOption.classList.add("choose-post-option");
                choosePostOption.innerHTML = `  <div class="single-post-option block-user" data-id="${post.user.id}" data-username="${post.user.username}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;${post.user.username}`;
                if(post.user.loggedInUserFollowing){
                    choosePostOption.innerHTML += `<div class="single-post-option unfollow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;${post.user.username}</div>`;
                }
                else {
                    choosePostOption.innerHTML += `<div class="single-post-option follow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-plus"></i> Follow &#64;${post.user.username}</div>`;
                }
                postMoreOptionsWrapper.appendChild(choosePostOption);
                postElement.appendChild(postMoreOptionsWrapper);
                postElement.innerHTML += `
                        <a href="${post.user.profile_link}"><img src="${post.user.photo}" loading="eager" alt="" class="user-image" /></a>`;
                let postInfoAndBody = document.createElement("div");
                postInfoAndBody.classList.add("post-info-and-body");
                postInfoAndBody.innerHTML = `<div class="post-info">
                                <a href="${post.user.profile_link}" class="posted-by-fullname">${post.user.full_name}</a>
                                <a href="${post.user.profile_link}" class="posted-by-username">&#64;${post.user.username}</a>
                                <div class="dot">·</div>
                                <div class="posted-on-date-text">${post.created_at}</div>
                            </div>`;
                let postBody = document.createElement("div");
                postBody.classList.add("post-body");
                if(post.content){
                    let regex = /#(\w+)/g;
                    let content = post.content.replace(regex, '<span class="hashtag">#$1</span>');
                    postBody.innerHTML += `<p class="post-body-text">${content}</p>`;
                }
                if(post.image){
                    postBody.innerHTML += `<img
                                    src="${post.image}"
                                    loading="lazy"
                                    sizes="100vw"
                                    alt=""
                                    class="post-image"
                            />`;
                }
                postInfoAndBody.appendChild(postBody);
                postInfoAndBody.innerHTML += `
                            <div class="post-reactions">
                                <div class="post-comment-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="fa-regular fa-comment post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.number_of_comments > 0 ? post.number_of_comments : ""}</div>
                                </div>
                                <div class="post-reposted-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_reposted ? "repostedPost" : ""} fa-solid fa-retweet post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_reposted ? "repostedPost" : ""}">${post.number_of_reposts > 0 ? post.number_of_reposts : ""}</div>
                                </div>
                                <div class="post-likes-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_liked ? "fa-solid likedPost" : "fa-regular"} fa-heart post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_liked ? "likedPost" : ""}">${post.number_of_likes > 0 ? post.number_of_likes : ""}</div>
                                </div>
                                <div class="post-views-stats">
                                    <div class="post-stats-icon">
                                        <i class="fa-solid fa-chart-simple post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.views > 0 ? post.views : ''}</div>
                                </div>
                            </div>
                `;
                postElement.innerHTML += postInfoAndBody.outerHTML;
                container.appendChild(postElement);
            });
            observePosts();
            if (data.posts.length < 10) {
                $(window).off("scroll");
                return;
            }
            offset += 10;
            isFetching = false;
        }
    });
}
let forYouFilter = document.querySelector(".foryou-filter")
let followingFilter = document.querySelector(".following-filter")
if(forYouFilter){
    forYouFilter.addEventListener("click", function (){
        sendViewedPostsToServer();
        let filterText = forYouFilter.querySelector(".post-filter-text");
        if(!filterText.classList.contains("active-post-filter")){
            filterText.classList.add("active-post-filter");
            followingFilter.querySelector(".post-filter-text").classList.remove("active-post-filter");
        }
        $.ajax({
            url: `/posts?offset=0&filter=for-you`,
            type: "GET",
            success: function (data){
                if (posts.length === 0) {
                    $(window).off("scroll");
                    return;
                }
                const container = document.getElementById("posts");
                container.innerHTML = "";
                if(data.posts){
                    data.posts.forEach(post => {
                        const postElement = document.createElement("div");
                        postElement.classList.add("single-post");
                        postElement.setAttribute("data-id", post.id);
                        const postMoreOptionsWrapper = document.createElement("div");
                        postMoreOptionsWrapper.classList.add("post-more-options-wrapper");
                        postMoreOptionsWrapper.innerHTML = `
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>`;
                        const choosePostOption = document.createElement("div");
                        choosePostOption.classList.add("choose-post-option");
                        choosePostOption.innerHTML = `  <div class="single-post-option block-user" data-id="${post.user.id}" data-username="${post.user.username}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;${post.user.username}`;
                        if(post.user.loggedInUserFollowing){
                            choosePostOption.innerHTML += `<div class="single-post-option unfollow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;${post.user.username}</div>`;
                        }
                        else {
                            choosePostOption.innerHTML += `<div class="single-post-option follow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-plus"></i> Follow &#64;${post.user.username}</div>`;
                        }
                        postMoreOptionsWrapper.appendChild(choosePostOption);
                        postElement.appendChild(postMoreOptionsWrapper);
                        postElement.innerHTML += `
                        <a href="${post.user.profile_link}"><img src="${post.user.photo}" loading="eager" alt="" class="user-image" /></a>`;
                        let postInfoAndBody = document.createElement("div");
                        postInfoAndBody.classList.add("post-info-and-body");
                        postInfoAndBody.innerHTML = `<div class="post-info">
                                <a href="${post.user.profile_link}" class="posted-by-fullname">${post.user.full_name}</a>
                                <a href="${post.user.profile_link}" class="posted-by-username">&#64;${post.user.username}</a>
                                <div class="dot">·</div>
                                <div class="posted-on-date-text">${post.created_at}</div>
                            </div>`;
                        let postBody = document.createElement("div");
                        postBody.classList.add("post-body");
                        if(post.content){
                            let regex = /#(\w+)/g;
                            let content = post.content.replace(regex, '<span class="hashtag">#$1</span>');
                            postBody.innerHTML += `<p class="post-body-text">${content}</p>`;
                        }
                        if(post.image){
                            postBody.innerHTML += `<img
                                    src="${post.image}"
                                    loading="lazy"
                                    sizes="100vw"
                                    alt=""
                                    class="post-image"
                            />`;
                        }
                        postInfoAndBody.appendChild(postBody);
                        postInfoAndBody.innerHTML += `
                            <div class="post-reactions">
                                <div class="post-comment-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="fa-regular fa-comment post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.number_of_comments > 0 ? post.number_of_comments : ""}</div>
                                </div>
                                <div class="post-reposted-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_reposted ? "repostedPost" : ""} fa-solid fa-retweet post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_reposted ? "repostedPost" : ""}">${post.number_of_reposts > 0 ? post.number_of_reposts : ""}</div>
                                </div>
                                <div class="post-likes-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_liked ? "fa-solid likedPost" : "fa-regular"} fa-heart post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_liked ? "likedPost" : ""}">${post.number_of_likes > 0 ? post.number_of_likes : ""}</div>
                                </div>
                                <div class="post-views-stats">
                                    <div class="post-stats-icon">
                                        <i class="fa-solid fa-chart-simple post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.views > 0 ? post.views : ''}</div>
                                </div>
                            </div>
                `;
                        postElement.innerHTML += postInfoAndBody.outerHTML;
                        container.appendChild(postElement);
                    });
                }
                offset = 10;
                isFetching = false;
                observePosts();
            }
        });
    })
}
if(followingFilter){
    followingFilter.addEventListener("click", function (){
        sendViewedPostsToServer();
        let filterText = followingFilter.querySelector(".post-filter-text");
        if(!filterText.classList.contains("active-post-filter")){
            filterText.classList.add("active-post-filter");
            forYouFilter.querySelector(".post-filter-text").classList.remove("active-post-filter");
        }
        $.ajax({
            url: `/posts?offset=0&filter=following`,
            type: "GET",
            success: function (data){
                if (posts.length === 0) {
                    $(window).off("scroll");
                    return;
                }

                const container = document.getElementById("posts");
                container.innerHTML = "";
                if(data.posts){
                    data.posts.forEach(post => {
                        const postElement = document.createElement("div");
                        postElement.classList.add("single-post");
                        postElement.setAttribute("data-id", post.id);
                        const postMoreOptionsWrapper = document.createElement("div");
                        postMoreOptionsWrapper.classList.add("post-more-options-wrapper");
                        postMoreOptionsWrapper.innerHTML = `
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>`;
                        const choosePostOption = document.createElement("div");
                        choosePostOption.classList.add("choose-post-option");
                        choosePostOption.innerHTML = `  <div class="single-post-option block-user" data-id="${post.user.id}" data-username="${post.user.username}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;${post.user.username}`;
                        if(post.user.loggedInUserFollowing){
                            choosePostOption.innerHTML += `<div class="single-post-option unfollow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;${post.user.username}</div>`;
                        }
                        else {
                            choosePostOption.innerHTML += `<div class="single-post-option follow-user" data-id="${post.user.id}" data-username="${post.user.username}"><i class="fa-solid fa-user-plus"></i> Follow &#64;${post.user.username}</div>`;
                        }
                        postMoreOptionsWrapper.appendChild(choosePostOption);
                        postElement.appendChild(postMoreOptionsWrapper);
                        postElement.innerHTML += `
                        <a href="${post.user.profile_link}"><img src="${post.user.photo}" loading="eager" alt="" class="user-image" /></a>`;
                        let postInfoAndBody = document.createElement("div");
                        postInfoAndBody.classList.add("post-info-and-body");
                        postInfoAndBody.innerHTML = `<div class="post-info">
                                <a href="${post.user.profile_link}" class="posted-by-fullname">${post.user.full_name}</a>
                                <a href="${post.user.profile_link}" class="posted-by-username">&#64;${post.user.username}</a>
                                <div class="dot">·</div>
                                <div class="posted-on-date-text">${post.created_at}</div>
                            </div>`;
                        let postBody = document.createElement("div");
                        postBody.classList.add("post-body");
                        if(post.content){
                            let regex = /#(\w+)/g;
                            let content = post.content.replace(regex, '<span class="hashtag">#$1</span>');
                            postBody.innerHTML += `<p class="post-body-text">${content}</p>`;
                        }
                        if(post.image){
                            postBody.innerHTML += `<img
                                    src="${post.image}"
                                    loading="lazy"
                                    sizes="100vw"
                                    alt=""
                                    class="post-image"
                            />`;
                        }
                        postInfoAndBody.appendChild(postBody);
                        postInfoAndBody.innerHTML += `
                            <div class="post-reactions">
                                <div class="post-comment-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="fa-regular fa-comment post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.number_of_comments > 0 ? post.number_of_comments : ""}</div>
                                </div>
                                <div class="post-reposted-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_reposted ? "repostedPost" : ""} fa-solid fa-retweet post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_reposted ? "repostedPost" : ""}">${post.number_of_reposts > 0 ? post.number_of_reposts : ""}</div>
                                </div>
                                <div class="post-likes-stats">
                                    <div class="post-stats-icon" data-id="${post.id}">
                                        <i class="${post.user_liked ? "fa-solid likedPost" : "fa-regular"} fa-heart post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text ${post.user_liked ? "likedPost" : ""}">${post.number_of_likes > 0 ? post.number_of_likes : ""}</div>
                                </div>
                                <div class="post-views-stats">
                                    <div class="post-stats-icon">
                                        <i class="fa-solid fa-chart-simple post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">${post.views > 0 ? post.views : ''}</div>
                                </div>
                            </div>
                `;
                        postElement.innerHTML += postInfoAndBody.outerHTML;
                        container.appendChild(postElement);
                    });
                }
                offset = 10;
                isFetching = false;
                observePosts();
            }
        });
    })
}

