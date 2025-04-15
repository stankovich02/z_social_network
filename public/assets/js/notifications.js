document.addEventListener("DOMContentLoaded", function () {
    let observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let notification = entry.target;
                let notificationId = notification.getAttribute("data-id");
                if (!notification.dataset.viewed) {
                    notification.dataset.viewed = "true";
                    $.ajax({
                        url: `/notifications/${notificationId}/read`,
                        type: "POST",
                        success: function () {
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    })
                }
            }
        });
    }, { threshold: 1.0 });

    document.querySelectorAll(".single-notification-link").forEach(post => {
        observer.observe(post);
    });
});
let allNotifications = document.querySelectorAll(".single-notification-link");
allNotifications.forEach(notification => {

    notification.addEventListener("click", function (e) {
        let singleComment = this.querySelector(".single-comment");
        let notificationId = this.getAttribute("data-id");
        if(singleComment){
            e.preventDefault();
            $.ajax({
                url: `/notifications/${notificationId}?type=comment`,
                type: "GET",
                success: function (data) {
                    localStorage.setItem("commentId", data.commentId);
                    window.location.href = data.link;
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }
        let textBlock = this.querySelector(".text-block");
        if(textBlock.innerHTML.includes("reply")){
            e.preventDefault();
            $.ajax({
                url: `/notifications/${notificationId}?type=comment`,
                type: "GET",
                success: function (data) {
                    localStorage.setItem("commentId", data.commentId);
                    window.location.href = data.link;
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }
    });
})