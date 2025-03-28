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
document.addEventListener("click", function (event){
    if(event.target.className === "unfollowBtn"){
        let userId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/users/${userId}/unfollow`,
            type: "POST",
            success: function(data){
                if(data.followBack){
                    event.target.className = "followBackBtn";
                    event.target.textContent = "Follow back";
                    event.target.dataset.id = userId;
                }else{
                    event.target.className = "followBtn";
                    event.target.textContent = "Follow";
                    event.target.dataset.id = userId;
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.className === "followBtn"){
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
    if (event.target.parentElement.classList.contains("single-follower-more-options")) {
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-follower-option");
        if(chooseOption.style.display === "block"){
            chooseOption.style.display = "none";
        }
        else{
            chooseOption.style.display = "block";
        }
    }
    if(!event.target.classList.contains("more-opt-ic")){
        document.querySelectorAll(".choose-follower-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
    }
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
                    blockUserBtn.parentElement.parentElement.parentElement.parentElement.remove();
                },
                error: function(err){
                    console.log(err);
                }
            })
        })
    });
}