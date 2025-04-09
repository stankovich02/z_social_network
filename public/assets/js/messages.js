
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
        actionPopupWrapper.style.display = "none";
        document.body.style.overflow = "auto";
    }
    if(event.target.className === "deleteConversationPopupBtn"){
        let conversationId = event.target.getAttribute("data-id");
        $.ajax({
            url: `/conversations/${conversationId}`,
            type: "DELETE",
            success: function(){

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
let chatContainer = document.querySelector(".chat-messages-wrapper");
if (chatContainer) {
    chatContainer.scrollTop = chatContainer.scrollHeight;
}
document.addEventListener("DOMContentLoaded", function () {
    let chatWrapper = document.querySelector(".chat-messages-wrapper");
    let newMessagesNotification = document.getElementById("newMessagesChatNotification");

    if (chatWrapper && newMessagesNotification) {
        chatWrapper.scrollTo({
            top: newMessagesNotification.offsetTop - chatWrapper.offsetTop - 30,
            behavior: "smooth"
        });
    }
});
document.addEventListener("mouseover", function (event){
    if(event.target.parentElement.classList.contains("message-more-options")){
        event.target.parentElement.parentElement.style.opacity = "1";
    }
})
document.addEventListener("mouseout", function (event){
    if(event.target.parentElement.classList.contains("message-more-options")){
        let chooseOption = event.target.parentElement.parentElement.querySelector(".choose-message-option");
        if(!chooseOption.style.display || chooseOption.style.display === "none"){
            event.target.parentElement.parentElement.style.opacity = "0";
        }
        else{
            event.target.parentElement.parentElement.style.opacity = "1";
        }
    }
})
let singleMessages = document.querySelectorAll(".single-message");
if(singleMessages){
    singleMessages.forEach(singleMessage => {
        singleMessage.addEventListener("click", function (event){
            if(!event.target.classList.contains("single-message") && !event.target.classList.contains("user-image") && !event.target.classList.contains("message-sender-info") && !event.target.classList.contains("messaged-by-user-info") && !event.target.classList.contains("message-from-user") && !event.target.classList.contains("messaged-by-fullname") && !event.target.classList.contains("messaged-by-username") && !event.target.classList.contains("dot") && !event.target.classList.contains("last-sent-time-text")){
                event.preventDefault();
            }

        })
    })
}