
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
        let sendMessageIcon = document.querySelector(".send-message-icon");
        sendMessageIcon.classList.remove("can-send-icon");
        sendMessageIcon.disabled = true;
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
