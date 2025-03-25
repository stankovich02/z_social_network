document.addEventListener("click", function (event) {
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
    if (event.target.parentElement.classList.contains("post-more-options")) {
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-post-option");

        chooseOption.style.display = (chooseOption.style.display === "block") ? "none" : "block";
    }
    if (event.target.classList.contains("delete-post")) {
        const postId = event.target.getAttribute("data-id");
        const deletePopupWrapper = document.querySelector("#delete-wrapper");
        const confirmDelete = document.querySelector("#confirmDelete");
        const cancelDelete = document.querySelector("#cancelDelete");
        deletePopupWrapper.style.display = "block";
        document.body.style.overflow = "hidden";
        confirmDelete.addEventListener("click", function () {
            $.ajax({
                url: "/posts/" + postId,
                type: "DELETE",
                success: function(){
                    event.target.parentElement.parentElement.parentElement.remove();
                    let numOfPosts = document.querySelector(".num-of-posts");
                    let numOfPostsText = numOfPosts.textContent;
                    let numOfPostsArr = numOfPostsText.split(" ");
                    let numOfPostsNum = parseInt(numOfPostsArr[0]);
                    numOfPostsNum--;
                    if(numOfPostsNum === 1){
                        numOfPosts.textContent = numOfPostsNum + " post";
                    }
                    else{
                        numOfPosts.textContent = numOfPostsNum + " posts";
                    }
                    deletePopupWrapper.style.display = "none";
                    document.body.style.overflow = "auto";
                    let newPostMessage = document.createElement('div')
                    newPostMessage.id = "deleted-message";
                    newPostMessage.innerHTML = `<p>Your post was deleted</p>`;
                    document.body.appendChild(newPostMessage);
                    setTimeout(function (){
                        newPostMessage.classList.add('show-deleted-message');
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
            deletePopupWrapper.style.display = "none";
            document.body.style.overflow = "auto";
        })
    }
    if(event.target.parentElement.parentElement.classList.contains("post-likes-stats")){
        let icon = event.target;
        let postId = icon.parentElement.getAttribute("data-id");
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
                    icon.classList.add("fa-regular");
                    postLikesStats.classList.remove("likedPost");
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
                if(document.querySelector("#posts") && !window.location.href.includes("home")){
                    location.reload();
                }
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
                    commentContentDiv.className = "comment-body";
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
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#newCommentTextArea").addEventListener("keyup", function () {
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
                newCommentMessage.id = "new-comment-message";
                newCommentMessage.innerHTML = `<p>Your comment was sent.</p><a href="${data.post_link}">View</a>`;
                localStorage.setItem('commentID', data.comment_id);
                document.body.appendChild(newCommentMessage);
                setTimeout(function (){
                    newCommentMessage.classList.add('show-new-comment-message');
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
})

if(document.querySelector(".block-user")){
    let blockUserBtns = document.querySelectorAll(".block-user");
    blockUserBtns.forEach(blockUserBtn => {
        blockUserBtn.addEventListener("click", function (){
            const userId = this.getAttribute("data-id");
            $.ajax({
                url: "/users/block",
                type: "POST",
                data: {
                    user_id: userId
                },
                success: function(){
                    let returnBackLink = document.querySelector(".returnBackLink");
                    returnBackLink.click();
                },
                error: function(err){
                    console.log(err);
                }
            })
        })
    });
}