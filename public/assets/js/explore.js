const searchInput = document.getElementById("Search");
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault();
});
searchInput.addEventListener("input", (event) => {
    if(searchInput.value.length > 2){
        event.preventDefault();
        $.ajax({
            url: "/search",
            type: "GET",
            data: {
                search: searchInput.value
            },
            success: function(users){
                const searchWrapper = document.querySelector(".search-wrapper");
                let searchResults = document.querySelector(".search-results");
                if (!searchResults) {
                    searchResults = document.createElement("div");
                    searchResults.classList.add("search-results");
                    searchWrapper.appendChild(searchResults);
                } else {
                    searchResults.innerHTML = "";
                }
                users.forEach((user) => {
                    searchResults.innerHTML += `
                    <a class="single-search-result" href="${user.profile_url}">
                        <img src="${user.photo}" loading="lazy" alt="" class="search-result-user-image" />
                            <div class="search-result-user-info">
                                <div class="search-result-user-fullname">${user.full_name}</div>
                                <div class="search-result-user-username">@${user.username}</div>
                            </div>
                    </a>`;
                })

                if (users.length === 0) {
                    searchResults.style.display = "none";
                } else {
                    searchResults.style.display = "block";
                }
            },
            error: function(err){
                console.log(err)
            }
        })
    }
    else {
        let searchResults = document.querySelector(".search-results");
        if (searchResults) {
            if (searchResults) {
                searchResults.remove();
            }
        }
    }
})