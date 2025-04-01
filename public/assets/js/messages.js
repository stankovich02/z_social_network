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
