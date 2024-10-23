function menuBurger() {
    const menu = document.querySelector(".fa-bars");
    const ul = document.querySelector(".navbar ul");

    menu.addEventListener("click", function () {
        ul.classList.toggle("hidden");
    })
}

function searchBar(url, grid, currentPage = 1) {
    // Limite de cartes par page
    const cardParPage = 9; 
    // Initialisé à 1, sera calculé après avoir obtenu les mangas
    let totalPages = 1; 

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
        console.log(mangas);  // Debugging: affichage des mangas reçus
        grid.innerHTML = '';  // Vider le container avant d'ajouter les résultats
    
        if (mangas.length > 0) {
            totalPages = Math.ceil(mangas.length / cardParPage);

            const debut = (currentPage - 1) * cardParPage;
            const fin = currentPage * cardParPage;
            const mangaToShow = mangas.slice(debut, fin);

            mangaToShow.forEach((manga, index) => {
                const mangaHtml = `
                    <li class="card page-${currentPage}">
                        <img src="${manga.volumeCover.url}" alt="${manga.volumeCover.alt}"/>
                        <a href="index.php?route=manga_id&id=${manga.id}">${manga.name}</a>
                    </li>
                `;

                grid.insertAdjacentHTML('beforeend', mangaHtml);
            });

            // Désactiver les cartes des autres pages
            for (let i = 1; i <= totalPages; i++) {
                if (i !== currentPage) {
                    const cardDisable = grid.querySelectorAll(`.page-${i}`);
                    cardDisable.forEach(card => {
                        card.classList.add('hidden');
                    });
                }
            }

            // Nettoyage des anciennes paginations
            const oldPagination = document.querySelector('.pagination');
            if (oldPagination) {
                oldPagination.remove();
            }

            // Créer les boutons de pagination
            pagination(grid, totalPages, currentPage);
        } else {
            grid.innerHTML = '<p class="search-error">Aucun manga ne correspond à votre recherche.</p>';
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête Ajax :', error);
        grid.innerHTML = '<p class="search-error">Erreur de chargement des mangas. Veuillez réessayer.</p>';
    });
}

function pagination(grid, totalPages, currentPage) {
    let paginationHtml = '<div class="pagination">';

    // Bouton précédent
    if (currentPage > 1) {
        paginationHtml += `<button class="pagination-btn prev" data-page="${currentPage - 1}">Précédent</button>`;
    }

    // Boutons de pages
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
    }

    // Bouton suivant
    if (currentPage < totalPages) {
        paginationHtml += `<button class="pagination-btn next" data-page="${currentPage + 1}">Suivant</button>`;
    }

    paginationHtml += '</div>';

    grid.insertAdjacentHTML('afterend', paginationHtml);

    // Ajout d'événement aux boutons de pagination
    const paginationButtons = document.querySelectorAll('.pagination-btn');
    paginationButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const page = parseInt(event.target.getAttribute('data-page'));

            changePage(page);
        });
    });
}

function changePage(page) {
    const grid = document.querySelector(".grid");   // Sélection de la grille de mangas
    const url = 'index.php?route=manga'; // Remplacez par l'URL réelle de l'API
    searchBar(url, grid, page); // Recharger avec la nouvelle page
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
    // if(window.Location.href.include('index.php?route=manga')){
        const searchInput = document.querySelector('.search');
        const grid = document.querySelector('.grid');
    
        // Activation de la barre de recherche
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            const url = `index.php?route=manga&search=${encodeURIComponent(query)}`;
            console.log("URL de recherche : ", url);  // Debugging: vérifier l'URL de recherche
            searchBar(url, grid);
        });
        const url = 'index.php?route=manga';  // URL par défaut pour récupérer tous les mangas
        searchBar(url, grid);  // Appel initial à la fonction searchBar

    // }
});
