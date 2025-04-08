
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
        let sendMessageIcon = document.querySelector(".send-message-icon");
        sendMessageIcon.classList.remove("can-send-icon");
        sendMessageIcon.disabled = true;
    }
    if (event.target.parentElement.classList.contains("message-more-options")) {
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
    if(event.target.classList.contains("sent-message-more-options-wrapper") || event.target.classList.contains("received-message-more-options-wrapper")){
        event.target.style.opacity = "1";
    }
})
/*let sentMessageMoreOptionsWrapper = document.querySelectorAll(".sent-message-more-options-wrapper");
if(sentMessageMoreOptionsWrapper){
    sentMessageMoreOptionsWrapper.forEach(function (sentMessageMoreOptionsWrapper) {
        sentMessageMoreOptionsWrapper.addEventListener("mouseover", function () {
            this.style.opacity = "1";
        })
    })
}
let receivedMessageMoreOptionsWrapper = document.querySelectorAll(".received-message-more-options-wrapper");
if(receivedMessageMoreOptionsWrapper){
    receivedMessageMoreOptionsWrapper.forEach(function (receivedMessageMoreOptionsWrapper) {
        receivedMessageMoreOptionsWrapper.addEventListener("mouseover", function () {
            this.style.opacity = "1";
        })
    })
}*/
