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
    if(event.target.parentElement.classList.contains("single-follower-more-options")) {
        const allChooseOptions = document.querySelectorAll(".choose-follower-option");
        allChooseOptions.forEach(chooseOption => {
            if(chooseOption.style.display === "block"){
                chooseOption.style.display = "none";
            }
        })
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
    if(event.target.className === "unfollowUserPopupBtn"){
        let userId = event.target.getAttribute("data-id");
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
        let chooseOptionsWrapper = document.querySelector("#chooseOptionsWrapper");
        chooseOptionsWrapper.style.display = "none";
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
let singleFollowingUsers = document.querySelectorAll(".single-following-user");
let singleFollowerUsers = document.querySelectorAll(".single-follower-user");
if(singleFollowerUsers){
    singleFollowerUsers.forEach(singleFollowerUser => {
        singleFollowerUser.addEventListener("click", function (event){
            console.log(event.target.className)
            if(event.target.className === "unfollowBtn" || event.target.className === "followBackBtn" || event.target.classList.contains("more-opt-ic") || event.target.classList.contains("remove-user-from-followers") || event.target.classList.contains("block-user")){
                event.preventDefault();
            }
        })
    })
}
if(singleFollowingUsers){
    singleFollowingUsers.forEach(singleFollowingUser => {
        singleFollowingUser.addEventListener("click", function (event){
            if(event.target.className === "unfollowBtn" || event.target.className === "followBackBtn"){
                event.preventDefault();
            }
        })
    })

}