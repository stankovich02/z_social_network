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
                if(icon.classList.contains("fa-regular")){
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                    icon.classList.add("likedPost");
                }
                else{
                    icon.classList.remove("fa-solid");
                    icon.classList.remove("likedPost");
                    icon.classList.add("fa-regular");
                }
                let postLikesStats = event.target.parentElement.parentElement.querySelector(".post-reaction-stats-text");
                postLikesStats.textContent = data.likes > 0 ? data.likes : "";
            },
        })
    }
});