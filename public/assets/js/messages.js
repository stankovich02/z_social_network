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
            let selectMessage = document.querySelector("#selectMessageNotification");
            let userId = message.getAttribute("data-id");
            let otherUserId = message.getAttribute("data-other-id");
            if(selectMessage){
                selectMessage.remove();
                let chat = document.querySelector(".chat");
                $.ajax({
                    url: '/messages?userId=' + userId + '&otherUserId=' + otherUserId,
                    type: 'GET',
                    success: function (data) {
                        chat.innerHTML += `
                          <div class="chat-user-fullname">${data.otherUser.full_name}</div>
                            <a href="${data.otherUser.profile_link}" class="chat-user-info-wrapper">
                                <img src="${data.otherUser.photo}" loading="lazy" alt="" class="chat-user-image" />
                                <div class="chat-user-info">
                                    <div class="chat-user-info-fullname">${data.otherUser.full_name}</div>
                                    <div class="chat-user-info-username">@${data.otherUser.username}</div>
                                    <div class="chat-user-bio">${data.otherUser.biography}</div>
                                    <div class="chat-user-date-joined-and-followers">
                                        <div class="user-joined-date">Joined ${data.otherUser.joinedDate}</div>
                                        <div class="dot">·</div>
                                        <div class="chat-user-num-of-followers">${data.otherUser.numOfFollowers}</div>
                                    </div>
                                </div>
                          </a>`;
                        let chatMessagesWrapper = document.createElement("div");
                        chatMessagesWrapper.classList.add("chat-messages-wrapper");
                        data.messages.forEach(message => {
                            if(message.sent_from === parseInt(userId)){
                                chatMessagesWrapper.innerHTML += `
                                    <div class="sent-message-wrapper">
                                        <div class="sent-message">
                                            <p class="message-text">${message.message}</p>
                                        </div>
                                        <div class="sent-message-info">${message.created_at}</div>
                                    </div>`;
                            }
                            else{
                                chatMessagesWrapper.innerHTML += `
                                    <div class="received-message-wrapper">
                                        <div class="received-message">
                                            <p class="message-text">${message.message}</p>
                                        </div>
                                        <div class="received-message-info">${message.created_at}</div>
                                    </div>`;
                            }
                        });
                        chat.appendChild(chatMessagesWrapper);
                        chat.innerHTML += ` 
                         <div class="send-message-div">
                                    <div class="send-message-form w-form">
                                        <form
                                                id="email-form-2"
                                                name="email-form-2" 
                                                method=""
                                                class="form-3"
                                        >
                                            <input class="type-message-input w-input" maxlength="256" name="new-message-text" placeholder="Start a new message" type="text" id="new-message-text" />
                                        </form>
                                    </div>
                                    <div class="send-message-icon w-embed" data-id="${userId}" data-receiver-id="${otherUserId}">
                                        <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true"
                                                role="img"
                                                class="iconify iconify--ic"
                                                width="100%"
                                                height="100%"
                                                preserveAspectRatio="xMidYMid meet"
                                                viewBox="0 0 24 24"
                                        >
                                            <path fill="currentColor" d="M2.01 21L23 12L2.01 3L2 10l15 2l-15 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                        `;
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
                        window.scrollY = 0;
                    },
                })
            }
            else{
                //uraditi kad se doda jos jedan korisnik
            }

        });
    })
}
document.addEventListener("click", function (event){
    if(event.target.parentElement.parentElement.classList.contains("can-send-icon") || event.target.parentElement.classList.contains("can-send-icon") || event.target.classList.contains("can-send-icon")){
        sendMessage();
    }
})