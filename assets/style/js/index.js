function menuBurger() {
    const menu = document.querySelector(".fa-bars");
    const ul = document.querySelector(".navbar ul");
    // console.log(ul);
    // console.log(menu);
    
    
    
    menu.addEventListener("click", function () {
        ul.classList.toggle("hidden");
        // console.log(ul);
    })
}




function searchBar(url, grid) {
    grid.innerHTML = '<p class="loading">Chargement des mangas...</p>'; // Message de chargement

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur Ajax');
        }
        return response.json();
    })
    .then(mangas => {
        // console.log(mangas);  // Vérifiez ici si les données JSON sont correctes
        grid.innerHTML = '';  // Vider le container avant d'ajouter les résultats
    
        if (mangas.length > 0) {
            mangas.forEach(manga => {
                const mangaHtml = `
                    <li class="card">
                        <img src="${manga.volumeCover.url}" alt="${manga.volumeCover.alt}"/>
                        <a href="index.php?route=manga_id&id=${manga.id}">${manga.name}</a>
                    </li>
                `;
                // console.log(mangaHtml);
                grid.insertAdjacentHTML('beforeend', mangaHtml);
            });
        } else {
            grid.innerHTML = '<p class="search-error">Aucun manga ne correspond à votre recherche.</p>';
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête Ajax :', error);
        grid.innerHTML = '<p class="search-error">Erreur de chargement des mangas. Veuillez réessayer.</p>';
    });
    
}

function htmlspecialchars(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

document.addEventListener('DOMContentLoaded', function () {
    menuBurger();
    const searchInput = document.querySelector('.search');
    const grid = document.querySelector('.grid');

    // Activation de la barre de recherche
    searchInput.addEventListener('input', function() {
        const query = searchInput.value.trim();
        const url = `index.php?route=manga&search=${encodeURIComponent(query)}`;
        // console.log("URL de recherche : ", url);
        searchBar(url, grid);
    });
});