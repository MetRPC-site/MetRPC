// Vérifier si le script est chargé
console.log('Script chargé');

// Menu burger
console.log('Recherche des éléments du menu burger');
const menuBtn = document.querySelector('.menu-btn');
const navMenu = document.querySelector('.nav-menu');

if (menuBtn && navMenu) {
    console.log('Éléments trouvés, configuration du menu burger');
    
    // Ajout d'un style visuel pour le bouton burger
    menuBtn.style.cursor = 'pointer';
    
    // Fonction pour fermer le menu
    const fermerMenu = () => {
        navMenu.classList.remove('active');
        menuBtn.classList.remove('active');
    };

    menuBtn.addEventListener('click', () => {
        console.log('Bouton burger cliqué');
        navMenu.classList.toggle('active');
        menuBtn.classList.toggle('active');
    });

    // Fermeture du menu quand on clique sur un lien
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', (e) => {
            console.log('Lien cliqué, fermeture du menu');
            fermerMenu();
            
            // Attendre que le menu soit fermé avant de suivre le lien
            setTimeout(() => {
                e.preventDefault();
                window.location.href = link.getAttribute('href');
            }, 300); // 300ms pour la transition
        });
    });

    // Fermeture du menu quand on clique en dehors
    document.addEventListener('click', (e) => {
        if (!menuBtn.contains(e.target) && !navMenu.contains(e.target)) {
            fermerMenu();
        }
    });
} else {
    console.error('Éléments du menu burger non trouvés');
}

// Animation bouton (ex: ondulation légère)
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transform = 'scale(1.05)';
    });
    button.addEventListener('mouseleave', () => {
        button.style.transform = 'scale(1)';
    });
});