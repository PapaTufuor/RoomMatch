document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value;

    if (query.length > 2) { // Start searching after 3 characters
        fetch(`../includes/search_endpoint.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = '';

                data.forEach(user => {
                    const userLink = document.createElement('a');
                    userLink.href = `../templates/bio.php?user_id=${user.id}`;
                    userLink.textContent = user.name;
                    resultsContainer.appendChild(userLink);
                });

                resultsContainer.style.display = data.length ? 'block' : 'none';
            });
    } else {
        document.getElementById('searchResults').style.display = 'none';
    }
});

document.addEventListener('click', function(e) {
    if (!document.querySelector('.search-container').contains(e.target)) {
        document.getElementById('searchResults').style.display = 'none';
    }
});
