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
    if(event.target.className === "unfollowUserPopupBtn"){
        let userId = event.target.getAttribute("data-id");
        let username = event.target.getAttribute("data-username");
        $.ajax({
            url: `/users/${userId}/unfollow`,
            type: "POST",
            success: function(data){
                let followingBtn = document.querySelector(`.followingBtn[data-id="${userId}"]`);
                let actionPopupWrapper = document.querySelector("#action-popup-wrapper");
                if(data.followBack){
                    followingBtn.className = "followBackBtn";
                    followingBtn.textContent = "Follow back";
                    followingBtn.dataset.id = userId;
                }else{
                    followingBtn.className = "followBtn";
                    followingBtn.textContent = "Follow";
                    followingBtn.dataset.id = userId;
                }
                let unFollowUserBtns = document.querySelectorAll(`.unfollow-user[data-id="${userId}"]`);
                if(unFollowUserBtns){
                    unFollowUserBtns.forEach(unFollowUserBtn => {
                        unFollowUserBtn.classList.remove("unfollow-user");
                        unFollowUserBtn.classList.add("follow-user");
                        unFollowUserBtn.innerHTML = `<i class="fa-solid fa-user-xmark"></i> Follow @${username}`;
                    })
                }
                actionPopupWrapper.style.display = "none";
                document.body.style.overflow = "auto";
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.className === "unfollowBtn"){
        const userId = event.target.getAttribute("data-id");
        const username = event.target.getAttribute("data-username");
        const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        const confirmUnfollow = document.querySelector("#doActionBtn");
        confirmUnfollow.className = "unfollowUserPopupBtn";
        confirmUnfollow.textContent = "Unfollow";
        confirmUnfollow.setAttribute("data-id", userId);
        confirmUnfollow.setAttribute("data-username", username);
        let popupHeading = document.querySelector("#action-popup-wrapper h3");
        popupHeading.textContent = `Unfollow @${username}?`;
        let popupText = document.querySelector("#action-popup-wrapper p");
        popupText.textContent = `Their posts will no longer show up in your For You timeline. You can still view their profile, unless their posts are protected.`;
        actionPopupWrapper.style.display = "block";
        document.body.style.overflow = "hidden";

    }
    if(event.target.className === "followBtn"){
        let userId = event.target.getAttribute("data-id");
        let username = event.target.getAttribute("data-username");
        $.ajax({
            url: `/users/${userId}/follow`,
            type: "POST",
            success: function(){
                event.target.className = "followingBtn";
                event.target.textContent = "Following";
                event.target.dataset.id = userId;
                let followUserBtns = document.querySelectorAll(`.follow-user[data-id="${userId}"]`);
                if(followUserBtns){
                    followUserBtns.forEach(followUserBtn => {
                        followUserBtn.classList.remove("follow-user");
                        followUserBtn.classList.add("unfollow-user");
                        followUserBtn.innerHTML = `<i class="fa-solid fa-user-xmark"></i> Unfollow @${username}`;
                    })
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.className === "followBackBtn"){
        let userId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/users/${userId}/follow`,
            type: "POST",
            success: function(){
                event.target.className = "followingBtn";
                event.target.textContent = "Following";
                event.target.dataset.id = userId;
            },
            error: function(err){
                console.log(err);
            }
        })
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
                let singleResultUser = document.querySelector(`.single-result-user[data-id="${userId}"]`);
                if(singleResultUser){
                    let followBtn = singleResultUser.querySelector(".followBtn");
                    followBtn.className = "followingBtn";
                    followBtn.textContent = "Following";
                    followBtn.dataset.id = userId;
                }
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
            success: function(data){
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
                let singleResultUser = document.querySelector(`.single-result-user[data-id="${userId}"]`);
                if(singleResultUser){
                    let followingBtn = singleResultUser.querySelector(".followingBtn");
                    if(data.followBack){
                        followingBtn.className = "followBackBtn";
                        followingBtn.textContent = "Follow back";
                        followingBtn.dataset.id = userId;
                    }else{
                        followingBtn.className = "followBtn";
                        followingBtn.textContent = "Follow";
                        followingBtn.dataset.id = userId;
                    }
                }
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
})
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

    let singleResultUsers = document.querySelectorAll(".single-result-user");
if(singleResultUsers){
    singleResultUsers.forEach(singleResultUser => {
        singleResultUser.addEventListener("click", function (event){
            if(event.target.className === "unfollowBtn" || event.target.className === "followBackBtn" || event.target.className === "followBtn"){
                event.preventDefault();
            }
        })
    })
}
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
const searchInput = document.getElementById("Search");
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault();
});
let searchDiv = document.querySelector(".search-div");
searchInput.addEventListener("focus", () => {
    searchDiv.style.border = "2px solid rgb(29, 155, 240)";
})
searchInput.addEventListener("blur", () => {
    searchDiv.style.border = "2px solid #88888880";
})
searchInput.addEventListener("input", (event) => {
    if(searchInput.value.length > 1){
        event.preventDefault();
        $.ajax({
            url: "/search",
            type: "GET",
            data: {
                search: searchInput.value
            },
            success: function(data){
                const searchWrapper = document.querySelector(".search-wrapper");
                let searchResults = document.querySelector(".search-results");
                if (!searchResults) {
                    searchResults = document.createElement("div");
                    searchResults.classList.add("search-results");
                    searchWrapper.appendChild(searchResults);
                } else {
                    searchResults.innerHTML = "";
                }
                searchResults.innerHTML += `
                  <a href="${data.searchPage}?q=${encodeURIComponent(searchInput.value)}" id="searchByWord">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <p>${searchInput.value}</p>
                  </a>
                `;
                data.users.forEach((user) => {
                    searchResults.innerHTML += `
                    <a class="single-search-result" href="${user.profile_url}">
                        <img src="${user.photo}" loading="lazy" alt="" class="search-result-user-image" />
                            <div class="search-result-user-info">
                                <div class="search-result-user-fullname">${user.full_name}</div>
                                <div class="search-result-user-username">@${user.username}</div>
                            </div>
                    </a>`;
                })
            },
            error: function(err){
                console.log(err)
            }
        })
    }
    else {
        let searchResults = document.querySelector(".search-results");
        if (searchResults) {
            if (searchResults) {
                searchResults.remove();
            }
        }
    }
})
document.addEventListener("mouseover", function (event){
    if(event.target.className === "followingBtn"){
        event.target.textContent = "Unfollow";
        event.target.className = "unfollowBtn";
    }
})
document.addEventListener("mouseout", function (event){
    if(event.target.className === "unfollowBtn"){
        event.target.textContent = "Following";
        event.target.className = "followingBtn";
    }
})