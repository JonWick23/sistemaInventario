document.addEventListener("DOMContentLoaded", function() {

    const toggle = document.getElementById("userToggle");
    const menu = document.getElementById("submenuItems");
    const userMenu = document.getElementById("userMenu");

    toggle.addEventListener("click", function(e) {
        e.preventDefault();
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    });

    document.addEventListener("click", function(e) {
        if (!userMenu.contains(e.target)) {
            menu.style.display = "none";
        }
    });
});


//Se esconde al hacer scroll hacia abajo y aparece al subir
const nav = document.querySelector('.nav');
let prevScrollPos = window.pageYOffset; // Posición de scroll anterior
const navHeight = nav.offsetHeight; // Altura actual del menú (aproximadamente 85px con tu padding)

window.onscroll = function() {
    const currentScrollPos = window.pageYOffset;

    // --- Lógica para mostrar/esconder ---
    if (prevScrollPos > currentScrollPos) {
        // SCROLL HACIA ARRIBA: Mostrar menú (ajustar top a 0)
        nav.style.top = "0"; 
        nav.classList.remove('hidden-nav');
    } else {
        // SCROLL HACIA ABAJO: Esconder menú (moverlo fuera)
        // Solo esconde si ya ha pasado la altura del menú para evitar un salto inicial
        if (currentScrollPos > navHeight + 20) { // +20 es un margen de seguridad
            nav.style.top = `-${navHeight}px`; // O usa nav.classList.add('hidden-nav');
            nav.classList.add('hidden-nav'); // Añade la clase que lo empuja fuera de la vista
        }
    }
    
    // --- Lógica de cambio de estilo (clase 'active') ---
    if (currentScrollPos > 50) {
        nav.classList.add('active');
    } else {
        nav.classList.remove('active');
    }

    prevScrollPos = currentScrollPos; // Actualizar posición para el siguiente ciclo
}

//menu responsive
