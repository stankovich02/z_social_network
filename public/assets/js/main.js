const postBtn = document.querySelector(".post-btn");
postBtn.addEventListener("click", () => {
    const newPostPopup = document.querySelector("#new-post-popup-wrapper");
    newPostPopup.style.display = "block";
    document.body.style.overflow = "hidden";
    const closeIcon = document.querySelector(".close-new-post");
    closeIcon.addEventListener("click", () => {
       newPostPopup.style.display = "none";
        document.body.style.overflow = "auto";
    })

})

const textareas = document.querySelectorAll('textarea');
textareas.forEach(textarea => {
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
})
const loggedInUserInfo = document.querySelector(".logged-in-user");
loggedInUserInfo.addEventListener("click", () => {
    const logoutWrapper = document.querySelector("#logout-wrapper");
    if(logoutWrapper.style.display === "flex"){
        logoutWrapper.style.display = "none";
    }
    else{
        logoutWrapper.style.display = "flex";
    }
})
document.addEventListener("click", function (event) {
    const loggedInUserInfo = document.querySelector(".logged-in-user");
    const logoutWrapper = document.querySelector("#logout-wrapper");
    if (!loggedInUserInfo.contains(event.target)) {
        logoutWrapper.style.display = "none";
    }
    if(event.target.parentElement.classList.contains("close-icon")){
        let popup = document.querySelectorAll(".popup-wrapper");
        popup.forEach(popup => {
            popup.style.display = "none";
            document.body.style.overflow = "auto";
        })
        if(document.querySelector("#newCommentTextArea")){
            document.querySelector("#newCommentTextArea").value = "";
        }
        if(document.querySelector(".search-people-chat-input")){
            document.querySelector(".search-people-chat-input").value = "";
        }

    }
});
function writeInputAndIcon(){
    let form = document.querySelector(".new-post-popup-create form");
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "fileInput";
    fileInput.name = "post-image";
    fileInput.classList.add("hidden-file-input");
    form.appendChild(fileInput);
    let postEmojiImage = document.querySelector("#new-post-popup-wrapper #postEmojiImagePick");
    let uploadPostImage = document.createElement("div");
    uploadPostImage.classList.add("upload-post-image");
    uploadPostImage.classList.add("w-embed");
    uploadPostImage.classList.add("icon-embed-xsmall");
    uploadPostImage.innerHTML = `<i class="fa-regular fa-image"></i>`;
    postEmojiImage.appendChild(uploadPostImage);
}
function newPostLogic(){
    document.querySelector(".new-post-popup-create .upload-post-image").addEventListener("click", function () {
        document.querySelector(".new-post-popup-create #fileInput").click();
    });

    document.querySelector(".new-post-popup-create #fileInput").addEventListener("change", function () {
        let image = this.files[0];
        let formData = new FormData();
        formData.append("image", image);
        $.ajax({
            url: "/upload-post-image",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function(imgPath){
                const FormBlock = document.querySelector("#popupFormBlock");
                let uploadedPostImageDiv = document.createElement('div');
                uploadedPostImageDiv.classList.add("uploaded-post-image");
                let img = document.createElement("img");
                img.src = imgPath;
                uploadedPostImageDiv.appendChild(img);
                let removePhotoDiv = document.createElement("div");
                removePhotoDiv.classList.add("remove-photo");
                removePhotoDiv.classList.add("w-embed");
                removePhotoDiv.innerHTML = `
         <svg
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--ic"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"></path>
                        </svg>

        `;
                uploadedPostImageDiv.appendChild(removePhotoDiv);
                FormBlock.appendChild(uploadedPostImageDiv);
                let uploadPostImage = document.querySelector(".new-post-popup-create .upload-post-image");
                let fileInput = document.querySelector(".new-post-popup-create #fileInput");
                fileInput.remove();
                uploadPostImage.remove();
                let postOptions = document.querySelector(".new-post-popup-create .post-options");
                postOptions.style.justifyContent = "space-between";
                const removePhotoIcon = document.querySelector(".new-post-popup-create .remove-photo");
                const postBtn = document.querySelector("#popupPostBtn");
                removePhotoIcon.addEventListener("click", function () {
                    $.ajax({
                        url: "/delete-post-image?imgPath=" + encodeURIComponent(imgPath),
                        type: "DELETE",
                        success: function(){
                            uploadedPostImageDiv.remove();
                            writeInputAndIcon();
                            let textArea = document.querySelector("#post-body-2");
                            if(textArea.value.trim() === ""){
                                postBtn.classList.add("disabled-new-post-btn");
                                postBtn.disabled = true;
                            }
                            newPostLogic();
                        },
                        error: function(err){
                            console.log(err)
                        }
                    })
                })
                postBtn.classList.contains("disabled-new-post-btn") ? postBtn.classList.remove("disabled-new-post-btn") : null;
                postBtn.disabled ? postBtn.disabled = false : null;
            },
            error: function(err){
                console.log(err)
            }
        })
    });
}
function sendPost(){
    document.querySelector("#popupPostBtn").addEventListener("click",function (){
        const textarea = document.querySelector("#post-body-2");
        const addedImage = document.querySelector("#popupFormBlock .uploaded-post-image img");
        $.ajax({
            url: '/posts',
            type: 'POST',
            data: {
                content: textarea.value,
                image: addedImage ? addedImage.src : null
            },
            success: function (post){
                textarea.value = "";
                addedImage ? addedImage.parentElement.remove() : null;
                if(document.querySelector("#posts")){
                    const postsSection = document.querySelector("#posts");
                    let newPostHtml = `
                    <div class="single-post" data-id="${post.id}">
                    <div class="post-more-options-wrapper">
                        <div class="more-options w-embed post-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-post-option">
                                <div class="single-post-option delete-post" data-id="${post.id}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                        </div>
                    </div>
            <img src="${post.user.photo}" loading="eager" alt="" class="user-image" />
            <div class="post-info-and-body">
                <div class="post-info">
                    <div class="posted-by-fullname">${post.user.full_name}</div>
                    <div class="posted-by-username">@${post.user.username}</div>
                    <div class="dot">·</div>
                    <div class="posted-on-date-text">now</div>
                </div>
                <div class="post-body"><p class="post-body-text">${post.content}</p></div>`;
                    if(post.image){
                        newPostHtml += `<img
                            src="${post.image}"
                            loading="lazy"
                            sizes="100vw"
                            alt=""
                            class="post-image"
                    />`;
                    }
                    newPostHtml += `<div class="post-reactions">
                    <div class="post-comment-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                            <i class="fa-regular fa-comment post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-reposted-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-solid fa-retweet post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-likes-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-regular fa-heart post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                    <div class="post-views-stats">
                        <div class="post-stats-icon" data-id="${post.id}">
                             <i class="fa-solid fa-chart-simple post-ic"></i>
                        </div>
                        <div class="post-reaction-stats-text"></div>
                    </div>
                </div>
                    </div></div`;
                    postsSection.insertAdjacentHTML('afterbegin', newPostHtml);
                }
                if(!document.querySelector(".new-post-popup-create #fileInput")){
                    writeInputAndIcon();
                    newPostLogic();
                }
                let numOfPosts = document.querySelector(".num-of-posts");
                if(numOfPosts){
                    let numOfPostsText = numOfPosts.textContent;
                    let numOfPostsArr = numOfPostsText.split(" ");
                    let numOfPostsNum = parseInt(numOfPostsArr[0]);
                    numOfPostsNum++;
                    if(numOfPostsNum === 1){
                        numOfPosts.textContent = numOfPostsNum + " post";
                    }
                    else{
                        numOfPosts.textContent = numOfPostsNum + " posts";
                    }
                }
                document.querySelector("#popupPostBtn").classList.add("disabled-new-post-btn");
                document.querySelector("#popupPostBtn").disabled = true;
                const popupWrapper = document.querySelector("#new-post-popup-wrapper");
                popupWrapper.style.display = "none";
                document.body.style.overflow = "auto";
                if(!document.querySelector("#posts")){
                    let newPostMessage = document.createElement('div')
                    newPostMessage.id = "message-popup";
                    newPostMessage.innerHTML = `<p>Your post was sent.</p><a href="${post.post_link}">View</a>`;
                    document.body.appendChild(newPostMessage);
                    setTimeout(function (){
                        newPostMessage.classList.add('show-message-popup');
                    },200);
                    setTimeout(function (){
                        newPostMessage.remove();
                    }, 6000);
                }
            },
            error: function (err){
                console.log(err)
            }
        })
    })
}
sendPost();
newPostLogic();
document.querySelector("#popupFormBlock #post-body-2").addEventListener("input", function () {
    const postBtn = document.querySelector("#popupPostBtn");
    postBtn.disabled = this.value.trim() === "";
    this.value.trim() === "" ? postBtn.classList.add("disabled-new-post-btn") : postBtn.classList.remove("disabled-new-post-btn");
});
let socket = new WebSocket("ws://localhost:8081");
function timeAgo(createdAt) {
    const now = new Date();
    const date = new Date(createdAt);

    const yesterday = new Date(now);
    yesterday.setDate(now.getDate() - 1);

    const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };

    if (now.toDateString() === date.toDateString()) {
        return date.toLocaleTimeString(undefined, timeOptions);
    }
    else if (yesterday.toDateString() === date.toDateString()) {
        return `Yesterday, ${date.toLocaleTimeString(undefined, timeOptions)}`;
    }
    else {
        return date.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' }) +
            `, ${date.toLocaleTimeString(undefined, timeOptions)}`;
    }
}


