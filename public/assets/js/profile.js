const postMoreOptions = document.querySelectorAll(".post-more-options");
postMoreOptions.forEach(postMoreOption => {
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
const deletePostBtns = document.querySelectorAll(".delete-post");
deletePostBtns.forEach(deletePostBtn => {
    deletePostBtn.addEventListener("click", function () {
        const postId = this.getAttribute("data-id");
        $.ajax({
            url: "/posts/" + postId,
            type: "DELETE",
            success: function(){
                deletePostBtn.parentElement.parentElement.parentElement.remove();
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
    })
});
document.addEventListener("click", function (event) {
    if(!event.target.classList.contains("more-opt-ic")){
        document.querySelectorAll(".choose-post-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
    }
});