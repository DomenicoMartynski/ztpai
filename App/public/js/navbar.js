document.addEventListener("DOMContentLoaded", function() {
    const logoutElement = document.querySelector("#logout");

    logoutElement.addEventListener("click", function () {
        console.log("Logout button clicked");
        document.cookie = 'id_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;'
        document.cookie = 'user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;'
        location.reload();
    });
});