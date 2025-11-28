const modal = document.getElementById("modalOverlay");
const abrir = document.getElementById("btnAbrirFormulario");
const cerrar = document.getElementById("btnCerrarModal");

abrir.addEventListener("click", () => {
    modal.style.display = "flex";
});

cerrar.addEventListener("click", () => {
    modal.style.display = "none";
});

modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
});
