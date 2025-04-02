let singleMessages = document.querySelectorAll(".single-message");
if(singleMessages){
    singleMessages.forEach(message => {
        message.addEventListener("click", function () {
            if(message.classList.contains("new-message")){
                message.classList.remove("new-message");
                message.classList.add("active-chat");
                let newMessageIcon = message.querySelector(".newMessageIcon")
                if(newMessageIcon){
                    newMessageIcon.remove();
                }
            }
            else{
                let activeChat = document.querySelector(".active-chat");
                if(activeChat){
                    activeChat.classList.remove("active-chat");
                }
                message.classList.add("active-chat");
            }

        });
    })
}
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
    }
})
let typeMessageInput = document.querySelector(".type-message-input");
typeMessageInput.addEventListener("input", function (event) {
    let sendMessageIcon = document.querySelector(".send-message-icon");
    if(event.key === "Enter"){
        sendMessage();
    }
    if(typeMessageInput.value === ""){
        sendMessageIcon.classList.remove("can-send-icon");
    }
    else{
        sendMessageIcon.classList.add("can-send-icon");
    }
})
