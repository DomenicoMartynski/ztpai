function searchGames() {
    var input, filter;
    input = document.getElementById('search-bar');
    filter = input.value.toLowerCase();

    fetch('searchGames',  {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'filter=' + encodeURIComponent(filter),
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector('.category-list').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching search results:', error);
    });
}
