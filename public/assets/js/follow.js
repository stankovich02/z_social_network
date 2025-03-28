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
    if(event.target.className === "blockUserPopupBtn"){
        let userId = event.target.getAttribute("data-id");
        let blockUserBtn = document.querySelector(`.block-user[data-id="${userId}"]`);
        let actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        $.ajax({
            url: `/users/${userId}/block`,
            type: "POST",
            success: function(){
                blockUserBtn.parentElement.parentElement.parentElement.parentElement.remove();
                actionPopupWrapper.style.display = "none";
                document.body.style.overflow = "auto";
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.className === "removeFollowerPopupBtn"){
        let userId = event.target.getAttribute("data-id");
        let removeBtn = document.querySelector(`.remove-user-from-followers[data-id="${userId}"]`);
        let actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        $.ajax({
            url: `/users/${userId}/unfollow`,
            type: "POST",
            data: {
                "removed_follower": true
            },
            success: function(){
                removeBtn.parentElement.parentElement.parentElement.parentElement.remove();
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
})
if(document.querySelector(".block-user")){
    let blockUserBtns = document.querySelectorAll(".block-user");
    blockUserBtns.forEach(blockUserBtn => {
        blockUserBtn.addEventListener("click", function (){
            const userId = this.getAttribute("data-id");
            const username = this.getAttribute("data-username");
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
        });
    })
}
if(document.querySelector(".remove-user-from-followers")){
    let removeUserFromFollowersBtns = document.querySelectorAll(".remove-user-from-followers");
    removeUserFromFollowersBtns.forEach(removeBtn => {
        removeBtn.addEventListener("click", function (){
            const userId = this.getAttribute("data-id");
            const username = this.getAttribute("data-username");
            const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
            const confirmRemove = document.querySelector("#doActionBtn");
            confirmRemove.className = "removeFollowerPopupBtn";
            confirmRemove.textContent = "Remove";
            confirmRemove.setAttribute("data-id", userId);
            let popupHeading = document.querySelector("#action-popup-wrapper h3");
            popupHeading.textContent = "Remove this follower?";
            let popupText = document.querySelector("#action-popup-wrapper p");
            popupText.textContent = `@${username} will be removed from your followers and won’t be notified by Z. They can follow you again in the future.`;
            actionPopupWrapper.style.display = "block";
            document.body.style.overflow = "hidden";
        })
    });
}
