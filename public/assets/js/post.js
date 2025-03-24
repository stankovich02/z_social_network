document.querySelector(".new-comment-text").addEventListener("keyup", function () {
    const postBtn = document.querySelector(".reply-comment");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-comment") : postBtn.classList.remove("disabled-new-comment");
});
document.addEventListener("click", function (event) {
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