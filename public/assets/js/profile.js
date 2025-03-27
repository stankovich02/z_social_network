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

    if(event.target.id === "unfollowBtn"){
        let userId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/users/${userId}/unfollow`,
            type: "POST",
            success: function(data){
                let unfollowBtn = document.querySelector("#unfollowBtn");
                unfollowBtn.remove();
                if(data.followBack){
                    document.querySelector("#other-profile-features").innerHTML +=`<button id="followBackBtn">Follow back</button>`;
                    let followBackBtn = document.querySelector("#followBackBtn");
                    followBackBtn.dataset.id = userId;
                }else{
                    document.querySelector("#other-profile-features").innerHTML +=`<button id="followBtn">Follow</button>`;
                    let followBtn = document.querySelector("#followBtn");
                    followBtn.dataset.id = userId;
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.id === "followBtn"){
        let userId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/users/${userId}/follow`,
            type: "POST",
            success: function(){
                event.target.remove();
                document.querySelector("#other-profile-features").innerHTML +=`<button id="followingBtn">Following</button>`;
                let followingBtn = document.querySelector("#followingBtn");
                followingBtn.dataset.id = userId;
                followingBtn.addEventListener("mouseover", function (){
                    followingBtn.textContent = "Unfollow";
                    followingBtn.id = "unfollowBtn";
                })
                followingBtn.addEventListener("mouseout", function (){
                    followingBtn.textContent = "Following";
                    followingBtn.id = "followingBtn";
                })
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.id === "followBackBtn"){
        let userId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/users/${userId}/follow`,
            type: "POST",
            success: function(){
                event.target.remove();
                document.querySelector("#other-profile-features").innerHTML +=`<button id="followingBtn">Following</button>`;
                let followingBtn = document.querySelector("#followingBtn");
                followingBtn.dataset.id = userId;
                followingBtn.addEventListener("mouseover", function (){
                    followingBtn.textContent = "Unfollow";
                    followingBtn.id = "unfollowBtn";
                })
                followingBtn.addEventListener("mouseout", function (){
                    followingBtn.textContent = "Following";
                    followingBtn.id = "followingBtn";
                })
            },
            error: function(err){
                console.log(err);
            }
        })
    }
});
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
const setupProfileBtn = document.querySelector("#setupProfile");
const editProfileBtn = document.querySelector("#editProfile");
function nextBioBtnFunc(describeBio,saveProfile,popupLogo,returnBackBtn,closeIcon){
    let nextBioBtn = document.querySelector(".describe-bio .next-profile-btn");
    nextBioBtn.addEventListener("click", function (){
        let bioTextarea = document.querySelector(".describe-bio #biography");
        $.ajax({
            url: "/users/biography",
            type: "POST",
            data: {
                biography: bioTextarea.value
            },
            success: function(){
                describeBio.style.display = "none";
                saveProfile.style.display = "flex";
                popupLogo.style.display = "none";
                returnBackBtn.style.display = "none";
                closeIcon.style.display = "block";
                if(document.querySelector(".describe-bio .errorMsg")){
                    document.querySelector(".describe-bio .errorMsg").remove();
                }
                let profileBio = document.querySelector(".profile-bio");
                profileBio.textContent += bioTextarea.value;
                bioTextarea.value = "";

            },
            error: function(data){
                let describeBio = document.querySelector(".describe-bio");
                describeBio.innerHTML += `<p class="errorMsg">${data.responseJSON.error}</p>`;
                let numOfLetters = document.querySelector(".describe-bio .num-of-letters");
                numOfLetters.textContent = "0";
                typingBio();
                nextBioBtnFunc(describeBio,saveProfile,popupLogo,returnBackBtn,closeIcon);
            }
        })

    });
}
if(setupProfileBtn){
    setupProfileBtn.addEventListener("click", function (){
        const setupProfileWrapper = document.querySelector("#setupProfileWrapper");
        setupProfileWrapper.style.display = "block";
        let returnBackBtn = document.querySelector("#returnBackSetupProfile");
        let closeIcon = document.querySelector("#setupProfileWrapper .close-icon");
        let skipPictureBtn = document.querySelector(".pick-profile-picture .skip-profile-btn");
        let skipHeaderBtn = document.querySelector(".pick-header .skip-profile-btn");
        let skipBioBtn = document.querySelector(".describe-bio .skip-profile-btn");
        let pickProfilePicture = document.querySelector(".pick-profile-picture");
        let pickHeader = document.querySelector(".pick-header");
        let describeBio = document.querySelector(".describe-bio");
        let saveProfile = document.querySelector("#saveProfileDiv");
        let saveProfileBtn = document.querySelector("#saveProfileDiv .save-profile-btn");
        let popupLogo = document.querySelector("#setupProfileWrapper .top-setup-profile .popup-logo");
        let nextProfileBtn = document.querySelector(".pick-profile-picture .next-profile-btn");
        let nextHeaderBtn = document.querySelector(".pick-header .next-profile-btn");

        skipPictureBtn.addEventListener("click", function (){
            pickProfilePicture.style.display = "none";
            pickHeader.style.display = "block";
            returnBackBtn.style.display = "block";
        });
        returnBackBtn.addEventListener("click", function (){
            if(pickHeader.style.display === "block"){
                pickHeader.style.display = "none";
                pickProfilePicture.style.display = "flex";
                returnBackBtn.style.display = "none";
            }
            if(describeBio.style.display === "block"){
                describeBio.style.display = "none";
                pickHeader.style.display = "block";
            }
        })
        skipHeaderBtn.addEventListener("click", function (){
            pickHeader.style.display = "none";
            describeBio.style.display = "block";
        });
        skipBioBtn.addEventListener("click", function (){
            describeBio.style.display = "none";
            saveProfile.style.display = "flex";
            popupLogo.style.display = "none";
            returnBackBtn.style.display = "none";
            closeIcon.style.display = "block";
            if(document.querySelector(".describe-bio .errorMsg")){
                document.querySelector(".describe-bio .errorMsg").remove();
            }
        });
        closeIcon.addEventListener("click", function (){
            pickProfilePicture.style.display = "flex";
            saveProfile.style.display = "none";
            setupProfileWrapper.style.display = "none";
            closeIcon.style.display = "none";
        });
        saveProfileBtn.addEventListener("click", function (){
            pickProfilePicture.style.display = "flex";
            saveProfile.style.display = "none";
            setupProfileWrapper.style.display = "none";
            closeIcon.style.display = "none";
        });
        nextProfileBtn.addEventListener("click", function (){
            pickProfilePicture.style.display = "none";
            pickHeader.style.display = "block";
            returnBackBtn.style.display = "block";
        });
        nextHeaderBtn.addEventListener("click", function (){
            pickHeader.style.display = "none";
            describeBio.style.display = "block";
        });
        nextBioBtnFunc(describeBio,saveProfile,popupLogo,returnBackBtn,closeIcon);
    })
}
if(editProfileBtn){
    editProfileBtn.addEventListener("click", function (){
        let editProfileWrapper = document.querySelector("#editProfileWrapper");
        editProfileWrapper.style.display = "block";
        let closeIcon = document.querySelector("#editProfileWrapper .close-icon");
        closeIcon.addEventListener("click", function (){
            editProfileWrapper.style.display = "none";
        })

    });
}
function typingBio(){
    let bioTextarea= document.querySelector(".describe-bio #biography");
    bioTextarea.addEventListener("input", () => {
        let skipBioBtn = document.querySelector(".describe-bio .skip-profile-btn");
        let nextBioBtn = document.querySelector(".describe-bio .next-profile-btn");
        if(bioTextarea.value.length > 160){
            bioTextarea.parentElement.parentElement.parentElement.querySelector(".max-num-of-letters").style.color = "red";
        }
        else{
            bioTextarea.parentElement.parentElement.parentElement.querySelector(".max-num-of-letters").style.color = "#fff6";
        }
        if(bioTextarea.value.length > 0){
            skipBioBtn.style.display = "none";
            nextBioBtn.style.display = "block";
        }
        else{
            skipBioBtn.style.display = "block";
            nextBioBtn.style.display = "none";
        }
        const numOfCharacters = bioTextarea.parentElement.parentElement.parentElement.querySelector(".num-of-letters");
        numOfCharacters.innerHTML = bioTextarea.value.length;
    })
}
function editTypingFunc(){
    let currentNameInput = document.querySelector(".edit-popup .current-name-input");
    let currentBioTextarea = document.querySelector(".edit-popup .current-biography-input");
    let saveProfileBtn = document.querySelector(".edit-popup .save-edited-profile");
    let fullNameNumOfCharacters = currentNameInput.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-fullname-wrapper .num-of-characters");
    let bioNumOfCharacters = currentBioTextarea.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-bio-wrapper .num-of-characters");
    fullNameNumOfCharacters.innerHTML = currentNameInput.value.length;
    bioNumOfCharacters.innerHTML = currentBioTextarea.value.length;
    currentNameInput.addEventListener("input", () => {
        if(currentNameInput.value.length > 50){
            currentNameInput.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-fullname-wrapper .max-num-of-characters").style.color = "red";
            currentNameInput.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-fullname-wrapper .num-of-characters").style.color = "red";
        }
        else{
            currentNameInput.parentElement.parentElement.parentElement.querySelector(".max-num-of-characters").style.color = "#fff6";
            currentNameInput.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-fullname-wrapper .num-of-characters").style.color = "#fff6";
        }
        if(currentNameInput.value.length === 0 && currentBioTextarea.value.length === 0){
            saveProfileBtn.disabled = true;
            saveProfileBtn.classList.add("disabled-save-profile-btn");
        }
        else{
            saveProfileBtn.disabled = false;
            saveProfileBtn.classList.remove("disabled-save-profile-btn");
        }
        fullNameNumOfCharacters.innerHTML = currentNameInput.value.length;
    })
    currentBioTextarea.addEventListener("input", () => {
        if(currentBioTextarea.value.length > 160){
            currentBioTextarea.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-bio-wrapper .max-num-of-characters").style.color = "red";
            currentBioTextarea.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-bio-wrapper .num-of-characters").style.color = "red";
        }
        else{
            currentBioTextarea.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-bio-wrapper .max-num-of-characters").style.color = "#fff6";
            currentBioTextarea.parentElement.parentElement.parentElement.querySelector(".edit-popup .current-bio-wrapper .num-of-characters").style.color = "#fff6";
        }
        if(currentNameInput.value.length === 0 && currentBioTextarea.value.length === 0){
            saveProfileBtn.disabled = true;
            saveProfileBtn.classList.add("disabled-save-profile-btn");
        }
        else{
            saveProfileBtn.disabled = false;
            saveProfileBtn.classList.remove("disabled-save-profile-btn");
        }
        bioNumOfCharacters.innerHTML = currentBioTextarea.value.length;
    })
}
typingBio();
editTypingFunc();
let profilePictureInput = document.querySelector("#pickProfilePicture");
let addProfilePictureIcon = document.querySelector(".pick-profile-picture .add-new-photo-icon");
let editProfilePictureInput = document.querySelector("#editProfilePicture");
let editProfilePictureIcon = document.querySelector(".edit-popup .edit-profile-pic .add-new-photo-icon");
addProfilePictureIcon.addEventListener("click", function (){
    profilePictureInput.click();
});
editProfilePictureIcon.addEventListener("click",function (){
    editProfilePictureInput.click();
})
profilePictureInput.addEventListener("change", function (){
    let image = this.files[0];
    let formData = new FormData();
    formData.append("image", image);
    $.ajax({
        url: "/upload-user-image",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            let img = document.querySelector(".pick-picture-wrapper img");
            let skipProfilePictureBtn = document.querySelector(".pick-profile-picture .skip-profile-btn");
            let nextHeaderBtn = document.querySelector(".pick-profile-picture .next-profile-btn");
            let profilePicture = document.querySelector("#profile .profile-info img")
            img.src = data.newPhoto;
            profilePicture.src = data.newPhoto;
            let profilePictureInput = document.querySelector("#pickProfilePicture");
            profilePictureInput.value = "";
            let removePhotoWrapper = document.querySelector(".pick-profile-picture .remove-new-photo-wrapper")
            removePhotoWrapper.style.display = "block";
            skipProfilePictureBtn.style.display = "none";
            nextHeaderBtn.style.display = "block";
            let removePhotoIcon = document.querySelector(".pick-picture-wrapper .remove-new-photo-icon");
            removePhotoIcon.addEventListener("click", function (){
                $.ajax({
                    url: "/delete-user-image?imgPath=" + encodeURIComponent(data.newPhoto) + "&oldImgPath=" + encodeURIComponent(data.oldPhoto),
                    type: "DELETE",
                    success: function(){
                        img.src = data.oldPhoto;
                        profilePicture.src = data.oldPhoto;
                        removePhotoWrapper.style.display = "none";
                        skipProfilePictureBtn.style.display = "block";
                        nextHeaderBtn.style.display = "none";
                    },
                    error: function(err){
                        console.log(err)
                    }
                })
            })

        },
        error: function(err){
            console.log(err)
        }
    })
})
editProfilePictureInput.addEventListener("change", function (){
    let image = this.files[0];
    let formData = new FormData();
    formData.append("image", image);
    formData.append("edit", "true");
    $.ajax({
        url: "/upload-user-image",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            let img = document.querySelector(".edit-popup .edit-profile-pic img");
            img.src = data.newPhoto;
            let profilePictureInput = document.querySelector("#editProfilePicture");
            profilePictureInput.value = "";
            let removePhotoWrapper = document.querySelector(".edit-popup .edit-profile-pic .remove-new-photo-wrapper")
            removePhotoWrapper.style.display = "block";
            let removePhotoIcon = document.querySelector(".edit-popup .edit-profile-pic .remove-new-photo-icon");
            removePhotoIcon.addEventListener("click", function (){
                $.ajax({
                    url: "/delete-user-image?imgPath=" + encodeURIComponent(data.newPhoto) + "&oldImgPath=" + encodeURIComponent(data.oldPhoto) + "&edit=true",
                    type: "DELETE",
                    success: function(){
                        img.src = data.oldPhoto;
                        removePhotoWrapper.style.display = "none";
                    },
                    error: function(err){
                        console.log(err)
                    }
                })
            })
        },
        error: function(err){
            console.log(err)
        }
    })
})
let headerPictureInput = document.querySelector("#pickHeaderPicture");
let addHeaderPictureIcon = document.querySelector(".pick-header .add-new-photo-icon");
let editHeaderPictureInput = document.querySelector("#editHeaderPicture");
let editHeaderPictureIcon = document.querySelector(".edit-popup .add-new-photo-icon");
addHeaderPictureIcon.addEventListener("click", function (){
    headerPictureInput.click();
});
editHeaderPictureIcon.addEventListener("click", function (){
    editHeaderPictureInput.click();
})
editHeaderPictureInput.addEventListener("change", function (){
    let image = this.files[0];
    let formData = new FormData();
    formData.append("image", image);
    formData.append("edit", "true");
    $.ajax({
        url: "/upload-cover-image",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            let img = document.querySelector(".edit-popup .pick-header-img-wrapper .pick-header-img");
            img.style.backgroundImage = `url(${data.newPhoto})`;
            let coverPictureInput = document.querySelector("#editHeaderPicture");
            coverPictureInput.value = "";
            let removePhotoWrapper = document.querySelector(".edit-popup .pick-header-img-wrapper .remove-new-photo-wrapper")
            removePhotoWrapper.style.display = "block";
            let removePhotoIcon = document.querySelector(".edit-popup .pick-header-img-wrapper .remove-new-photo-icon");
            removePhotoIcon.addEventListener("click", function (){
                $.ajax({
                    url: "/delete-cover-image?imgPath=" + encodeURIComponent(data.newPhoto) + "&oldImgPath=" + encodeURIComponent(data.oldPhoto) + "&edit=true",
                    type: "DELETE",
                    success: function(){
                        img.style.backgroundImage = `url(${data.oldPhoto})`;
                        removePhotoWrapper.style.display = "none";
                    },
                    error: function(err){
                        console.log(err)
                    }
                })
            })

        },
        error: function(err){
            console.log(err)
        }
    })
})
headerPictureInput.addEventListener("change", function (){
    let image = this.files[0];
    let formData = new FormData();
    formData.append("image", image);
    $.ajax({
        url: "/upload-cover-image",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            let img = document.querySelector("#setupProfileWrapper .pick-header-img-wrapper .pick-header-img");
            let skipCoverPictureBtn = document.querySelector(".pick-header .skip-profile-btn");
            let nextBioBtn = document.querySelector(".pick-header .next-profile-btn");
            let profileCover = document.querySelector("#profile .profile-banner")
            img.style.backgroundImage = `url(${data.newPhoto})`;
            profileCover.style.backgroundImage = `url(${data.newPhoto})`;
            let coverPictureInput = document.querySelector("#pickHeaderPicture");
            coverPictureInput.value = "";
            let removePhotoWrapper = document.querySelector(".pick-header .remove-new-photo-wrapper")
            removePhotoWrapper.style.display = "block";
            skipCoverPictureBtn.style.display = "none";
            nextBioBtn.style.display = "block";
            let removePhotoIcon = document.querySelector(".pick-header .remove-new-photo-icon");
            removePhotoIcon.addEventListener("click", function (){
                $.ajax({
                    url: "/delete-cover-image?imgPath=" + encodeURIComponent(data.newPhoto) + "&oldImgPath=" + encodeURIComponent(data.oldPhoto),
                    type: "DELETE",
                    success: function(){
                        img.style.backgroundImage = `url(${data.oldPhoto})`;
                        profileCover.style.backgroundImage = `url(${data.oldPhoto})`;
                        removePhotoWrapper.style.display = "none";
                        skipCoverPictureBtn.style.display = "block";
                        nextBioBtn.style.display = "none";
                    },
                    error: function(err){
                        console.log(err)
                    }
                })
            })

        },
        error: function(err){
            console.log(err)
        }
    })
})

let saveEditeProfileBtn = document.querySelector(".edit-popup .save-edited-profile");
saveEditeProfileBtn.addEventListener("click", function (){
    let userId = this.getAttribute("data-id");
    let coverImage = document.querySelector(".edit-popup .pick-header-img-wrapper .pick-header-img");
    coverImage = coverImage.style.backgroundImage.slice(5, -2);
    let profileImage = document.querySelector(".edit-popup .edit-profile-pic img").src;
    let fullName = document.querySelector(".edit-popup .current-name-input").value;
    let biography = document.querySelector(".edit-popup .current-biography-input").value;
    $.ajax({
        url: `/users/${userId}/update`,
        type: "PATCH",
        contentType: "application/json",
        data: JSON.stringify({
            coverImage: coverImage,
            profileImage: profileImage,
            fullName: fullName,
            biography: biography
        }),
        success: function(data){
            let editProfilePopupWrapper = document.querySelector("#editProfileWrapper");
            let coverPicture = document.querySelector("#profile .profile-banner");
            let profilePicture = document.querySelector("#profile .profile-info img");
            let profileFullName = document.querySelector("#profile .profile-fullname");
            let biography = document.querySelector("#profile .profile-bio");
            let loggedInImg = document.querySelector(".left-bar-menu .logged-in-user img");
            let loggedInFullName = document.querySelector(".left-bar-menu .logged-in-user .user-fullname");
            let topFullNameText = document.querySelector(".top-fullname-text");
            let removeCoverPhotoWrapper = document.querySelector(".edit-popup .pick-header-img-wrapper .remove-new-photo-wrapper");
            let removeProfilePictureWrapper = document.querySelector(".edit-popup .edit-profile-pic .remove-new-photo-wrapper");
            let allPostsFullNames = document.querySelectorAll(".post-info-and-body .posted-by-fullname");
            let loggedOutFullName = document.querySelector("#logout-text #logged-user-fullname");
            coverPicture.style.backgroundImage = `url(${data.coverImage})`;
            profilePicture.src = data.profileImage;
            profileFullName.textContent = data.fullName;
            topFullNameText.textContent = data.fullName;
            loggedOutFullName.textContent = data.fullName;
            biography.textContent = data.biography;
            loggedInImg.src = data.profileImage;
            loggedInFullName.textContent = data.fullName;
            allPostsFullNames.forEach(fullName => {
                if(!fullName.parentElement.parentElement.parentElement.classList.contains("reposted-post")){
                    fullName.textContent = data.fullName;
                }
                else{
                    let repostedPost = fullName.parentElement.parentElement.parentElement;
                    if(repostedPost.querySelector(".reposted-info strong").textContent === "You"){
                        fullName.textContent = data.fullName;
                    }
                }
            })
            if(document.querySelector(".edit-popup #editFullNameError")){
                document.querySelector(".edit-popup #editFullNameError").textContent = "";
            }
            if(document.querySelector(".edit-popup #editError")){
                document.querySelector(".edit-popup #editError").textContent = "";
            }
            if(removeCoverPhotoWrapper.style.display === "block"){
                removeCoverPhotoWrapper.style.display = "none";
            }
            if(removeProfilePictureWrapper.style.display === "block"){
                removeProfilePictureWrapper.style.display = "none";
            }
            editProfilePopupWrapper.style.display = "none";
        },
        error: function(data){
            if(data.responseJSON.fullNameError){
                let fullNameError = document.querySelector(".edit-popup #editFullNameError");
                fullNameError.textContent = data.responseJSON.fullNameError;
            }
            if(data.responseJSON.editError){
                let editError = document.querySelector(".edit-popup #editError");
                editError.textContent = data.responseJSON.editError;
            }
        }
    })
})

let editNameInput = document.querySelector(".edit-popup .current-name-input");
let editBioTextarea = document.querySelector(".edit-popup .current-biography-input");
let setupBioTextarea = document.querySelector(".describe-bio #biography");
editNameInput.addEventListener("focus", function (){
    let editFullNameWrapper = document.querySelector(".edit-popup .current-fullname-wrapper");
    editFullNameWrapper.style.border = "2px solid #009dff";
})
editNameInput.addEventListener("blur", function (){
    let editFullNameWrapper = document.querySelector(".edit-popup .current-fullname-wrapper");
    editFullNameWrapper.style.border = "1px solid #88888880";
})
editBioTextarea.addEventListener("focus", function (){
    let editBioWrapper = document.querySelector(".edit-popup .current-bio-wrapper");
    editBioWrapper.style.border = "2px solid #009dff";
})
editBioTextarea.addEventListener("blur", function (){
    let editBioWrapper = document.querySelector(".edit-popup .current-bio-wrapper");
    editBioWrapper.style.border = "1px solid #88888880";
})
setupBioTextarea.addEventListener("focus", function (){
    let describeBioWrapper = document.querySelector("#setupProfileWrapper .bio-text");
    describeBioWrapper.style.border = "2px solid #009dff";
})
setupBioTextarea.addEventListener("blur", function (){
    let describeBioWrapper = document.querySelector("#setupProfileWrapper .bio-text");
    describeBioWrapper.style.border = "1px solid #88888880";
})
let followingBtn = document.querySelector("#followingBtn");
followingBtn.addEventListener("mouseover", function (){
    followingBtn.textContent = "Unfollow";
    followingBtn.id = "unfollowBtn";
})
followingBtn.addEventListener("mouseout", function (){
    followingBtn.textContent = "Following";
    followingBtn.id = "followingBtn";
})

