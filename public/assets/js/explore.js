const searchInput = document.getElementById("Search");
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault();
});
let searchDiv = document.querySelector(".search-div");
searchInput.addEventListener("focus", () => {
    searchDiv.style.border = "2px solid rgb(29, 155, 240)";
})
searchInput.addEventListener("blur", () => {
    searchDiv.style.border = "2px solid #88888880";
})
searchInput.addEventListener("input", (event) => {
    if(searchInput.value.length > 1){
        event.preventDefault();
        $.ajax({
            url: "/search",
            type: "GET",
            data: {
                search: searchInput.value
            },
            success: function(data){
                const searchWrapper = document.querySelector(".search-wrapper");
                let searchResults = document.querySelector(".search-results");
                if (!searchResults) {
                    searchResults = document.createElement("div");
                    searchResults.classList.add("search-results");
                    searchWrapper.appendChild(searchResults);
                } else {
                    searchResults.innerHTML = "";
                }
                searchResults.innerHTML += `
                  <a href="${data.searchPage}?q=${encodeURIComponent(searchInput.value)}" id="searchByWord">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <p>${searchInput.value}</p>
                  </a>
                `;
                data.users.forEach((user) => {
                    searchResults.innerHTML += `
                    <a class="single-search-result" href="${user.profile_url}">
                        <img src="${user.photo}" loading="lazy" alt="" class="search-result-user-image" />
                            <div class="search-result-user-info">
                                <div class="search-result-user-fullname">${user.full_name}</div>
                                <div class="search-result-user-username">@${user.username}</div>
                            </div>
                    </a>`;
                })
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
