let loaderShown = false;

// Muestra loader solo si la página tarda más de 400ms en cargar
const showLoaderTimeout = setTimeout(() => {
    loaderShown = true;
    document.getElementById('loader').style.display = 'flex';
}, 400);

// Cuando la página haya cargado completamente
window.addEventListener("load", () => {
    clearTimeout(showLoaderTimeout);

    // Si el loader sí se alcanzó a mostrar, empieza animación
    if (loaderShown) {
        startLoaderAnimation();
    }
});

function startLoaderAnimation() {
    const loadingText = document.querySelector('.loading-text');
    const progress = document.querySelector('.progress');
    let dots = '', progressWidth = 0;

    const textInterval = setInterval(() => {
        loadingText.textContent = 'Cargando' + (dots = dots.length < 3 ? dots + '.' : '');
    }, 500);

    const progressInterval = setInterval(() => {
        progress.style.width = (progressWidth += 2) + '%';

        if (progressWidth >= 100) {
            clearInterval(textInterval);
            clearInterval(progressInterval);
            loadingText.textContent = '¡Carga completada!';
            document.querySelector('.loader').style.display = 'none';

            setTimeout(() => {
                // Si quieres, AQUÍ puedes redirigir
                // window.location.href = "alumno.php";
            }, 400);
        }
    }, 100);
}
