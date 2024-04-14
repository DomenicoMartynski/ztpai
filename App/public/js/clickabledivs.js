$(document).ready(function() {
    $(document).on('click', '.list-content', function() {
        var form = $(this).find('form');

        if (form.length > 0) {
            var formData = new FormData(form[0]);
            var queryString = new URLSearchParams(formData).toString();
            window.location.href = "gamedetails?" + queryString;
        }
    });
});

$(document).ready(function() {
    $(document).on('click', '.admin-div', function() {
        window.location.href = "/add_game";
    });
});