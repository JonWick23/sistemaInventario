const tbody = tabla.querySelector("tbody");
const noResultados = document.createElement("tr");
noResultados.innerHTML = `<td colspan="${tabla.querySelectorAll("th").length}" style="text-align:center; color:#888;">No se encontraron resultados</td>`;

input.addEventListener("keyup", () => {
  const texto = input.value.toLowerCase().trim();
  let coincidencias = 0;

  filas.forEach(fila => {
    const contenido = fila.textContent.toLowerCase();
    const visible = contenido.includes(texto);
    fila.style.display = visible ? "" : "none";
    if (visible) coincidencias++;
  });

  if (coincidencias === 0) {
    if (!tbody.contains(noResultados)) tbody.appendChild(noResultados);
  } else {
    if (tbody.contains(noResultados)) tbody.removeChild(noResultados);
  }
});
