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