
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
    }
})
let typeMessageInput = document.querySelector(".type-message-input");
if(typeMessageInput){
    typeMessageInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();

            sendMessage();
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
