let sendIcon = document.querySelector(".send-message-icon");
if(sendIcon){
    let userId = sendIcon.getAttribute("data-receiver-id");
    let singleMessage = document.querySelector(`.single-message[data-other-id="${userId}"]`);
    let sendMessageIcon = document.querySelector(".send-message-icon");
    let conversationId = sendMessageIcon.getAttribute("data-conversation-id");
    let loggedInUserId = sendMessageIcon.getAttribute("data-id");
    let allMessages = document.querySelector(".all-messages");
    if(!singleMessage){
        $.ajax({
            url: `/users/${userId}`,
            type: 'GET',
            success: function (user){
                let html = `<a href="/messages/${conversationId}" class="single-message active-chat" data-id="${loggedInUserId}" data-other-id="${userId}">
                            <img src="${user.photo}" loading="lazy" alt="" class="user-image" />
                            <div class="message-sender-info">
                                <div class="messaged-by-user-info">
                                    <div class="messaged-by-fullname">${user.full_name}</div>
                                    <div class="messaged-by-username">@${user.username}</div>
                                </div>
                                <div class="message-from-user"></div>
                            </div>
                            <div class="single-message-more-options-wrapper">
                            <div class="more-options w-embed single-message-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg"  aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>
                            <div class="choose-single-message-option">
                                <div class="single-chat-option delete-conversation" data-id="${conversationId}">
                                    <i class="fa-regular fa-trash-can"></i>Delete conversation
                                </div>
                            </div>
                        </div>
                        </a>`;
                allMessages.insertAdjacentHTML('afterbegin', html);
                const chat = document.querySelector(`.single-message[data-other-id="${userId}"]`);
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
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
        let sendMessageIcon = document.querySelector(".send-message-icon");
        sendMessageIcon.classList.remove("can-send-icon");
        sendMessageIcon.disabled = true;
    }
    if (event.target.parentElement.classList.contains("message-more-options")) {
        let sentMessageMoreOptionsWrapper = document.querySelectorAll(".sent-message-more-options-wrapper");
        let receivedMessageMoreOptionsWrapper = document.querySelectorAll(".received-message-more-options-wrapper");
        if(sentMessageMoreOptionsWrapper){
            sentMessageMoreOptionsWrapper.forEach(function (sentMessageMoreOptionsWrapper) {
                sentMessageMoreOptionsWrapper.style.opacity = "0";
            })
        }
        if(receivedMessageMoreOptionsWrapper){
            receivedMessageMoreOptionsWrapper.forEach(function (receivedMessageMoreOptionsWrapper) {
                receivedMessageMoreOptionsWrapper.style.opacity = "0";
            })
        }
        const allChooseOptions = document.querySelectorAll(".choose-message-option");
        allChooseOptions.forEach(chooseOption => {
            if(chooseOption.style.display === "block"){
                chooseOption.style.display = "none";
            }
        })
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-message-option");
        if(chooseOption.style.display === "block"){
            chooseOption.style.display = "none";
        }
        else{
            chooseOption.style.display = "block";
        }
    }
    if(!event.target.classList.contains("more-opt-ic")){
        let sentMessageMoreOptionsWrapper = document.querySelectorAll(".sent-message-more-options-wrapper");
        let receivedMessageMoreOptionsWrapper = document.querySelectorAll(".received-message-more-options-wrapper");
        let chooseSingleMessageOption = document.querySelectorAll(".choose-single-message-option");
        if(chooseSingleMessageOption){
            chooseSingleMessageOption.forEach(function (chooseSingleMessageOption) {
                chooseSingleMessageOption.style.display = "none";
            })
        }
        if(sentMessageMoreOptionsWrapper){
            sentMessageMoreOptionsWrapper.forEach(function (sentMessageMoreOptionsWrapper) {
                sentMessageMoreOptionsWrapper.style.opacity = "0";
            })
        }
        if(receivedMessageMoreOptionsWrapper){
            receivedMessageMoreOptionsWrapper.forEach(function (receivedMessageMoreOptionsWrapper) {
                receivedMessageMoreOptionsWrapper.style.opacity = "0";
            })
        }
        document.querySelectorAll(".choose-message-option").forEach(chooseOption => {
            chooseOption.style.display = "none";
        })
        const chooseOptionsWrapper = document.querySelector("#chooseOptionsWrapper");
        chooseOptionsWrapper.style.display = "none";
    }
    if(event.target.classList.contains("single-message-option") || event.target.parentElement.classList.contains("single-message-option")){
        let messageWrapper = event.target.classList.contains("single-message-option") ? event.target.parentElement.parentElement.parentElement : event.target.parentElement.parentElement.parentElement.parentElement;
        let message = messageWrapper.querySelector(".message-text").innerText;
        navigator.clipboard.writeText(message).then(function() {
            let msg = document.createElement("div");
            msg.id = "message-popup";
            msg.innerHTML = `<p>Message copied</p>`;
            document.body.appendChild(msg);
            setTimeout(function (){
                msg.classList.add('show-message-popup');
            },50);
            setTimeout(function (){
                msg.remove();
            }, 3000);

        }).catch(function(err) {
            console.error("Failed to copy: ", err);
        });
    }
    if(event.target.parentElement.classList.contains("single-message-more-options")){
        const allChooseOptions = document.querySelectorAll(".choose-single-message-option");
        allChooseOptions.forEach(chooseOption => {
            if(chooseOption.style.display === "block"){
                chooseOption.style.display = "none";
            }
        })
        const chooseOption = event.target.parentElement.parentElement.querySelector(".choose-single-message-option");
        if(chooseOption.style.display === "block"){
            chooseOption.style.display = "none";
   }
        else{
            chooseOption.style.display = "block";
        }
    }
    if(event.target.className === "cancelPopupBtn"){
        let actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        let chooseOptionsWrapper = document.querySelector("#chooseOptionsWrapper");
        chooseOptionsWrapper.style.display = "none";
        actionPopupWrapper.style.display = "none";
        document.body.style.overflow = "auto";
    }
    if(event.target.className === "deleteConversationPopupBtn"){
        let conversationId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/conversations/${conversationId}`,
            type: "DELETE",
            success: function(){
                window.location.href = "/messages";
            },
            error: function(err){
                console.log(err);
            }
        })
    }
    if(event.target.classList.contains("delete-conversation")){
        const conversationId = event.target.getAttribute("data-id");
        const actionPopupWrapper = document.querySelector("#action-popup-wrapper");
        const confirmDelete = document.querySelector("#doActionBtn");
        confirmDelete.className = "deleteConversationPopupBtn";
        confirmDelete.textContent = "Leave";
        confirmDelete.setAttribute("data-id", conversationId);
        let popupHeading = document.querySelector("#action-popup-wrapper h3");
        popupHeading.textContent = "Leave conversation?";
        let popupText = document.querySelector("#action-popup-wrapper p");
        popupText.textContent = "This conversation will be deleted from your inbox.";
        actionPopupWrapper.style.display = "block";
        document.body.style.overflow = "hidden";
    }
    if(event.target.classList.contains("single-new-message-user") || event.target.parentElement.classList.contains("single-new-message-user") || event.target.parentElement.parentElement.classList.contains("single-new-message-user")){
        let userId;
        if(event.target.classList.contains("single-new-message-user")){
            userId = event.target.getAttribute("data-id");
        }
        else if(event.target.parentElement.classList.contains("single-new-message-user")){
            userId = event.target.parentElement.getAttribute("data-id");
        }
        else{
            userId = event.target.parentElement.parentElement.getAttribute("data-id");
        }
        $.ajax({
            url: `/navigate-to-conversation?userId=${userId}`,
            type: "GET",
            success: function(data){
                window.location.href = data.route;
            },
        });
    }
    if(!event.target.classList.contains("single-message") && !event.target.classList.contains("user-image") && !event.target.classList.contains("message-sender-info") && !event.target.classList.contains("messaged-by-user-info") && !event.target.classList.contains("message-from-user") && !event.target.classList.contains("messaged-by-fullname") && !event.target.classList.contains("messaged-by-username") && !event.target.classList.contains("dot") && !event.target.classList.contains("last-sent-time-text") && (event.target.classList.contains("single-message-more-options-wrapper") || event.target.parentElement.classList.contains("single-message-more-options-wrapper") || event.target.parentElement.parentElement.classList.contains("single-message-more-options-wrapper"))){
        event.preventDefault();
    }
})
let typeMessageInput = document.querySelector(".type-message-input");
if(typeMessageInput){
    typeMessageInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();

            sendMessage();
            let sendMessageIcon = document.querySelector(".send-message-icon");
            sendMessageIcon.classList.remove("can-send-icon");
            sendMessageIcon.disabled = true;
        }
    })
    typeMessageInput.addEventListener("input", function () {
        let sendMessageIcon = document.querySelector(".send-message-icon");

        if(typeMessageInput.value === ""){
            sendMessageIcon.classList.remove("can-send-icon");
            sendMessageIcon.disabled = true;
        }
        else{
            sendMessageIcon.classList.add("can-send-icon");
            sendMessageIcon.disabled = false;
        }
    })
}

document.addEventListener("DOMContentLoaded", function () {
    if(window.innerWidth > 991){
        let returnBackLink = document.querySelector(".returnBackLink");
        if(returnBackLink){
            returnBackLink.style.display = "none";
        }
    }
    let selectMessageWrapper = document.querySelector("#selectMessageNotification");
    if(!selectMessageWrapper && window.location.pathname.includes("/messages/") && window.innerWidth < 992){
        let returnBackLink = document.querySelector(".returnBackLink");
        if(returnBackLink){
            returnBackLink.style.display = "block";
        }
        let messagesWrapper = document.querySelector(".messages-wrapper");
        if(messagesWrapper){
            messagesWrapper.style.display = "none";
        }
        let chat = document.querySelector(".chat");
        if(chat){
            chat.style.display = "flex";
            let chatContainer = document.querySelector(".chat-messages-wrapper");
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

    }
    let header = document.querySelector(".header");
    let topHeaderNav = document.querySelector("#topHeaderNav");
    if(window.innerWidth < 501 && header && window.location.pathname.includes("/messages/")){
        header.style.display = "none";
        topHeaderNav.style.display = "none";
    }
    let chatWrapper = document.querySelector(".chat-messages-wrapper");
    let newMessagesNotification = document.getElementById("newMessagesChatNotification");

    if (chatWrapper && newMessagesNotification) {
        chatWrapper.scrollTo({
            top: newMessagesNotification.offsetTop - chatWrapper.offsetTop - 30,
            behavior: "smooth"
        });
    }
    if(chatWrapper){
        let LSMessageId = localStorage.getItem('messageId');
        if(LSMessageId){
            let sentMessage = document.querySelector(`.sent-message-wrapper[data-id="${LSMessageId}"]`);
            let receivedMessage = document.querySelector(`.received-message-wrapper[data-id="${LSMessageId}"]`);
            if(sentMessage){
                chatWrapper.scrollTo({
                    top: sentMessage.offsetTop - chatWrapper.offsetTop - 30,
                    behavior: "smooth"
                });
                sentMessage.classList.add("sent-searched-message");
                setTimeout(function (){
                    sentMessage.classList.remove("sent-searched-message");
                }, 3000)
            }
            if(receivedMessage){
                chatWrapper.scrollTo({
                    top: receivedMessage.offsetTop - chatWrapper.offsetTop - 30,
                    behavior: "smooth"
                });
                receivedMessage.classList.add("received-searched-message");
                setTimeout(function (){
                    receivedMessage.classList.remove("received-searched-message");
                }, 3000)
            }
            localStorage.removeItem('messageId');
        }
    }
});
document.addEventListener("mouseover", function (event){
    if(event.target.parentElement && event.target.parentElement.classList.contains("message-more-options")){
        event.target.parentElement.parentElement.style.opacity = "1";
    }
})
document.addEventListener("mouseout", function (event){
    if(event.target.parentElement !== null && event.target.parentElement.classList.contains("message-more-options")){
        let chooseOption = event.target.parentElement.parentElement.querySelector(".choose-message-option");
        if(!chooseOption.style.display || chooseOption.style.display === "none"){
            event.target.parentElement.parentElement.style.opacity = "0";
        }
        else{
            event.target.parentElement.parentElement.style.opacity = "1";
        }
    }
})
let newMessageBtn = document.querySelector("#newMessageBtn")
let newMessageIcon = document.querySelector(".new-message-icon")
let newMessagePopup = document.querySelector(".new-message-popup");
let searchPeopleInput = document.querySelector(".search-people-chat-input");
if(newMessageBtn){
    newMessageBtn.addEventListener("click", function (){
        newMessagePopup.parentElement.style.display = "block";
        searchPeopleInput.focus();
    })
}
if(newMessageIcon){
    newMessageIcon.addEventListener("click", function (){
        newMessagePopup.parentElement.style.display = "block";
        searchPeopleInput.focus();
    })
}
let newMessageSearchResultsWrapper = document.querySelector(".new-message-result-wrapper");
let oldHtml = newMessageSearchResultsWrapper.innerHTML;
searchPeopleInput.addEventListener("input", function (){
    let value = searchPeopleInput.value.trim();
    if(value.length > 2){
        $.ajax({
            url: `/search-new-conversation?query=${value}`,
            type: "GET",
            success: function (users){
                let html = "";
                    users.forEach(user => {
                        html += `
                <div class="single-new-message-user" data-id="${user.id}">
                        <img src="${user.photo}" loading="lazy" alt="" class="user-image" />
                        <div class="new-message-user-info">
                            <div class="new-message-user-fullname">${user.full_name}</div>
                            <div class="new-message-user-username">@${user.username}</div>
                        </div>
                    </div>`;
                    })
                newMessageSearchResultsWrapper.innerHTML = html;
                }
        })
    }
    else{
        newMessageSearchResultsWrapper.innerHTML = oldHtml;
    }
})
let searchMessageInput = document.querySelector("#message-search");
let messagesWrapper = document.querySelector(".messages-wrapper");
let oldMessagesHtml;
let allMessages = document.querySelector(".all-messages");
if(allMessages){
    oldMessagesHtml = allMessages.innerHTML;
}
searchMessageInput.addEventListener("input", function (){
    let value = searchMessageInput.value.trim();
    if(value.length > 0){
        let allMessages = document.querySelector(".all-messages");
        if(allMessages){
            allMessages.remove();
        }
        $.ajax({
            url: `/search-direct-messages?query=${value}`,
            type: "GET",
            success: function (data){
                let searchDirectMessages;
                if(!document.querySelector("#searchDirectMessages")){
                    searchDirectMessages = document.createElement('div');
                    searchDirectMessages.id = "searchDirectMessages";
                }
                else{
                    searchDirectMessages = document.querySelector("#searchDirectMessages");
                }
                if(data.people.length > 0){
                    let peopleResult;
                    if(!document.querySelector("#peopleResult")){
                        peopleResult = document.createElement('div');
                        peopleResult.id = "peopleResult";
                        peopleResult.innerHTML = `<div class="resultInfo"><i class="fa-solid fa-user"></i><p>People</p></div>`;
                    }
                    else{
                        peopleResult = document.querySelector("#peopleResult");
                    }
                    let searchResultPeople;
                    if(!document.querySelector("#searchResultPeople")){
                        searchResultPeople = document.createElement('div');
                        searchResultPeople.id = "searchResultPeople";
                    }
                    else{
                        searchResultPeople = document.querySelector("#searchResultPeople");
                        searchResultPeople.innerHTML = "";
                    }
                    data.people.forEach(p => {
                        let singleResultUser = document.createElement("a");
                        singleResultUser.className = "single-result-user";
                        singleResultUser.setAttribute("href", p.conversation_link);
                        singleResultUser.setAttribute("data-id", p.id);
                        singleResultUser.innerHTML = `
                         <img src="${p.photo}" loading="lazy" alt="" class="user-image" />`;
                        let searchedUserInfo = document.createElement("div");
                        searchedUserInfo.className = "searched-user-info";
                        let fullNameText = p.full_name;
                        let regex = new RegExp(`(${value})`, 'gi');
                        fullNameText = fullNameText.replace(regex, '<span class="foundString">$1</span>');
                        let searchedUserFullName = document.createElement("p");
                        searchedUserFullName.className = "searched-user-fullname";
                        searchedUserFullName.innerHTML = fullNameText;
                        let usernameText = p.username;
                        usernameText = usernameText.replace(regex, '<span class="foundString">$1</span>');
                        let searchedUserUsername = document.createElement("p");
                        searchedUserUsername.className = "searched-user-username";
                        searchedUserUsername.innerHTML = "@" + usernameText;
                        searchedUserInfo.appendChild(searchedUserFullName);
                        searchedUserInfo.appendChild(searchedUserUsername);
                        singleResultUser.appendChild(searchedUserInfo);
                        searchResultPeople.appendChild(singleResultUser);
                    })
                    peopleResult.appendChild(searchResultPeople);
                    if(document.querySelector("#messageResult")){
                        document.querySelector("#messageResult").remove();
                    }
                    searchDirectMessages.appendChild(peopleResult);
                }
                else{
                    if(document.querySelector("#peopleResult")){
                        document.querySelector("#peopleResult").remove();
                    }
                }
                if(data.messages.length > 0){
                    let messageResult;
                    if(!document.querySelector("#messageResult")){
                        messageResult = document.createElement('div');
                        messageResult.id = "messageResult";
                        messageResult.innerHTML = `<div class="resultInfo"><i class="fa-solid fa-envelope"></i><p>Messages</p></div>`;
                    }
                    else{
                        messageResult = document.querySelector("#messageResult");
                    }
                    let searchResultMessages;
                    if(!document.querySelector("#searchResultMessages")){
                        searchResultMessages = document.createElement('div');
                        searchResultMessages.id = "searchResultMessages";
                    }
                    else{
                        searchResultMessages = document.querySelector("#searchResultMessages");
                        searchResultMessages.innerHTML = "";
                    }
                    data.messages.forEach(message => {
                        let singleResultMessage = document.createElement("a");
                        singleResultMessage.className = "single-result-message";
                        singleResultMessage.setAttribute("href", message.conversation_link);
                        singleResultMessage.setAttribute("data-id", message.id);
                        singleResultMessage.innerHTML = `
                        <div class="single-result-message-info">
                            <img src="${message.photo}" loading="lazy" alt="" class="user-image" />
                            <div class="searched-message-fullname">${message.full_name}</div>
                            <div class="dot">·</div>
                            <div class="searched-messaged-sent-time">${message.created_at}</div>
                        </div>`;
                        let messageText = message.message;
                        let regex = new RegExp(`(${value})`, 'gi');
                        messageText = messageText.replace(regex, '<span class="foundString">$1</span>');
                        let searchedMessageText = document.createElement("p");
                        searchedMessageText.className = "searched-message-text";
                        searchedMessageText.innerHTML = messageText;
                        singleResultMessage.appendChild(searchedMessageText);
                        searchResultMessages.appendChild(singleResultMessage);
                    })
                    messageResult.appendChild(searchResultMessages);
                    searchDirectMessages.appendChild(messageResult);
                }
                else{
                    if(document.querySelector("#messageResult")){
                        document.querySelector("#messageResult").remove();
                    }
                }
                messagesWrapper.appendChild(searchDirectMessages);
                let singleResultMessages = document.querySelectorAll(".single-result-message");
                if(singleResultMessages){
                    singleResultMessages.forEach(singleResultMessage => {
                        singleResultMessage.addEventListener("click", function (e){
                            e.preventDefault();
                            let link = singleResultMessage.getAttribute("href");
                            let messageId = singleResultMessage.getAttribute("data-id");
                            console.log(messageId);
                            localStorage.setItem('messageId', messageId);
                            window.location.href = link;
                        })
                    })
                }
            }
        })
    }
    else{
        let allMessages = document.querySelector(".all-messages");
        if(document.querySelector("#searchDirectMessages")){
            document.querySelector("#searchDirectMessages").remove();
        }
        if(!allMessages){
            let newAllMessages =document.createElement("div");
            newAllMessages.className = "all-messages";
            newAllMessages.innerHTML = oldMessagesHtml;
            messagesWrapper.appendChild(newAllMessages);
        }

    }
})