socket.onopen = function () {
/*    let loggedInUser = document.querySelector(".logged-in-user");
    let userId = loggedInUser.getAttribute("data-id");
    socket.send(JSON.stringify({ user_id: userId }));*/
    if(document.querySelector(".chat-messages-wrapper")){
        let observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let message = entry.target;
                    let id = message.getAttribute("data-id");
                    if (!message.classList.contains("viewed")) {
                        let sendMessageButton = document.querySelector(".send-message-icon");
                        let sentFrom = sendMessageButton.getAttribute("data-receiver-id");
                        const now = new Date();
                        const offset = now.getTimezoneOffset() * 60000;
                        const localISOTime = new Date(now - offset).toISOString().slice(0, 19);
                        const formattedDate = localISOTime.replace("T", " ");
                        let messageData = JSON.stringify({
                            sent_from: sentFrom,
                            viewed: true,
                            message_id: id,
                            updated_at: formattedDate
                        });
                        socket.send(messageData);
                    }
                }
            });
        }, { threshold: 1.0 });
        document.querySelectorAll(".received-message-wrapper").forEach(message => {
            observer.observe(message);
        });

    }
};
let lastSentTimeInterval;

function startLiveTimer(element, timestamp) {
    clearInterval(lastSentTimeInterval);

    function updateTime() {
        const now = Date.now();
        const diff = Math.floor((now - timestamp) / 1000);

        if (diff < 60) {
            element.textContent = "now";
        } else if (diff < 3600) {
            element.textContent = `${Math.floor(diff / 60)}m`;
        } else {
            element.textContent = `${Math.floor(diff / 3600)}h`;
        }
    }

    updateTime();
    lastSentTimeInterval = setInterval(updateTime, 30000);
}
socket.onmessage = function (event) {
    const data = JSON.parse(event.data);
    let loggedInUser = document.querySelector(".logged-in-user");
    let userId = loggedInUser.getAttribute("data-id");
    if (data.type === 'request_user_id') {
        socket.send(JSON.stringify({ user_id: userId }));
        return;
    }
    if (data.viewed) {
        let messageId = data.message_id;
        let sentMessageWrapper = document.querySelector(`.sent-message-wrapper[data-id="${messageId}"]`);
        if (sentMessageWrapper) {
            let sentMessageInfo = sentMessageWrapper.querySelector(".sent-message-info");
            let sentInfoText = sentMessageInfo.querySelector(".sentInfoText");
            if(sentInfoText.textContent === "Sent"){
                sentInfoText.textContent = "Seen";
            }
        }
    }
    else{
        if(parseInt(data.sent_from) !== parseInt(userId) && !window.location.href.includes("messages")){
            let numOfNewMessages = document.querySelector(".numOfNewMessages p");
            if(numOfNewMessages){
                let numOfNewMessagesText = numOfNewMessages.textContent;
                let numOfNewMessagesNum = parseInt(numOfNewMessagesText);
                numOfNewMessagesNum++;
                numOfNewMessages.textContent = numOfNewMessagesNum.toString();
            }
            else{
                let linkTexts = document.querySelectorAll(".link-text");
                linkTexts.forEach(linkText => {
                    if(linkText.innerHTML === "Messages"){
                        let linkIcon = linkText.parentElement.querySelector(".link-icon");
                        linkIcon.innerHTML += `
                     <div class="numOfNewNotifications">
                        <p>1</p>
                    </div>`;
                    }
                })
            }
        }

        let messageWrapper = document.querySelector(".chat-messages-wrapper");
        let sentMessageDate = timeAgo(data.created_at);
        let allMessages = document.querySelector(".messages-wrapper .all-messages")
        if(parseInt(data.sent_from) === parseInt(userId)){
            if(allMessages){
                let chat = document.querySelector(`.active-chat`);
                if (chat){
                    let messageFromUser = chat.querySelector(".message-from-user");
                    if(messageFromUser && chat.classList.contains("active-chat")){
                        messageFromUser.classList.remove("new-message");
                    }
                    if(messageFromUser){
                        messageFromUser.innerHTML = `${data.message}`;
                    }
                    else{
                        let messageSenderInfo = chat.querySelector(".message-sender-info");
                        messageSenderInfo.innerHTML += `<div class="message-from-user">${data.message}</div>`;
                    }

                    const lastSentTime = chat.querySelector(".last-sent-time-text");
                    if (lastSentTime) {
                        lastSentTime.textContent = "now";
                        startLiveTimer(lastSentTime, Date.now());
                    }
                    else{
                        let messagedByUserInfo = chat.querySelector(".messaged-by-user-info");
                        messagedByUserInfo.innerHTML += `<div class="dot">·</div><div class="last-sent-time-text">now</div>`;
                        let lastSentTime = chat.querySelector(".last-sent-time-text");
                        startLiveTimer(lastSentTime, Date.now());
                    }
                }
            }
            if(messageWrapper && messageWrapper.parentElement.getAttribute("data-user-id") === data.sent_to){
                if(document.querySelector("#newMessagesChatNotification")){
                    document.querySelector("#newMessagesChatNotification").remove();
                }
                let lastElement = messageWrapper.lastElementChild;
                if(lastElement && lastElement.classList.contains("sent-message-wrapper")){
                    let setInfoDate = lastElement.querySelector(".sentInfoDate");
                    let dot = lastElement.querySelector(".dot");
                    let sentInfoText = lastElement.querySelector(".sentInfoText");
                    if(dot && sentInfoText){
                        dot.remove();
                        sentInfoText.remove();
                    }
                    if(setInfoDate.innerHTML === sentMessageDate){
                        setInfoDate.remove();
                        lastElement.style.marginBottom = "0px";
                    }
                }
                messageWrapper.innerHTML += `
            <div class="sent-message-wrapper" data-id="${data.message_id}">
                <div class="sent-message">
                    <p class="message-text">${data.message}</p>
                     <div class="sent-message-more-options-wrapper">
                        <div class="more-options w-embed message-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-message-option sent-choose-message-option copy-message">
                            <div class="single-message-option">
                                <i class="fa-solid fa-copy"></i>Copy message
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sent-message-info">
                    <p class="sentInfoDate">${sentMessageDate}</p>
                    <div class="dot">·</div>
                    <p class="sentInfoText">Sent</p>
                </div>
            </div>`;
            }
        }
        else{
            if(allMessages){
               let chat = document.querySelector(`.single-message[data-other-id="${data.sent_from}"]`);
               if (chat){
                   let messageFromUser = chat.querySelector(".message-from-user");
                   if(messageFromUser){
                       messageFromUser.innerHTML = `${data.message}`;
                   }
                    if(messageFromUser && chat.classList.contains("active-chat")){
                        messageFromUser.classList.remove("new-message");
                    }
                    else{
                        messageFromUser.classList.add("new-message");
                    }
                   const lastSentTime = chat.querySelector(".last-sent-time-text");
                   if (lastSentTime) {
                       lastSentTime.textContent = "now";
                       startLiveTimer(lastSentTime, Date.now());
                   }
                   if(!chat.classList.contains("new-message") && !chat.classList.contains("active-chat")){
                       chat.classList.add("new-message");
                       chat.innerHTML += `<i class="fa-solid fa-circle newMessageIcon"></i>`;
                   }
               }
               else{
                   $.ajax({
                       url: `/users/${data.sent_from}`,
                       type: 'GET',
                       success: function (user){
                           let html = `<a href="/messages/${data.conversation_id}" class="single-message new-message" data-id="${data.sent_to}" data-other-id="${data.sent_from}">
                            <img src="${user.photo}" loading="lazy" alt="" class="user-image" />
                            <div class="message-sender-info">
                                <div class="messaged-by-user-info">
                                    <div class="messaged-by-fullname">${user.full_name}</div>
                                    <div class="messaged-by-username">@${user.username}</div>
                                    <div class="dot">·</div>
                                    <div class="last-sent-time-text">now</div>
                                </div>
                                <div class="message-from-user new-message">${data.message}</div>
                            </div>
                            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
                            <i class="fa-solid fa-circle newMessageIcon"></i>
                        </a>`;
                           allMessages.insertAdjacentHTML('afterbegin', html);
                           const chat = document.querySelector(`.single-message[data-other-id="${data.sent_from}"]`);
                           const lastSentTime = chat.querySelector(".last-sent-time-text");
                           if (lastSentTime) {
                               lastSentTime.textContent = "now";
                               startLiveTimer(lastSentTime, Date.now());
                           }
                       },
                       error: function (err){
                           console.log(err)
                       }
                   })
               }
            }
            if(messageWrapper && messageWrapper.parentElement.getAttribute("data-user-id") === data.sent_from) {
                let lastElement = messageWrapper.lastElementChild;
                if(lastElement && lastElement.classList.contains("sent-message-wrapper")){
                    let dot = lastElement.querySelector(".dot");
                    let sentInfoText = lastElement.querySelector(".sentInfoText");
                    if(dot && sentInfoText){
                        dot.remove();
                        sentInfoText.remove();
                    }
                }
                messageWrapper.innerHTML += `
            <div class="received-message-wrapper" data-id="${data.message_id}">
                <div class="received-message">
                   <p class="message-text">${data.message}</p>
                   <div class="received-message-more-options-wrapper">
                        <div class="more-options w-embed message-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-message-option received-choose-message-option copy-message">
                            <div class="single-message-option">
                                <i class="fa-solid fa-copy"></i>Copy message
                            </div>
                        </div>
                    </div>
                </div>
                <div class="received-message-info">${sentMessageDate}</div>
            </div>`;
                let sendMessageButton = document.querySelector(".send-message-icon");
                let sentFrom = sendMessageButton.getAttribute("data-receiver-id");
                const now = new Date();
                const offset = now.getTimezoneOffset() * 60000;
                const localISOTime = new Date(now - offset).toISOString().slice(0, 19);
                const formattedDate = localISOTime.replace("T", " ");
                let messageData = JSON.stringify({
                    sent_from: sentFrom,
                    viewed: true,
                    message_id: data.message_id,
                    updated_at: formattedDate
                });
                socket.send(messageData);
            }
        }

        setTimeout(scrollToBottom, 100);
    }

};

function sendMessage() {
    let messageInput = document.querySelector(".type-message-input");
    let sendMessageButton = document.querySelector(".send-message-icon");
    let sentFrom = sendMessageButton.getAttribute("data-id");
    let sentTo = sendMessageButton.getAttribute("data-receiver-id");
    let conversationId = sendMessageButton.getAttribute("data-conversation-id");
    let otherUserColumn = sendMessageButton.getAttribute("data-other-user-column-name");
    const now = new Date();
    const offset = now.getTimezoneOffset() * 60000;
    const localISOTime = new Date(now - offset).toISOString().slice(0, 19);
    const formattedDate = localISOTime.replace("T", " ");
    let messageData = JSON.stringify({
        sent_from: sentFrom,
        sent_to: sentTo,
        message: messageInput.value,
        conversation_id: conversationId,
        other_user_column: otherUserColumn,
        created_at: formattedDate
    });
    socket.send(messageData);
    messageInput.value = "";
}

function scrollToBottom() {
    let chatContainer = document.querySelector(".chat-messages-wrapper");
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}













