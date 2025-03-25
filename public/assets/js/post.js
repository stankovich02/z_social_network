document.querySelector(".new-comment-text").addEventListener("keyup", function () {
    const postBtn = document.querySelector(".reply-comment");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-comment") : postBtn.classList.remove("disabled-new-comment");
});
document.addEventListener("click", function (event) {
    if (event.target.parentElement.classList.contains("comment-more-options")) {
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-comment-option");
        if(chooseOption.style.display === "block"){
            chooseOption.style.display = "none";
        }
        else{
            chooseOption.style.display = "block";
        }
    }
    if(!event.target.classList.contains("more-opt-ic")){
        document.querySelectorAll(".choose-comment-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
    }
    if (event.target.classList.contains("delete-comment")) {
        const commentId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/posts/${commentId}/comment`,
            type: "DELETE",
            success: function(){
                event.target.parentElement.parentElement.parentElement.remove();
            },
            error: function(err){
                console.log(err);
            }
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
                    let repostedInfoDiv = document.querySelector(`.reposted-info`);
                    repostedInfoDiv.remove();
                }
                else{
                    icon.classList.add("repostedPost");
                    postRepostedStats.classList.add("repostedPost");
                    let repostedInfoDiv = document.createElement("div");
                    repostedInfoDiv.classList.add("reposted-info");
                    repostedInfoDiv.innerHTML = `<div class="icon-embed-xsmall-7 w-embed">
                                                    <i class="fa-solid fa-retweet"></i>
                                                 </div>
                                                 <div><strong>You</strong> reposted</div>`;
                    let singlePostInfoDiv = document.querySelector(`#single-post-info`);
                    singlePostInfoDiv.insertAdjacentHTML('afterbegin', repostedInfoDiv.outerHTML);

                }

                postRepostedStats.textContent = data.reposts > 0 ? data.reposts : "";
            },
        })
    }
})
document.querySelector("#postReplyComment").addEventListener("click", function(){
    const textArea = document.querySelector(".new-comment-wrapper .new-comment-text");
    const comment = textArea.value;
    const postId = this.getAttribute("data-id");
    let button = this;
    $.ajax({
        url: `/posts/${postId}/comment`,
        type: "POST",
        data: {
            comment: comment,
            singlePost: true
        },
        success: function(comment){
            textArea.value = '';
            button.disabled = true;
            button.classList.add("disabled-new-comment");
            let singleComment = document.createElement("div");
            singleComment.classList.add("single-comment");
            singleComment.innerHTML = `
             <div class="comment-more-options-wrapper">
                    <div class="more-options w-embed comment-more-options">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                            <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                        </svg>
                    </div>
                    <div class="choose-comment-option">
                            <div class="single-comment-option delete-comment" data-id="${comment.id}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                    </div>
            </div>
            <img src='${comment.user.photo}' loading="eager" alt="" class="user-image" />
                <div class="comment-info">
                    <div class="comment-user-info">
                     <div class="commented-by-fullname">${comment.user.full_name}</div>
                        <div class="commented-by-username">@${comment.user.username}</div>
                        <div class="dot">·</div>
                        <div class="commented-on-date-text">${comment.created_at}</div>
                    </div>
                    <div class="comment-body">${comment.content}</div>
                    <div class="comment-reactions">
                        <div class="comments-on-comment-stats">
                            <div class="comment-stats-icon w-embed">
                                <i class="fa-regular fa-comment post-ic"></i>
                            </div>
                            <div class="comment-rections-stats-num"></div>
                        </div>
                        <div class="liked-on-comment-stats">
                            <div class="comment-stats-icon w-embed">
                                <i class="fa-regular fa-heart post-ic"></i>
                            </div>
                            <div class="comment-rections-stats-num"></div>
                        </div>
                    </div>
                </div>
            `;
            let otherComments = document.querySelector(".other-comments");
            otherComments.insertAdjacentHTML('afterbegin', singleComment.outerHTML);
        },
        error: function(err){
            console.log(err);
        }
    })
});

const blockUserBtns = document.querySelectorAll(".block-user");
blockUserBtns.forEach(blockUserBtn => {
    blockUserBtn.addEventListener("click", function () {
        const userId = this.getAttribute("data-id");
        $.ajax({
            url: "/users/block",
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