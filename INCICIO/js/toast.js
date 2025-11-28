document.addEventListener("DOMContentLoaded", () => {
    const toast = document.getElementById("toast");
    if (toast) {
        toast.classList.add("show");

        // Desaparece después de 3 segundos
        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }
});

// Eliminar el parámetro 'msg' de la URL después de mostrar la notificación
if (window.history.replaceState) {
    const url = new URL(window.location);
    url.searchParams.delete('msg');
    window.history.replaceState({}, '', url);
}
