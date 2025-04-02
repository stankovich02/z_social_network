
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
    }
})
let typeMessageInput = document.querySelector(".type-message-input");
typeMessageInput.addEventListener("keydown", function (event) {
    let sendMessageIcon = document.querySelector(".send-message-icon");
    if (event.key === "Enter") {
        event.preventDefault();

        sendMessage();
    }

    if(typeMessageInput.value === ""){
        sendMessageIcon.classList.remove("can-send-icon");
    }
    else{
        sendMessageIcon.classList.add("can-send-icon");
    }
})
